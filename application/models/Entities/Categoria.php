<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Categoria
 */
class Categoria
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $nombre
     */
    private $nombre;

    /**
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     */
    private $updated_at;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $datasets;
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $participaciones;
    /**
     * @var integer $total_datasets
     */
    private $total_datasets;

    public function __construct()
    {
        $this->datasets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->participaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Categoria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Categoria
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
        return $this;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     * @return Categoria
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Add datasets
     *
     * @param Entities\Dataset $datasets
     * @return Categoria
     */
    public function addDataset(\Entities\Dataset $datasets)
    {
        $this->datasets[] = $datasets;
        return $this;
    }
    /**
     * Get datasets
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDatasets()
    {
        return $this->datasets;
    }

    public function setTotalDatasets($total_datasets = 0)
    {
        $this->total_datasets = $total_datasets;
        return $this;
    }

    public function getTotalDatasets()
    {
        return $this->total_datasets;
    }


    /**
     * Add participaciones
     *
     * @param Entities\Participacion $participaciones
     * @return Categoria
     */
    public function addParticipacion(\Entities\Participacion $participaciones)
    {
        $this->participaciones[] = $participaciones;
        return $this;
    }

    /**
     * Get participaciones
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getParticipacion()
    {
        return $this->participaciones;
    }
}