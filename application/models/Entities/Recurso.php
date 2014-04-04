<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Recurso
 */
class Recurso
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $codigo
     */
    private $codigo;

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
     * @var string $junar_guid
     */
    private $junar_guid;

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
    private $descargas;

    /**
     * @var Entities\Dataset
     */
    private $dataset;

    public function __construct()
    {
        $this->descargas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set codigo
     *
     * @param integer $codigo
     * @return Recurso
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set descripcion
     *
     * @param text $descripcion
     * @return Recurso
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
        if(strip_tags($this->descripcion) == ""){
            return "";
        }else{
            return $this->descripcion;
        }
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Recurso
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
     * @return Recurso
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
     * @return Recurso
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
     * Set junar_guid
     *
     * @param string $junar_guid
     * @return Recurso
     */
    public function setJunarGuid($junar_guid)
    {
        $this->junar_guid = $junar_guid;
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
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Recurso
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
     * @return Recurso
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
     * Add descargas
     *
     * @param Entities\Descarga $descargas
     * @return Recurso
     */
    public function addDescarga(\Entities\Descarga $descargas)
    {
        $this->descargas[] = $descargas;
        return $this;
    }

    /**
     * Get descargas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDescargas()
    {
        return $this->descargas;
    }

    /**
     * Set dataset
     *
     * @param Entities\Dataset $dataset
     * @return Recurso
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
    	$nuevoRecurso = new Recurso;
    	$nuevoRecurso->setDescripcion($this->getDescripcion());
    	$nuevoRecurso->setUrl($this->getUrl());
    	$nuevoRecurso->setSize($this->getSize());
    	$nuevoRecurso->setMime($this->getMime());
        $nuevoRecurso->setJunarGuid($this->getJunarGuid());
    	$nuevoRecurso->setCodigo($this->getCodigo());
    	$nuevoRecurso->setCreatedAt(new \DateTime);
    	$nuevoRecurso->setUpdatedAt(new \DateTime);
    	return $nuevoRecurso;
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
			$errores = array();

			if(!$this->getUrl())
				$errores[] = 'Debe ingresar una url para el recurso.';

			return $errores;
		}

        public function validateJunarData($junarData)
        {
            $errores = array();

            if(!$junarData['title'])
                $errores[] = 'Debe ingresar un título para el recurso';
            if(strlen($junarData['title']) > 80)
                $errores[] = 'El título no puede tener más de 80 caracteres';
            if(strlen($junarData['description']) > 140)
                $errores[] = 'La descripción no puede tener más de 140 caracteres';
            if(!$junarData['source'])
                $errores[] = 'El recuros debe apuntar a una url válida';
            if(!$junarData['category'])
                $errores[] = 'Debe seleccionar una categoría para el recurso';
            if(!$junarData['auth_key'])
                $errores[] = 'Debe configurar una "auth key" para junar';
            if(!in_array(\mimeHelper::get_mime_name($this->getMime()), array('csv', 'xls', 'xlsx')))
                $errores[] = 'Formato de recurso inválido. Debe enviar un recurso de tipo xls o csv';

            return $errores;
        }

}