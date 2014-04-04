<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\WebForm
 */
class WebForm
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $campo
     */
    private $campo;

    /**
     * @var datetime $created
     */
    private $created;


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
     * Set campo
     *
     * @param string $campo
     * @return WebForm
     */
    public function setCampo($campo)
    {
        $this->campo = $campo;
        return $this;
    }

    /**
     * Get campo
     *
     * @return string 
     */
    public function getCampo()
    {
        return $this->campo;
    }

    /**
     * Set created
     *
     * @param datetime $created
     * @return WebForm
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }
}