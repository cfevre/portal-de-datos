<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Descarga
 */
class Descarga
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var date $fecha
     */
    private $fecha;

    /**
     * @var integer $count
     */
    private $count;

    /**
     * @var Entities\Recurso
     */
    private $recurso;


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
     * Set fecha
     *
     * @param date $fecha
     * @return Descarga
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * Get fecha
     *
     * @return date 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return Descarga
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set recurso
     *
     * @param Entities\Recurso $recurso
     * @return Descarga
     */
    public function setRecurso(\Entities\Recurso $recurso = null)
    {
        $this->recurso = $recurso;
        return $this;
    }

    /**
     * Get recurso
     *
     * @return Entities\Recurso 
     */
    public function getRecurso()
    {
        return $this->recurso;
    }
}