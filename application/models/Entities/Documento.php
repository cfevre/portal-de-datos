<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Documento
 */
class Documento
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
     * @var text $descripcion
     */
    private $descripcion;

    /**
     * @var string $url
     */
    private $url;

    /**
     * @var string $mime
     */
    private $mime;

    /**
     * @var integer $size
     */
    private $size;

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
     * Set titulo
     *
     * @param string $titulo
     * @return Documento
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
     * @param text $descripcion
     * @return Documento
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return text 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Documento
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
     * Set mime
     *
     * @param string $mime
     * @return Documento
     */
    public function setMime($mime)
    {
        $this->mime = $mime;
        return $this;
    }

    /**
     * Get mime
     *
     * @return string 
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return Documento
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Documento
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
     * @return Documento
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
     * @return Documento
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
     * Custom Methods
     */

    public function getCopy(){
    	$nuevoDocumento = new Documento;
    	$nuevoDocumento->setDescripcion($this->getDescripcion());
    	$nuevoDocumento->setTitulo($this->getTitulo());
    	$nuevoDocumento->setUrl($this->getUrl());
    	$nuevoDocumento->setSize($this->getSize());
    	$nuevoDocumento->setMime($this->getMime());
    	$nuevoDocumento->setCreatedAt(new \DateTime);
    	$nuevoDocumento->setUpdatedAt(new \DateTime);
    	return $nuevoDocumento;
    }

    public function fetchMetadata() {
	    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, str_replace ( ' ', '%20', $this->getUrl()));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_NOBODY, true);

	    $content = curl_exec($ch);

	    $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
	    $pos=strpos($content_type, ';');
	    if($pos!==FALSE)
	        $content_type=substr ($content_type, 0, $pos);
	    $content_length = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

	    curl_close($ch);

	    $this->setMime($content_type!=-1?$content_type:NULL);
	    $this->setSize($content_length!=-1?$content_length:NULL);
		}

		public function validate(){
			$errors = array();

			if(!$this->getTitulo())
				$errors[] = 'Debe ingresar un título para el documento.';
			if(!$this->getDescripcion())
				$errors[] = 'Debe ingresar una descripción para el documento.';
			if(!$this->getUrl())
				$errors[] = 'Debe ingresar una url para el documento.';

			return $errors;
		}

}