<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria as Criteria;

/**
 * Entities\Servicio
 */
class Servicio
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
     * @var string $url
     */
    private $url;

    /**
     * @var boolean $publicado
     */
    private $publicado;

    /**
     * @var boolean $oficial
     */
    private $oficial;

    /**
     * @var string $codigo_servicio_oficial
     */
    private $codigo_servicio_oficial;

    /**
     * @var boolean $servicioOficial
     */
    private $servicioOficial;

    /**
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     */
    private $updated_at;

    /**
     * @var string $entidad_codigo
     */
    private $entidad_codigo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $dataset;

    /**
     * @var Entities\Entidad
     */
    private $entidad;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $participacion;

    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dataset = new \Doctrine\Common\Collections\ArrayCollection();
        $this->participacion = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Servicio
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
     * @return Servicio
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
     * @return Servicio
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
     * Set url
     *
     * @param string $url
     * @return Servicio
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set oficial
     *
     * @param boolean $oficial
     * @return Servicio
     */
    public function setOficial($oficial)
    {
        $this->oficial = $oficial;
        return $this;
    }

    /**
     * Get oficial
     *
     * @return boolean
     */
    public function getOficial()
    {
        return $this->oficial;
    }

    /**
     * Set publicado
     *
     * @param boolean $publicado
     * @return Servicio
     */
    public function setPublicado($publicado)
    {
        $this->publicado = $publicado;
        return $this;
    }

    /**
     * Get publicado
     *
     * @return boolean
     */
    public function getPublicado()
    {
        return $this->publicado;
    }

    /**
     * Set codigo_servicio_oficial
     *
     * @param string $codigo_servicio_oficial
     * @return Servicio
     */
    public function setCodigoServicioOficial($codigo_servicio_oficial)
    {
        $this->codigo_servicio_oficial = $codigo_servicio_oficial;
        return $this;
    }

    /**
     * Get codigo_servicio_oficial
     *
     * @return string
     */
    public function getCodigoServicioOficial()
    {
        return $this->codigo_servicio_oficial;
    }

    /**
     * Set setservicioOficial
     *
     * @param Entities\Servicio $servicioOficial
     * @return Servicio
     */
    public function setServicioOficial(\Entities\Servicio $servicioOficial = null)
    {
        $this->servicioOficial = $servicioOficial;
        return $this;
    }

    /**
     * Get servicioOficial
     *
     * @return Entities\Servicio
     */
    public function getServicioOficial()
    {
        return $this->servicioOficial;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Servicio
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
     * @return Servicio
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
     * Set entidad_codigo
     *
     * @param string $entidadCodigo
     * @return Servicio
     */
    public function setEntidadCodigo($entidadCodigo)
    {
        $this->entidad_codigo = $entidadCodigo;
        return $this;
    }

    /**
     * Get entidad_codigo
     *
     * @return string 
     */
    public function getEntidadCodigo()
    {
        return $this->entidad_codigo;
    }

    /**
     * Add user
     *
     * @param Entities\User $user
     * @return Servicio
     */
    public function addUser(\Entities\User $user)
    {
        $this->user[] = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add dataset
     *
     * @param Entities\Dataset $dataset
     * @return Servicio
     */
    public function addDataset(\Entities\Dataset $dataset)
    {
        $this->dataset[] = $dataset;
        return $this;
    }

    /**
     * Get dataset
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDataset()
    {
        return $this->dataset;
    }

    /**
     * Set entidad
     *
     * @param Entities\Entidad $entidad
     * @return Servicio
     */
    public function setEntidad(\Entities\Entidad $entidad = null)
    {
        $this->entidad = $entidad;
        return $this;
    }

    /**
     * Get entidad
     *
     * @return Entities\Entidad 
     */
    public function getEntidad()
    {
        return $this->entidad;
    }

    /**
     * Obtiene los datasets maestros asociados al servicio
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getDatasetsMaestros(){
        $criteria = Criteria::create();

        $criteria->where(Criteria::expr()->eq('maestro', 1));

        return $this->getDataset()->matching($criteria);
    }

    /**
     * Alias para la función getOficial
     *
     * @return boolean
     */
    public function esOficial()
    {
        return $this->oficial;
    }

    /**
     * @return array
     */
    public function validate()
    {
        $errors = array();
        if(!$this->getCodigo())
            $errors[] = 'Debe ingresar un codigo para el servicio.';
        if(!$this->getNombre())
            $errors[] = 'Debe ingresar un nombre para el servicio.';
        if(!$this->getEntidad())
            $errors[] = 'Debe seleccionar una entidad para el servicio.';

        return $errors;
    }
}