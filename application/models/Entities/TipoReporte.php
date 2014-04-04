<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\TipoReporte
 */
class TipoReporte
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
     * @var text $comentario_sugerido
     */
    private $comentario_sugerido;

    /**
     * @var boolean $publico
     */
    private $publico;

    /**
     * @var text $campo_dataset
     */
    private $campo_dataset;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $reportes;

    /**
     * @var Entities\GradoReporte
     */
    private $gradoReporte;

    public function __construct()
    {
        $this->reportes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * @return TipoReporte
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
     * Set comentario_sugerido
     *
     * @param text $comentarioSugerido
     * @return TipoReporte
     */
    public function setComentarioSugerido($comentarioSugerido)
    {
        $this->comentario_sugerido = $comentarioSugerido;
        return $this;
    }

    /**
     * Get comentario_sugerido
     *
     * @return text 
     */
    public function getComentarioSugerido()
    {
        return $this->comentario_sugerido;
    }

    /**
     * Set campo_dataset
     *
     * @param text $campoDataset
     * @return TipoReporte
     */
    public function setCampoDataset($campoDataset)
    {
        $this->campo_dataset = $campoDataset;
        return $this;
    }

    /**
     * Get campo_dataset
     *
     * @return text 
     */
    public function getCampoDataset()
    {
        return $this->campo_dataset;
    }

    /**
     * Set publico
     *
     * @param boolean $publico
     * @return TipoReporte
     */
    public function setPublico($publico)
    {
        $this->publico = $publico;
        return $this;
    }

    /**
     * Get publico
     *
     * @return boolean 
     */
    public function getPublico()
    {
        return $this->publico;
    }

    /**
     * Add reportes
     *
     * @param Entities\Reporte $reportes
     * @return TipoReporte
     */
    public function addReporte(\Entities\Reporte $reportes)
    {
        $this->reportes[] = $reportes;
        return $this;
    }

    /**
     * Get reportes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getReportes()
    {
        return $this->reportes;
    }

    /**
     * Set gradoReporte
     *
     * @param Entities\GradoReporte $gradoReporte
     * @return TipoReporte
     */
    public function setGradoReporte(\Entities\GradoReporte $gradoReporte = null)
    {
        $this->gradoReporte = $gradoReporte;
        return $this;
    }

    /**
     * Get gradoReporte
     *
     * @return Entities\GradoReporte 
     */
    public function getGradoReporte()
    {
        return $this->gradoReporte;
    }
}