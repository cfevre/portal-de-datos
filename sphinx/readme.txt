Antes de lanzar el demonio sphinx, se debe preparar la configuracion. Para ello
dentro de la subcarpeta etc, renombrar sphinx.conf.sample a sphinx.conf y
modificar los parametros de conexión a la base de datos.


Para lanzar demonio sphinx:

1.- Posicionarse en esta carpeta. Ej: cd ./sphinx
2.- Ejecutar el comando: searchd


Para detener demonio sphinx:

1.- Posicionarse en esta carpeta. Ej: cd ./sphinx
2.- Ejecutar el comando: searchd --stop


Para reindexar contenidos:

1.- Posicionarse en esta carpeta. Ej: cd ./sphinx
2.- Ejecutar el comando: indexer --rotate --all