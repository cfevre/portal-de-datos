<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;

class Categoria extends EntityRepository{
    
    public function getCategoriasConTotales($limit = null)
    {
        $sql = "SELECT c, count(d.id) as ndatasets FROM Entities\Categoria c"
            . " LEFT JOIN c.datasets d"
            . " WHERE d.publicado = 1 AND d.maestro = 0"
            . " GROUP BY c.id"
            . " ORDER BY ndatasets DESC";
        $query = $this->_em->createQuery($sql);
        
        if($limit)
            $query->setMaxResults($limit);

        return $query->getResult();
    }
    public function getTodasCategorias(){
        $sql = "SELECT c FROM Entities\Categoria c";

        $query = $this->_em->createQuery($sql);

        return $query->getResult();
    }

    public function getDatasetMasDescargados($categoria_id, $limit = null)
    {
        $sql = "SELECT d, SUM(des.count) AS cantdescargas FROM Entities\Dataset d"
            . " LEFT JOIN d.categorias c"
            . " LEFT JOIN d.recursos r"
            . " LEFT JOIN r.descargas des"
            . " WHERE d.publicado = 1 AND d.maestro = 0 AND des.fecha > DATE_SUB(CURRENT_TIMESTAMP(), 1, 'MONTH') AND c.id = ".$categoria_id
            . " GROUP BY d.id"
            . " ORDER BY cantdescargas DESC";
        $query = $this->_em->createQuery($sql);
        
        if($limit)
            $query->setMaxResults($limit);

        return $query->getResult();
    }

    /**
     * Obtiene una colección de categorias según un grupo de id
     * @param  string                      $ids ids de las categorias a obtener separadas por coma
     * @return Doctrine\Common\Collections
     */
    public function getByIds($ids)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('c')
             ->from('Entities\Categoria', 'c')
             ->add('where', $qb->expr()->in('c.id', ':ids'))
             ->setParameter('ids', explode(',', $ids));

        $query = $qb->getQuery();

        return $query->getResult();
    }
}