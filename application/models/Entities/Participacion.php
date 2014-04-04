<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Participacion
 */
class Participacion
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
     * @var string $apellidos
     */
    private $apellidos;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var string $titulo
     */
    private $titulo;

    /**
     * @var string $categoria
     */
    private $categoria;

    /**
     * @var text $mensaje
     */
    private $mensaje;

    /**
     * @var boolean $publicado
     */
    private $publicado;

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
     * @return Participacion
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
     * Set apellidos
     *
     * @param string $apellidos
     * @return Participacion
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Participacion
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Participacion
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
     * Set categoria
     *
     * @param string $categoria
     * @return Participacion
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * Get categoria
     *
     * @return string 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set mensaje
     *
     * @param text $mensaje
     * @return Participacion
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
        return $this;
    }

    /**
     * Get mensaje
     *
     * @return text 
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set publicado
     *
     * @param boolean $publicado
     * @return Participacion
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
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Participacion
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
     * @return Participacion
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
		 * Custom Methods
     */

    public function validate(){
    	$errors = array();

			if(!$this->getNombre())
				$errors[] = 'Debe ingresar un nombre.';
			if(!$this->getApellidos())
				$errors[] = 'Debe ingresar al menos un apellido.';
			if(!$this->getEmail())
				$errors[] = 'Debe un E-mail.';
			elseif(!filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL))
				$errors[] = 'Debe un E-mail válido.';
			if(!$this->getTitulo())
				$errors[] = 'Debe ingresar un asunto.';
			if(!$this->getCategoria())
				$errors[] = 'Debe seleccionar una categoría.';
			if(!$this->getMensaje())
				$errors[] = 'Debe ingresar un mensaje.';

			return $errors;
    }

}