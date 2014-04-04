<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Aplicacion
 */
class Aplicacion
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
     * @var string $acceso
     */
    private $acceso;

    /**
     * @var string $plataforma
     */
    private $plataforma;

    /**
     * @var string $descripcion
     */
    private $descripcion;

    /**
     * @var string $autor
     */
    private $autor;

    /**
     * @var string $url
     */
    private $url;

    /**
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     */
    private $updated_at;
    
    /**
     * @var boolean $publicado
     */
    private $publicado;


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
     * @return Aplicacion
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
     * Set acceso
     *
     * @param string $acceso
     * @return Aplicacion
     */
    public function setAcceso($acceso)
    {
        $this->acceso = $acceso;
        return $this;
    }

    /**
     * Get acceso
     *
     * @return string 
     */
    public function getAcceso()
    {
        return $this->acceso;
    }

    /**
     * Set plataforma
     *
     * @param string $plataforma
     * @return Aplicacion
     */
    public function setPlataforma($plataforma)
    {
        $this->plataforma = $plataforma;
        return $this;
    }

    /**
     * Get plataforma
     *
     * @return string 
     */
    public function getPlataforma()
    {
        return $this->plataforma;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Aplicacion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set autor
     *
     * @param string $autor
     * @return Aplicacion
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;
        return $this;
    }

    /**
     * Get autor
     *
     * @return string 
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Aplicacion
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
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Aplicacion
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
     * @return Aplicacion
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
     * Set publicado
     *
     * @param boolean $publicado
     * @return Aplicacion
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
     * @var datetime $publicado_at
     */
    private $publicado_at;


    /**
     * Set publicado_at
     *
     * @param datetime $publicadoAt
     * @return Aplicacion
     */
    public function setPublicadoAt($publicadoAt)
    {
        $this->publicado_at = $publicadoAt;
        return $this;
    }

    /**
     * Get publicado_at
     *
     * @return datetime 
     */
    public function getPublicadoAt()
    {
        return $this->publicado_at;
    }
}