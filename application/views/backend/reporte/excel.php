<?php
    $headers = "id\tid dataset\ttítulo dataset\tinstitución\ttipo de reporte\tgrado del reporte\testado\tfecha de ingreso\tfecha de actualización\ttiempo de actualización\n";
    $body = "";
    foreach ($reportes as $reporte) {

        $line = $reporte->getId()."\t".
                $reporte->getDataset()->getId()."\t".
                $reporte->getDataset()->getTitulo()."\t".
                $reporte->getDataset()->getServicio()->getNombre()."\t".
                $reporte->getTipoReporte()->getTitulo()."\t".
                $reporte->getTipoReporte()->getGradoReporte()->getNombre()."\t".
                $reporte->getEstado(true)."\t".
                $reporte->getCreatedAt()->format('d/m/Y H:i')."\t".
                ($reporte->getUpdatedAt()?$reporte->getUpdatedAt()->format('d/m/Y H:i'):'')."\t".
                ($reporte->getUpdatedAt()?$reporte->getCreatedAt()->diff($reporte->getUpdatedAt())->format('%R%a dias'):'')."\n";


        $body .= $line;
    }

    echo $headers.$body;
?>