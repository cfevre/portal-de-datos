<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Participacion
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Participacion extends EntityRepository{
	//Busca las participaciones con el orden y los filtros dados
	public function findWithOrdering($options = null){
		$qb = $this->_em->createQueryBuilder();

		$qb->from('Entities\Participacion', 'p');

		if(isset($options['total'])){

			$qb->select('COUNT(p.id)');

		}else{

			$qb->select('p');
            $qb->addOrderBy('p.'.$options['orderby'], $options['orderdir']);
		}
		
		if(isset($options['publicado'])){
			//$qb->where('p'.$options['orderby'].'='.$options['publicado']);
			$qb->where('p.publicado = '.$options['publicado']);
		}

		if(isset($options['total'])){

			return $qb->getQuery()->getSingleScalarResult();

		}else{
            if(!isset($options['excel'])){
                $qb->setFirstResult($options['offset'])
                    ->setMaxResults($options['limit']);
            }
			$query = $qb->getQuery();

			return $query->getResult();

		}
	}
	//Busca a los usuarios que se le deben enviar mail
	public function userMailSend($institucion){
		$rsm = new ResultSetMapping;
		$rsm->addEntityResult('Entities\User', 'u');
		$rsm->addFieldResult('u', 'id', 'id');
		$rsm->addFieldResult('u', 'email', 'email');

		$query = $this->_em->createNativeQuery('SELECT u.id, u.email 
												FROM servicio s, entidad e , users u 
												WHERE s.entidad_codigo = e.codigo 
												AND u.servicio_codigo = s.codigo 
												AND e.codigo = ?', $rsm);
		$query->setParameter(1, $institucion);

		$users = $query->getResult();

		return $users;
	}
	//Indica cual es la cantidad de solicitudes que tienen pendiente el usuario
	public function solicitudPendiente($codigoUsuario){
		$qb = $this->_em->createQueryBuilder();

		$qb->from('Entities\Participacion', 'p');
		$qb->select('COUNT(p.publicado)');
		$qb->where('p.institucion = :codigousuario');
		$qb->andwhere('p.publicado = 0');
		$qb->setParameter('codigousuario',$codigoUsuario);

		$query = $qb->getQuery();

		$solicitud=$query->getResult();

		return $solicitud;
	}
	//Indica la cantidad de usuarios suscritos a la solicitud
	public function subscriptionCount($ParticipacionId){
		$qb = $this->_em->createQueryBuilder();

		$qb->from('Entities\Suscripcion', 's');
		$qb->select('COUNT(s.participacion_id)');
		$qb->where('s.participacion_id = :participacionId');
		$qb->setParameter('participacionId',$ParticipacionId);

		$query = $qb->getQuery();

		$suscripcion=$query->getResult();

		return $suscripcion;
	}
	//Select a todos los suscritos de la solicitud
	public function selectSubscription($ParticipacionId){
		$qb = $this->_em->createQueryBuilder();

		$qb->from('Entities\Suscripcion', 's');
		$qb->select('DISTINCT(s.email)');
		$qb->where('s.participacion_id = :participacionId');
		$qb->setParameter('participacionId',$ParticipacionId);

		$query = $qb->getQuery();

		$suscripcion=$query->getResult();

		return $suscripcion;
	}
	//Muestra al usuario cual es la publicación que se encuentra pendiente
	public function iluminacionPendiente(){
		$qb = $this->_em->createQueryBuilder();

		$qb->from('Entities\Participacion', 'p');
		$qb->select('p.publicado');
		$qb->where('p.institucion = :codigousuario');
		$qb->andwhere('p.publicado = 0');
		$qb->setParameter('codigousuario',$codigoUsuario);

		$query = $qb->getQuery();
		$solicitud=$query->getResult();

		return $solicitud;
	}
	//Indica los usuarios suscritos a la solicitud 
	public function subscriptionMail($ParticipacionId){
		$qb = $this->_em->createQueryBuilder();

		$qb->from('Entities\Suscripcion', 's');
		$qb->select('DISTINCT(s.email)');
		$qb->where('s.participacion_id = :participacionId');
		$qb->setParameter('participacionId',$ParticipacionId);

		$query = $qb->getQuery();

		return $query->getResult();
	}
}