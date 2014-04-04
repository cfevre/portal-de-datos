<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Contacto
 */
class Contacto
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
     * @var text $email
     */
    private $email;

    /**
     * @var string $asunto
     */
    private $asunto;

    /**
     * @var text $comentarios
     */
    private $comentarios;

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
     * Set nombre
     *
     * @param string $nombre
     * @return Contacto
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
     * Set email
     *
     * @param text $email
     * @return Contacto
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return text 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set asunto
     *
     * @param string $asunto
     * @return Contacto
     */
    public function setAsunto($asunto)
    {
        $this->asunto = $asunto;
        return $this;
    }

    /**
     * Get asunto
     *
     * @return string 
     */
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * Set comentarios
     *
     * @param text $comentarios
     * @return Contacto
     */
    public function setComentarios($comentarios)
    {
        $this->comentarios = $comentarios;
        return $this;
    }

    /**
     * Get comentarios
     *
     * @return text 
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Contacto
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
     * @return Contacto
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