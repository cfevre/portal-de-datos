<?php
    $headers = "id\ttítulo\testado\tdescripción\tministerio\tinstitución\tlicencia\tetiquetas\tfrecuancia de actualización\tcobertura geográfica\tgranularidad\tcategorias\tfecha publicación";
    $body = "";

    //Primera fecha de descarga de algun recurso 2011-09
    $meses = stringsHelper::get_months('2011-09',date('Y-m'));
    //Se agregan los meses de las descargas a los encabezados
    $headers .= "\t".implode("\t", $meses);
    //Se agrega el total de las descargas
    $headers .= "\ttotal descargas";
    //Se agregan los meses de las vistas a los encabezados
    $headers .= "\t".implode("\t", $meses);
    //Se agrega el total de las vistas
    $headers .= "\ttotal vistas";
    $headers .= "\n";

    foreach ($datasets as $dataset) {
        $a_tags = $a_sectores = $a_categorias = array();
        foreach ($dataset->getTags() as $key => $tag){
            $a_tags[] = $tag->getNombre();
        }
        $tags = (count($a_tags)?implode(',', $a_tags):'');

        foreach ($dataset->getSectores() as $key => $sector){
            $a_sectores[] = $sector->getNombre();
        }
        $sectores = (count($a_sectores)?implode(',', $a_sectores):'');

        foreach ($dataset->getCategorias() as $key => $categoria){
            $a_categorias[] = $categoria->getNombre();
        }
        $categorias = (count($a_categorias)?implode(',', $a_categorias):'');
        
        $descripcion = preg_replace('/^\s+|\n|\r|\s+$/m', '', strip_tags($dataset->getDescripcion()));

        $line = $dataset->getId()."\t".
                $dataset->getTitulo()."\t".
                ($dataset->getPublicado()?'publicado':'no publicado')."\t".
                $descripcion."\t".
                $dataset->getServicio()->getEntidad()->getNombre()."\t".
                $dataset->getServicio()->getNombre()."\t".
                $dataset->getLicencia()->getNombre()."\t".
                $tags."\t".
                $dataset->getFrecuencia()."\t".
                $sectores."\t".
                $dataset->getGranularidad()."\t".
                $categorias."\t";

        //Fecha de publicación
        if($dataset->getPrimeraVersionPublicada())
            $line .= $dataset->getPrimeraVersionPublicada()->getCreatedAt()->format('Y-m-d')."\t";
        else
            $line .= "\t";

        //Se recorren los meses y se calculan las descargas por cada uno
        $total_descargas = 0;
        foreach ($meses as $mes) {
            if(isset($descargas_por_mes[$mes][$dataset->getId()]['total_descargas'])){
                $line .= $descargas_por_mes[$mes][$dataset->getId()]['total_descargas'];
                $total_descargas += (int)$descargas_por_mes[$mes][$dataset->getId()]['total_descargas'];
            }

            $line .= "\t";
        }
        $line .= $total_descargas."\t"; //Se agrega el total de las descargas

        //Se recorren los meses y se calculan las vistas por cada uno
        $total_vistas = 0;
        foreach ($meses as $mes) {
            if(isset($vistas_por_mes[$mes][$dataset->getId()]['total_vistas'])){
                $line .= $vistas_por_mes[$mes][$dataset->getId()]['total_vistas'];
                $total_vistas += (int)$vistas_por_mes[$mes][$dataset->getId()]['total_vistas'];
            }

            $line .= "\t";
        }
        $line .= $total_vistas; //Se agrega el total de las vistas

        $body .= $line."\n";
    }

    echo $headers.$body;
?>