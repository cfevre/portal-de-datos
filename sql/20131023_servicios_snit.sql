ALTER TABLE  `servicio` ADD  `publicado` BOOLEAN NULL DEFAULT NULL AFTER  `url` ,
ADD  `codigo_servicio_oficial` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `publicado` ,
ADD INDEX (  `codigo_servicio_oficial` );

ALTER TABLE  `servicio` ADD FOREIGN KEY (  `codigo_servicio_oficial` ) REFERENCES  `datos`.`servicio` (
`codigo`
) ON DELETE CASCADE ON UPDATE CASCADE ;

UPDATE servicio SET publicado = 1;

ALTER TABLE  `servicio` ADD  `oficial` BOOLEAN NULL DEFAULT NULL AFTER  `publicado`;
UPDATE servicio SET oficial = 1;