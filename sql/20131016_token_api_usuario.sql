ALTER TABLE  `users` ADD  `api_token` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `reset_expiration` ,
ADD INDEX (  `api_token` );