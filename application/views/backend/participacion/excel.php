<?php
    $headers = "id\ttitulo\tnombre\tapellido\temail\tmensaje\tcategoría\testado\tfecha de creación\n";
    $body = "";
    foreach ($participaciones as $participacion) {
        $mensaje = preg_replace('/^\s+|\n|\r|\s+$/m', '', strip_tags($participacion->getMensaje()));
        $line = $participacion->getId()."\t".
                $participacion->getTitulo()."\t".
                $participacion->getNombre()."\t".
                $participacion->getApellidos()."\t".
                $participacion->getEmail()."\t".
                $mensaje."\t".
                $participacion->getCategoria()."\t".
                ($participacion->getPublicado()?'publicado':'no publicado')."\t".
                $participacion->getUpdatedAt()->format('d/m/Y H:i')."\n";


        $body .= $line;
    }

    echo $headers.$body;
?>