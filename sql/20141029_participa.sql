ALTER TABLE `participacion` ADD `edad` INT NULL AFTER `email`;
ALTER TABLE `participacion` ADD `region` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `edad`;
ALTER TABLE `participacion` ADD `ocupacion` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `region`;
ALTER TABLE `participacion` ADD `institucion` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `mensaje`;
ALTER TABLE `participacion` CHANGE `categoria` `categoria` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
