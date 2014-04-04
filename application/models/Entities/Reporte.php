<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Reporte
 */
class Reporte
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $estado
     */
    private $estado;

    /**
     * @var string $origenPublico
     */
    private $origen_publico;

    /**
     * @var text $comentarios
     */
    private $comentarios;

    /**
     * @var string $nombre
     */
    private $nombre;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var Entities\TipoReporte
     */
    private $tipoReporte;

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
     * Set estado
     *
     * @param string $estado
     * @return Reporte
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado($nombre = false)
    {
        $nombres = $this->getTiposDeEstado();
        if($nombre){
            return $nombres[$this->estado];
        }else{
            return $this->estado;    
        }        
    }

    /**
     * Set origenPublico
     *
     * @param string $origenPublico
     * @return Reporte
     */
    public function setOrigenPublico($origenPublico)
    {
        $this->origen_publico = $origenPublico;
        return $this;
    }

    /**
     * Get origenPublico
     *
     * @return string 
     */
    public function getOrigenPublico($nombre = false)
    {
        return $this->origen_publico;
    }

    /**
     * Set comentarios
     *
     * @param text $comentarios
     * @return Reporte
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
     * Set nombre
     *
     * @param string $nombre
     * @return Reporte
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
     * @param string $email
     * @return Reporte
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
     * Set tipoReporte
     *
     * @param Entities\TipoReporte $tipoReporte
     * @return Reporte
     */
    public function setTipoReporte(\Entities\TipoReporte $tipoReporte = null)
    {
        $this->tipoReporte = $tipoReporte;
        return $this;
    }

    /**
     * Get tipoReporte
     *
     * @return Entities\TipoReporte 
     */
    public function getTipoReporte()
    {
        return $this->tipoReporte;
    }
    /**
     * @var Entities\User
     */
    private $usuario;

    /**
     * @var Entities\Dataset
     */
    private $dataset;


    /**
     * Set usuario
     *
     * @param Entities\User $usuario
     * @return Reporte
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

    /**
     * Set dataset
     *
     * @param Entities\Dataset $dataset
     * @return Reporte
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

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Reporte
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
     * @return Reporte
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

    /*Custom*/
    public function getTiposDeEstado()
    {
        return array(1 => 'En espera de moderación', 2 => 'Pendiente', 3 => 'En espera de aprobación', 4 => 'Resuelto', 5 => 'Rechazado');
    }

    public function validate(){
        $errors = array();

        if(!count($this->getTipoReporte()))
            $errors[] = 'Debe seleccionar una razon para el reporte.';
        if(!$this->getDataset())
            $errors[] = 'El reporte debe estar asociado a un dataset.';
        if(!intval($this->getEstado())>0) 
            $errors[] = 'Debe seleccionar un estado válido para el reporte.';

        return $errors;
    }
}