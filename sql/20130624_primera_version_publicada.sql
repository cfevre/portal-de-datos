ALTER TABLE dataset ADD primera_version_publicada INT(11) NULL DEFAULT NULL;
ALTER TABLE dataset ADD CONSTRAINT `fk_primera_version_publicada` FOREIGN KEY (`primera_version_publicada`) REFERENCES `dataset` (`id`) ON DELETE CASCADE;

--SE MARCA LA FECHA DE LA PRIMERA PUBLICACION DE CADA DATASET
UPDATE dataset dm
LEFT JOIN (
    SELECT v.maestro_id AS id_maestro, v.id AS id_version, MIN(v.publicado_at) AS fecha_primera_publicacion
    FROM dataset v 
    WHERE v.publicado_at IS NOT NULL 
    GROUP BY v.maestro_id
) AS dv ON dv.id_maestro = dm.id
SET dm.primera_version_publicada = dv.id_version