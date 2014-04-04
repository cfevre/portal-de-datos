-- Nuevo campo para asociar los tipos de reporte con campos especificos del dataset
ALTER TABLE  `tipo_reporte` ADD  `campo_dataset` VARCHAR( 255 ) NULL DEFAULT NULL;

UPDATE tipo_reporte SET campo_dataset = 'titulo' WHERE id = 1;
UPDATE tipo_reporte SET campo_dataset = 'descripcion' WHERE id = 2;
UPDATE tipo_reporte SET campo_dataset = 'licencia_id' WHERE id = 3;
UPDATE tipo_reporte SET campo_dataset = 'tags' WHERE id = 5;
UPDATE tipo_reporte SET campo_dataset = 'categorias' WHERE id = 4;
UPDATE tipo_reporte SET campo_dataset = 'frecuencia' WHERE id = 6;
UPDATE tipo_reporte SET campo_dataset = 'sectores' WHERE id = 7;
UPDATE tipo_reporte SET campo_dataset = 'granularidad' WHERE id = 8;
UPDATE tipo_reporte SET campo_dataset = 'recursos' WHERE id = 10;
UPDATE tipo_reporte SET campo_dataset = 'documentos' WHERE id = 13;