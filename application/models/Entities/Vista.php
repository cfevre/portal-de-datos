<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Vista
 */
class Vista
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
     * @var Entities\Dataset
     */
    private $dataset;


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
     * @return Vista
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
     * @return Vista
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
     * Set dataset
     *
     * @param Entities\Dataset $dataset
     * @return Vista
     */
    public function setDataset(\Entities\Dataset $dataset = null)
    {
        $this->dataset = $dataset;
        return $this;
    }

    /**
     * Get dataset
     *
     * @return Entities\Dataset 
     */
    public function getDataset()
    {
        return $this->dataset;
    }
}