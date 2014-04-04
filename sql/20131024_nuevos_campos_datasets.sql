ALTER TABLE  `dataset` ADD  `coordenadas` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `id`;

ALTER TABLE  `dataset` CHANGE  `servicio_codigo`  `servicio_codigo` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE  `dataset` ADD  `doc_id` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  'Id del documento en Snit',
ADD INDEX (  `doc_id` )