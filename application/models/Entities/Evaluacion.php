<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Evaluacion
 */
class Evaluacion
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $rating
     */
    private $rating;

    /**
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     */
    private $updated_at;

    /**
     * @var Entities\Dataset
     */
    private $dataset;


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
     * Set rating
     *
     * @param integer $rating
     * @return Evaluacion
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * Get rating
     *
     * @return integer 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Evaluacion
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
     * @return Evaluacion
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
     * Set dataset
     *
     * @param Entities\Dataset $dataset
     * @return Evaluacion
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
}