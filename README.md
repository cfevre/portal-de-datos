Portal de Datos - Gobierno de Chile (Datos.gob.cl)
=================================


## Resumen ##

Esta aplicación permite disponibilizar conjuntos de información de manera fácil en un catálogo de datos (DCAT). La versión base contiene un buscador y puede manejar catálogos con diversas categorías para ayudar la búsqueda de la información. También se puede utilizar con información georeferenciada y archivos de imágenes.
## Objetivo ##

El objetivo de esta aplicación es que las personas tengan acceso a la información de manera simple, apoyando la toma decisiones para las políticas públicas y/o que también la puedan utilizar para sus propias investigaciones e intereses. Por ejemplo, construir aplicaciones y conducir análisis de manera más ágil.

## Ambiente de Ejecución ##

Los usuarios deben ingresar mediante ambiente web, a través de la URL provista por el organismo.

### Plataforma, Framework o Lenguaje de Programación / BBDD ###
* PHP, HTML, Javascript, CSS, MySQL
* Codeigniter 2.1.2
* Twitter Bootstrap 2.1.0
* jQuery 1.8.1

### Requisitos Técnicos ###
PHP >= 5.3.x, MySQL >= 5.5.x

## Tipo de Licencia ##
El código de esta aplicación está licenciado bajo los términos de la Licencia de Software Público (Chile) (más información http://www.softwarepublico.cl).

## Configuración de la plataforma ##

### FRAMEWORK ###
Cambiar el nombre del archivo de configuración del framework que se encuentra dentro de la carpeta "application/config" de "config.sample.php" a "config.php"

### BASE DE DATOS ###
* Crear una base de datos para la plataforma
* Cargar los datos iniciales del archivo "sql/datos_iniciales.sql"
* Cambiar el nombre del archivo de configuración de base de datos que se encuentra dentro de la carpeta "application/config" de "database.sample.php" a "database.php"
* Editar el archivo "database.php" y actualizar los valores con los de su configuración, normalmente se deben editar sólo los campos "username, password, database"


## JUNAR ##
Si posee una cuenta de Junar.com, agregar sus datos en el archivo "config.php".

## TWITTER ##
Si desea utilizar el "stream" de twitter debe ingresar sus datos en el archivo "config.php"
