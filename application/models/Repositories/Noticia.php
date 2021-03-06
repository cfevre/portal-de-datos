<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;

/**
 * Noticia
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Noticia extends EntityRepository{
	//Busca las noticias con el orden y los filtros dados
	public function findWithOrdering($options = null, $ordering = array('created_at' => 'DESC'), $limit = 4, $offset = 0){
		$qb = $this->_em->createQueryBuilder();

		$qb->from('Entities\Noticia', 'n');

		if(isset($options['total'])){

			$qb->select('COUNT(n.id)');

		}else{

			$qb->select('n');

			foreach ($ordering as $field => $dir) {
				$qb->addOrderBy('n.'.$field, $dir);
			}

		}
		
		if(!isset($options['all']))
			$qb->where('n.publicado = 1');

		//Filtros de busqueda
		if($options){
			
		}

		if(isset($options['total'])){

			return $qb->getQuery()->getSingleScalarResult();

		}else{

			$query = $qb->setFirstResult($offset)
									->setMaxResults($limit)
									->getQuery();

			return $query->getResult();

		}
	}
}