--
-- Estructura de tabla para la tabla `vista`
--

CREATE TABLE IF NOT EXISTS `vista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dataset_id` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D1CF61CED47C2D1B` (`dataset_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `vista`
--
ALTER TABLE `vista`
  ADD CONSTRAINT `FK_D1CF61CED47C2D1B` FOREIGN KEY (`dataset_id`) REFERENCES `dataset` (`id`) ON DELETE CASCADE;