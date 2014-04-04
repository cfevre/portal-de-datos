<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\User
 */
class User
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $password
     */
    private $password;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var string $fullname
     */
    private $fullname;

    /**
     * @var boolean $ministerial
     */
    private $ministerial;

    /**
     * @var boolean $interministerial
     */
    private $interministerial;

    /**
     * @var string $reset_code
     */
    private $reset_code;

    /**
     * @var string $api_token
     */
    private $api_token;

    /**
     * @var datetime $reset_expiration
     */
    private $reset_expiration;

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
    private $logDataset;

    /**
     * @var Entities\Servicio
     */
    private $servicio;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $rols;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $reportes;

    public function __construct()
    {
        $this->logDataset = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rols = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
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
     * Set fullname
     *
     * @param string $fullname
     * @return User
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
        return $this;
    }

    /**
     * Get fullname
     *
     * @return string 
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set ministerial
     *
     * @param boolean $ministerial
     * @return User
     */
    public function setMinisterial($ministerial)
    {
        $this->ministerial = $ministerial;
        return $this;
    }

    /**
     * Get ministerial
     *
     * @return boolean 
     */
    public function getMinisterial()
    {
        return $this->ministerial;
    }

    /**
     * Set interministerial
     *
     * @param boolean $interministerial
     * @return User
     */
    public function setInterministerial($interministerial)
    {
        $this->interministerial = $interministerial;
        return $this;
    }

    /**
     * Get interministerial
     *
     * @return boolean 
     */
    public function getInterministerial()
    {
        return $this->interministerial;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return User
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
     * @return User
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
     * Set reset_code
     *
     * @param string $resetCode
     * @return User
     */
    public function setResetCode($resetCode)
    {
        $this->reset_code = $resetCode;
        return $this;
    }

    /**
     * Get reset_code
     *
     * @return string 
     */
    public function getResetCode()
    {
        return $this->reset_code;
    }

    /**
     * Set reset_expiration
     *
     * @param datetime $resetExpiration
     * @return User
     */
    public function setResetExpiration($resetExpiration)
    {
        $this->reset_expiration = $resetExpiration;
        return $this;
    }

    /**
     * Get reset_expiration
     *
     * @return datetime 
     */
    public function getResetExpiration()
    {
        return $this->reset_expiration;
    }

    /**
     * Set api_token
     *
     * @param string $apiToken
     * @return User
     */
    public function setApiToken($apiToken)
    {
        $this->api_token = $apiToken;
        return $this;
    }

    /**
     * Get api_token
     *
     * @return string 
     */
    public function getApiToken()
    {
        return $this->api_token;
    }

    /**
     * Add logDataset
     *
     * @param Entities\Dataset $logDataset
     * @return User
     */
    public function addDataset(\Entities\Dataset $logDataset)
    {
        $this->logDataset[] = $logDataset;
        return $this;
    }

    /**
     * Get logDataset
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLogDataset()
    {
        return $this->logDataset;
    }

    /**
     * Set servicio
     *
     * @param Entities\Servicio $servicio
     * @return User
     */
    public function setServicio(\Entities\Servicio $servicio = null)
    {
        $this->servicio = $servicio;
        return $this;
    }

    /**
     * Get servicio
     *
     * @return Entities\Servicio 
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Add rols
     *
     * @param Entities\Rol $rols
     * @return User
     */
    public function addRol(\Entities\Rol $rols)
    {
        $this->rols[] = $rols;
        return $this;
    }

    /**
     * Get rols
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRols()
    {
        return $this->rols;
    }

    /**
     * Add reportes
     *
     * @param Entities\Reporte $reportes
     * @return User
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
     * Custom Methods
     */

    public function hasRol($id_rols){
			$rols = $this->getRols();
			$validRols = 0;

			if(gettype($id_rols) == 'array'){
				
				foreach ($rols as $key => $rol) {
					if( \stringsHelper::in_array_match($rol->getId(), $id_rols))
						$validRols++;
				}
				return $validRols >= count($id_rols);

			}else{

				foreach ($rols as $key => $rol) {
					if( preg_match(preg_quote('/'.$rol->getId().'/'), $id_rols) )
						return true;
				}

			}

			return false;
    }

    public function removeAllRols(){
    	$this->rols->clear();
    }

    public function getHashedPassword($password){
			$salt = sha1(rand());
			$salted_password = sha1($password.$salt);
			return $salted_password.':'.$salt;
	  }
}