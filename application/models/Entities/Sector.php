<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Sector
 */
class Sector
{
    /**
     * @var string $codigo
     */
    private $codigo;

    /**
     * @var string $tipo
     */
    private $tipo;

    /**
     * @var string $nombre
     */
    private $nombre;

    /**
     * @var float $lat
     */
    private $lat;

    /**
     * @var float $lng
     */
    private $lng;

    /**
     * @var string $url
     */
    private $url;

    /**
     * @var string $sector_padre_codigo
     */
    private $sector_padre_codigo;

    /**
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     */
    private $updated_at;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $children;

    /**
     * @var Entities\Sector
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $datasets;

    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datasets = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Sector
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
     * Set tipo
     *
     * @param string $tipo
     * @return Sector
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Sector
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
     * Set lat
     *
     * @param float $lat
     * @return Sector
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * Get lat
     *
     * @return float 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param float $lng
     * @return Sector
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
        return $this;
    }

    /**
     * Get lng
     *
     * @return float 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Sector
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
     * Set sector_padre_codigo
     *
     * @param string $sectorPadreCodigo
     * @return Sector
     */
    public function setSectorPadreCodigo($sectorPadreCodigo)
    {
        $this->sector_padre_codigo = $sectorPadreCodigo;
        return $this;
    }

    /**
     * Get sector_padre_codigo
     *
     * @return string 
     */
    public function getSectorPadreCodigo()
    {
        return $this->sector_padre_codigo;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Sector
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
     * @return Sector
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
     * Add children
     *
     * @param Entities\Sector $children
     * @return Sector
     */
    public function addSector(\Entities\Sector $children)
    {
        $this->children[] = $children;
        return $this;
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param Entities\Sector $parent
     * @return Sector
     */
    public function setParent(\Entities\Sector $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Get parent
     *
     * @return Entities\Sector 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add datasets
     *
     * @param Entities\Dataset $datasets
     * @return Sector
     */
    public function addDataset(\Entities\Dataset $datasets)
    {
        $this->datasets[] = $datasets;
        return $this;
    }

    /**
     * Get datasets
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDatasets()
    {
        return $this->datasets;
    }
}