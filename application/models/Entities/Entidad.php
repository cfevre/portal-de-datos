<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria as Criteria;

/**
 * Entities\Entidad
 */
class Entidad
{
    /**
     * @var string $codigo
     */
    private $codigo;

    /**
     * @var string $nombre
     */
    private $nombre;

    /**
     * @var string $sigla
     */
    private $sigla;

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
    private $servicio;

    public function __construct()
    {
        $this->servicio = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Entidad
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Entidad
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
     * Set sigla
     *
     * @param string $sigla
     * @return Entidad
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
        return $this;
    }

    /**
     * Get sigla
     *
     * @return string 
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Entidad
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
     * @return Entidad
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
     * Add servicio
     *
     * @param \Entities\Servicio $servicio
     * @return Entidad
     */
    public function addServicio(\Entities\Servicio $servicio)
    {
        $this->servicio[] = $servicio;
        return $this;
    }

    /**
     * Get servicio
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    public function getTotalDatasets()
    {
        $total = 0;
        $servicios = $this->getServicio();
        foreach ($servicios as $servicio) {
            $total += $servicio->getDataset()->count();
        }
        return $total;
    }

    /**
     * Obtiene los servicios publicados de la entidad
     *
     * @return Array
     */
    public function getServiciosPublicados(){
        $publicados = array();

        foreach ($this->getServicio() as $servicio) {
            if($servicio->getPublicado())
                $publicados[] = $servicio;
        }

        return $publicados;
    }
}