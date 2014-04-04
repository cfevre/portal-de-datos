<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Noticia
 */
class Noticia
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $titulo
     */
    private $titulo;

    /**
     * @var text $resumen
     */
    private $resumen;

    /**
     * @var text $contenido
     */
    private $contenido;

    /**
     * @var string $foto
     */
    private $foto;

    /**
     * @var boolean $publicado
     */
    private $publicado;

    /**
     * @var datetime $publicado_at
     */
    private $publicado_at;

    /**
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     */
    private $updated_at;


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
     * Set titulo
     *
     * @param string $titulo
     * @return Noticia
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set resumen
     *
     * @param text $resumen
     * @return Noticia
     */
    public function setResumen($resumen)
    {
        $this->resumen = $resumen;
        return $this;
    }

    /**
     * Get resumen
     *
     * @return text 
     */
    public function getResumen()
    {
        return $this->resumen;
    }

    /**
     * Set contenido
     *
     * @param text $contenido
     * @return Noticia
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
        return $this;
    }

    /**
     * Get contenido
     *
     * @return text 
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set foto
     *
     * @param string $foto
     * @return Noticia
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
        return $this;
    }

    /**
     * Get foto
     *
     * @return string 
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set publicado
     *
     * @param boolean $publicado
     * @return Noticia
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
     * Set publicado_at
     *
     * @param datetime $publicadoAt
     * @return Noticia
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

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Noticia
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
     * @return Noticia
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
}