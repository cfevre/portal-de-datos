<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Log
 */
class Log
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var text $descripcion
     */
    private $descripcion;

    /**
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     */
    private $updated_at;

    /**
     * @var Entities\Dataset
     */
    private $datasetMaestro;

    /**
     * @var Entities\Dataset
     */
    private $datasetVersion;

    /**
     * @var Entities\User
     */
    private $usuario;


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
     * Set descripcion
     *
     * @param text $descripcion
     * @return Log
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return text 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Log
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
     * @return Log
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
     * Set datasetMaestro
     *
     * @param Entities\Dataset $datasetMaestro
     * @return Log
     */
    public function setDatasetMaestro(\Entities\Dataset $datasetMaestro = null)
    {
        $this->datasetMaestro = $datasetMaestro;
        return $this;
    }

    /**
     * Get datasetMaestro
     *
     * @return Entities\Dataset 
     */
    public function getDatasetMaestro()
    {
        return $this->datasetMaestro;
    }

    /**
     * Set datasetVersion
     *
     * @param Entities\Dataset $datasetVersion
     * @return Log
     */
    public function setDatasetVersion(\Entities\Dataset $datasetVersion = null)
    {
        $this->datasetVersion = $datasetVersion;
        return $this;
    }

    /**
     * Get datasetVersion
     *
     * @return Entities\Dataset 
     */
    public function getDatasetVersion()
    {
        return $this->datasetVersion;
    }

    /**
     * Set usuario
     *
     * @param Entities\User $usuario
     * @return Log
     */
    public function setUsuario(\Entities\User $usuario = null)
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * Get usuario
     *
     * @return Entities\User 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}