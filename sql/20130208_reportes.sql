--
-- Estructura de tabla para la tabla `grado_reporte`
--

CREATE TABLE IF NOT EXISTS `grado_reporte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE IF NOT EXISTS `reporte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_reporte_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dataset_id` int(11) DEFAULT NULL,
  `estado` varchar(1) NOT NULL,
  `origen_publico` tinyint(1) DEFAULT 0,
  `comentarios` longtext DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5CB121498AAA75A` (`tipo_reporte_id`),
  KEY `IDX_5CB1214A76ED395` (`user_id`),
  KEY `IDX_5CB1214D47C2D1B` (`dataset_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_reporte`
--

CREATE TABLE IF NOT EXISTS `tipo_reporte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grado_reporte_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `comentario_sugerido` longtext NOT NULL,
  `publico` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_163233B42679C92` (`grado_reporte_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD CONSTRAINT `FK_5CB1214D47C2D1B` FOREIGN KEY (`dataset_id`) REFERENCES `dataset` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5CB121498AAA75A` FOREIGN KEY (`tipo_reporte_id`) REFERENCES `tipo_reporte` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5CB1214A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tipo_reporte`
--
ALTER TABLE `tipo_reporte`
  ADD CONSTRAINT `FK_163233B42679C92` FOREIGN KEY (`grado_reporte_id`) REFERENCES `grado_reporte` (`id`) ON DELETE CASCADE;

-- Grados de reporte iniciales
INSERT INTO `grado_reporte` (`nombre`) VALUES
('Observación'),
('Prioritario'),
('Ciudadano');

-- Tipos de reporte iniciales
INSERT INTO `tipo_reporte` (`grado_reporte_id`, `titulo`, `comentario_sugerido`, `publico`) VALUES
(1, 'Mejorar título de dataset', 'Se recomienda mejorar el título del Dataset, este debe explicar de manera generalizada la totalidad de lo que se está publicado, y, a la vez, ser específico al contenido del Dataset, es decir, si la información se encuentra relacionada a un año o ubicación en particular, esto debería estar descrito. De la misma forma, se solicita no escribir siglas sin su significado.<div><span  20px;"><br></span></div><div>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda&nbsp;<a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a>&nbsp;.</div>', 0),
(1, 'Mejorar descripción de dataset', 'Se solicita mejorar la descripción de su dataset. Esta debe describir de forma clara el contenido de lo publicado, agregando información complementaría que ayude a conocer su contexto, por ejemplo, la manera como se obtuvo la información, definición de nomenclatura en el caso que sea necesario, entre otros.<p><span 20px;"=""><br></span>&nbsp;\n</p><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda <a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a> .</p><p></p>\n', 0),
(1, 'Agregar licencias', 'Se solicita agregar una licencia a su publicación, la &nbsp;cual permita a los usuarios compartir y usar la información publicada bajo términos y condiciones de su elección. Se recuerda que este es un campo obligatorio dentro de los Metadatos. En el siguiente enlace <a href="http://instituciones.gobiernoabierto.cl/documentos-de-ayuda/licencias.html">http://instituciones.gobiernoabierto.cl/documentos-de-ayuda/licencias.html</a> podrá encontrar información sobre las distintas licencias que puede elegir.\n<p><br></p><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda <a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a> .</p>\n', 0),
(1, 'Agregar categorias', 'Se solicita completar el campo Categorías a su publicación, las cuales deben estar relacionadas con la información publicada. Se recuerda que este es un campo obligatorio dentro de los Metadatos.<p><br></p><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda <a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a> .</p>', 0),
(1, 'Agregar etiquetas', 'Se recomienda agregar una o más etiquetas a su publicación, las cuales deben hacer mención específica sobre lo que trata lo publicado.\n<p><br></p><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda <a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a> .</p>', 0),
(1, 'Agregar frecuencia de actualización', 'Se recomienda indicar la frecuencia de la actualización de su publicación.\n<p><br></p><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda <a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a> .</p>', 0),
(1, 'Agregar cobertura geográfica', 'Se recomienda agregar una o más coberturas geográficas a su publicación. En caso de ser información a nivel país, se debe especificar “Chile”\n<p><br></p><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda <a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a> .</p>', 0),
(1, 'Agregar granularidad', 'Se recomienda completar el campo Granularidad de su dataset, el cual tiene por objetivo indicar el nivel mínimo de detalle o más reducido del contenido de la publicación.<p><br></p><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda <a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a> .</p>', 0),
(2, 'Error en URL del recurso', 'Se solicita revisar la URL contenida en el recurso debido a que el link indicado se encuentra roto, no esta actualizado o no corresponde.<div><span  20px;"><br></span></div><div>Para lo anterior tienen un plazo de 1 semana desde la fecha de aviso, en el caso que el problema persista, el dataset será despublicado.&nbsp;&nbsp;<p><br></p><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda <a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a> .</p>\n</div>', 0),
(1, 'Mejorar descripción de los recursos', 'Se solicita mejorar la descripción del recursos pues debe hacer referencia a su contenido y características\nadicionales (por ejemplo, tipo de compresión, versión de algún estándar, etc) necesarias de conocer para su procesamiento.<span  1.5em;">&nbsp;De igual manera, se sugiere que éste no tenga el mismo título que el Dataset.</span><div><p><br></p><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda <a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a> .</p>\n</div>', 0),
(1, 'Error en URL del documento', 'Se solicita revisar la URL contenida en el documento debido a que el link indicado se encuentra roto, no esta actualizado o no corresponde.\n<p><br></p><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda&nbsp;<a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a>&nbsp;.<br></p>', 0),
(1, 'Mejorar título de documentos', 'Se solicita mejorar el o los títulos de la documentación asociada al dataset. Se sugiere que este no tenga el mismo título que el Dataset.\n<p><br></p><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda&nbsp;<a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a>&nbsp;.<br></p>', 0),
(1, 'Mejorar descripción de documentos', 'Se solicita mejorar la descripción del documento pues debe hacer referencia a su contenido, por ejemplo, en el caso de corresponder a información de un cierto periodo temporal o a un punto geográfico, debe ser indicado. De igual manera, se sugiere que éste no tenga el mismo título que el documento o dataset.\n<p><br></p><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda&nbsp;<a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a>&nbsp;.<br></p>', 0),
(2, 'Formato incorrecto de recurso.', 'Se solicita modificar la publicación realizada, dado que el (los) formato(s) de el(los) recurso(s) no cumplen con la Norma Técnica de Publicación de Datos Abiertos para Chile. Por lo cual se pide como primera acción despublicar el dataset, luego modificar el formato del recurso, utilizado los permitidos por el documento mencionado y finalmente volver a publicar. Para mayor información dirígase a la Norma Técnica&nbsp;http://instituciones.gobiernoabierto.cl/documentos-de-ayuda/norma-tecnica-de-publicacion-de-datos-abiertos-de-chile.html .<div><span  20px;"><br></span></div><div><div>Para lo anterior tienen un plazo de 1 semana desde la fecha de aviso, en el caso que el problema persista, el dataset será despublicado.\n</div><p><span  1.5em;">Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda&nbsp;</span><a href="http://soporte.gobiernoabierto.cl/"  1.5em;">http://soporte.gobiernoabierto.cl/</a><span  1.5em;">&nbsp;.</span><br></p></div>', 0),
(2, 'Recurso no es estadístico.', 'Se solicita modificar el dataset publicado, dado que no cumple con el perfil definido para el Portal de Datos Abiertos. Se busca que lo publicado sean datos duros, los cuales puedan ser reutilizados por cualquier persona. En su caso particular, el archivo publicado contiene en su mayoría texto, el cual no está dentro del foco mencionado.<p><span 20px;"=""><br></span>Para lo anterior tienen un plazo de 1 semana desde la fecha de aviso, en el caso que el problema persista, el dataset será despublicado.\n</p><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda&nbsp;<a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a>&nbsp;.<br></p>\n', 0),
(2, 'Mismo dataset que otra institución', 'Se solicita despublicar el dataset y realizar una nueva publicación, esto debido que el contenido de lo publicado es idéntico a lo publicado por otras instituciones.<div><span  20px;"><br></span>Para lo anterior tienen un plazo de 1 semana desde la fecha de aviso, en el caso que el problema persista, el dataset será despublicado.\n</div><p>Para cualquier consulta u observación al respecto debe dirigirse a la mesa de ayuda&nbsp;<a href="http://soporte.gobiernoabierto.cl/">http://soporte.gobiernoabierto.cl/</a>&nbsp;.<br></p>', 0),
(3, 'Formato del recurso no es abierto', '', 1),
(3, 'Error en URL del recurso', '', 1),
(3, 'Mejorar información del dataset', '', 1),
(3, 'Otros', '', 1);