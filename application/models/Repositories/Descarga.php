<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;

/**
 * Descarga
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Descarga extends EntityRepository{

	/*Obtiene un arreglo con las estadisticas de las descargas asociadas a un dataset*/
	public function getEstadisticaOfDataset($dataset){
		$lastdate = now();
    $firstdate = strtotime('-15 day', $lastdate);
    $firstdate_mysql = date('Y-m-d', $firstdate);

    $qb = $this->_em->createQueryBuilder();

    $qb->select('descarga.fecha, sum(descarga.count) AS ndescargas')
    	 ->from('Entities\Descarga', 'descarga')
    	 ->leftJoin('descarga.recurso', 'recurso');

    if($dataset->getMaestro()){

    	$qb->leftJoin('recurso.dataset', 'versiondataset')
    		 ->leftJoin('versiondataset.datasetMaestro', 'dataset');

    }else{

			$qb->leftJoin('recurso.dataset', 'dataset');

    }

    $qb->where('dataset.id = :datasetid and descarga.fecha >= :firstdate');
    $qb->setParameters(array(
    		'datasetid' => $dataset->getId(),
    		'firstdate' => $firstdate_mysql
    	));
    
    $qb->groupBy('descarga.fecha');

    $query = $qb->getQuery();

    return $query->getArrayResult();
	}

	public function getByRecursoAndFecha($recursoId, $fecha){
		$qb = $this->_em->createQueryBuilder();

		$qb->select('d')
			 ->from('Entities\Descarga', 'd')
			 ->leftJoin('d.recurso', 'r')
			 ->where('r.id = :recursoid AND d.fecha = :fecha')
			 ->setParameters(array(
			 		'recursoid' => $recursoId,
			 		'fecha' => $fecha
			 	))
			 ->setMaxResults(1);

		$descarga = $qb->getQuery()->getResult();

		if($descarga)
			return $descarga[0];
		else
			return false;
	}
}