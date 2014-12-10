<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Descarga
 */
class EmailReminder
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $id_participacion
     */
    private $id_participacion;

    /**
     * @var string $titulo
     */
    private $titulo;

    /**
     * @var string $descripcion
     */
    private $descripcion;

    /**
     * @var string $institucion
     */
    private $institucion;

    /**
     * @var string $categoria
     */
    private $categoria;

     /**
     * @var date $created_at
     */
    private $created_at;


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
     * Set id_participacion
     *
     * @param integer $id_participacion
     * @return EmailReminder
     */
    public function setIdParticipacion($idParticipacion)
    {
        $this->id_participacion = $idParticipacion;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getIdParticipacion()
    {
        return $this->id_participacion;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return EmailReminder
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return EmailReminder
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
     * Set institucion
     *
     * @param string $institucion
     * @return EmailReminder
     */
    public function setInstitucion($institucion)
    {
        $this->institucion = $institucion;
        return $this;
    }

    /**
     * Get institucion
     *
     * @return string 
     */
    public function getInstitucion()
    {
        return $this->institucion;
    }
     /**
     * Set created_at
     *
     * @param date $createdAt
     * @return EmailReminder
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
        return $this;
    }

    /**
     * Get created_at
     *
     * @return date
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function institucion($entidades){
            $strInstitucion='';
            foreach ($entidades as $key => $entidad) { 
                     if ($entidad->getCodigo() == $this->getInstitucion()) { 
                         $strInstitucion=$entidad->getNombre();
                     }
                 }
        return $strInstitucion;
    }
}