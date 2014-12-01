<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Suscripcion
 */
class Suscripcion
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $participacion_id
     */
    private $participacion_id;

    /**
     * @var string $email
     */
    private $email;

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
     * Set participacion_id
     *
     * @param integer $participacion_id
     * @return Suscripcion
     */
    public function setParticipacionId($participacion_id)
    {
        $this->participacion_id = $participacion_id;
        return $this;
    }

    /**
     * Get participacion_id
     *
     * @return date 
     */
    public function getParticipacionId()
    {
        return $this->participacion_id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Suscripcion
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
}