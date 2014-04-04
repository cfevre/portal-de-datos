<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\GradoReporte
 */
class GradoReporte
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $tiposReporte;

    public function __construct()
    {
        $this->tiposReporte = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return GradoReporte
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
     * Add tiposReporte
     *
     * @param Entities\TipoReporte $tiposReporte
     * @return GradoReporte
     */
    public function addTipoReporte(\Entities\TipoReporte $tiposReporte)
    {
        $this->tiposReporte[] = $tiposReporte;
        return $this;
    }

    /**
     * Get tiposReporte
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTiposReporte()
    {
        return $this->tiposReporte;
    }
}