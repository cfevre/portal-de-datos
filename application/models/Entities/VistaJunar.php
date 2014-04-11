<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * VistaJunar
 */
class VistaJunar
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $junar_guid;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $tags;

    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $category;

    /**
     * @var string
     */
    private $meta_data;

    /**
     * @var integer
     */
    private $table_id;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var \Entities\Recurso
     */
    private $recurso;


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
     * Set junar_guid
     *
     * @param string $junarGuid
     * @return VistaJunar
     */
    public function setJunarGuid($junarGuid)
    {
        $this->junar_guid = $junarGuid;
    
        return $this;
    }

    /**
     * Get junar_guid
     *
     * @return string 
     */
    public function getJunarGuid()
    {
        return $this->junar_guid;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return VistaJunar
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return VistaJunar
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return VistaJunar
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return VistaJunar
     */
    public function setSource($source)
    {
        $this->source = $source;
    
        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return VistaJunar
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set meta_data
     *
     * @param string $metaData
     * @return VistaJunar
     */
    public function setMetaData($metaData)
    {
        $this->meta_data = $metaData;
    
        return $this;
    }

    /**
     * Get meta_data
     *
     * @return string 
     */
    public function getMetaData()
    {
        return $this->meta_data;
    }

    /**
     * Set table_id
     *
     * @param integer $tableId
     * @return VistaJunar
     */
    public function setTableId($tableId)
    {
        $this->table_id = $tableId;
    
        return $this;
    }

    /**
     * Get table_id
     *
     * @return integer 
     */
    public function getTableId()
    {
        return $this->table_id;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return VistaJunar
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return VistaJunar
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set recurso
     *
     * @param \Entities\Recurso $recurso
     * @return VistaJunar
     */
    public function setRecurso(\Entities\Recurso $recurso = null)
    {
        $this->recurso = $recurso;
    
        return $this;
    }

    /**
     * Get recurso
     *
     * @return \Entities\Recurso 
     */
    public function getRecurso()
    {
        return $this->recurso;
    }

    public function validate(){
        $errores = array();

        if(!$this->getTitle())
            $errores[] = 'Debe ingresar una título para la vista.';
        if(!$this->getDescription())
            $errores[] = 'Debe ingresar una descripción para la vista.';
        if(!$this->getCategory())
            $errores[] = 'Debe seleccionar una categoría para la vista.';
        if(!$this->getSource())
            $errores[] = 'La vista debe tener una fuente asociada.';
        if(!$this->getMetaData())
            $errores[] = 'La vista debe estar asociada a un dataset.';
        if(!is_numeric($this->getTableId()))
            $errores[] = 'Debe especificar la hoja de la cual se obtendrán los datos para la vista.';

        return $errores;
    }
}