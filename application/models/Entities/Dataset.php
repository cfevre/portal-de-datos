<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Dataset
 */
class Dataset
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
     * @var string $frecuencia
     */
    private $frecuencia;

    /**
     * @var string $granularidad
     */
    private $granularidad;

    /**
     * @var string $cobertura_temporal
     */
    private $cobertura_temporal;

    /**
     * @var integer $ndescargas
     */
    private $ndescargas;

    /**
     * @var float $rating
     */
    private $rating;

    /**
     * @var boolean $maestro
     */
    private $maestro;

    /**
     * @var boolean $publicado
     */
    private $publicado;

    /**
     * @var datetime $publicado_at
     */
    private $publicado_at;

    /**
     * @var integer $hits
     */
    private $hits;

    /**
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     */
    private $updated_at;

    /**
     * @var integer $maestro_id
     */
    private $maestro_id;

    /**
     * @var string $servicio_codigo
     */
    private $servicio_codigo;

    /**
     * @var integer $licencia_id
     */
    private $licencia_id;

    /**
     * @var boolean $actualizable
     */
    private $actualizable;

    /**
     * @var datetime $integracion_junar
     */
    private $integracion_junar;

    /**
     * @var integer $primera_version_publicada
     */
    private $primera_version_publicada;

    /**
     * @var Entities\Dataset
     */
    private $primeraVersionPublicada;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $datasetVersion;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $logMaestro;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $logVersion;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $recursos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $documentos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $evaluaciones;

    /**
     * @var Entities\Servicio
     */
    private $servicio;

    /**
     * @var Entities\Licencia
     */
    private $licencia;

    /**
     * @var Entities\Dataset
     */
    private $datasetMaestro;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $sectores;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $tags;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $categorias;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $reportes;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $vistas;

    /**
     * @var string $coordenadas
     */
    private $coordenadas;

    /**
     * @var string $doc_id
     */
    private $doc_id;

    public function __construct()
    {
        $this->datasetVersion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->logMaestro = new \Doctrine\Common\Collections\ArrayCollection();
        $this->logVersion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recursos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->documentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->evaluaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sectores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categorias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reportes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->vistas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Dataset
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
     * @return Dataset
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
     * Set frecuencia
     *
     * @param string $frecuencia
     * @return Dataset
     */
    public function setFrecuencia($frecuencia)
    {
        $this->frecuencia = $frecuencia;
        return $this;
    }

    /**
     * Get frecuencia
     *
     * @return string 
     */
    public function getFrecuencia()
    {
        return $this->frecuencia;
    }

    /**
     * Set granularidad
     *
     * @param string $granularidad
     * @return Dataset
     */
    public function setGranularidad($granularidad)
    {
        $this->granularidad = $granularidad;
        return $this;
    }

    /**
     * Get granularidad
     *
     * @return string 
     */
    public function getGranularidad()
    {
        return $this->granularidad;
    }

    /**
     * Set cobertura_temporal
     *
     * @param string $coberturaTemporal
     * @return Dataset
     */
    public function setCoberturaTemporal($coberturaTemporal)
    {
        $this->cobertura_temporal = $coberturaTemporal;
        return $this;
    }

    /**
     * Get cobertura_temporal
     *
     * @return string 
     */
    public function getCoberturaTemporal()
    {
        return $this->cobertura_temporal;
    }

    /**
     * Set ndescargas
     *
     * @param integer $ndescargas
     * @return Dataset
     */
    public function setNdescargas($ndescargas)
    {
        $this->ndescargas = $ndescargas;
        return $this;
    }

    /**
     * Get ndescargas
     *
     * @return integer 
     */
    public function getNdescargas()
    {
        return $this->ndescargas;
    }

    /**
     * Set rating
     *
     * @param float $rating
     * @return Dataset
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * Get rating
     *
     * @return float 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set maestro
     *
     * @param boolean $maestro
     * @return Dataset
     */
    public function setMaestro($maestro)
    {
        $this->maestro = $maestro;
        return $this;
    }

    /**
     * Get maestro
     *
     * @return boolean 
     */
    public function getMaestro()
    {
        return $this->maestro;
    }

    /**
     * Set publicado
     *
     * @param boolean $publicado
     * @return Dataset
     */
    public function setPublicado($publicado)
    {
        $this->publicado = $publicado;
        return $this;
    }

    /**
     * Get publicado
     *
     * @return boolean 
     */
    public function getPublicado()
    {
        return $this->publicado;
    }

    /**
     * Set publicado_at
     *
     * @param datetime $publicadoAt
     * @return Dataset
     */
    public function setPublicadoAt($publicadoAt)
    {
        $this->publicado_at = $publicadoAt;
        return $this;
    }

    /**
     * Get publicado_at
     *
     * @return datetime 
     */
    public function getPublicadoAt()
    {
        return $this->publicado_at;
    }

    /**
     * Set hits
     *
     * @param integer $hits
     * @return Dataset
     */
    public function setHits($hits)
    {
        $this->hits = $hits;
        return $this;
    }

    /**
     * Get hits
     *
     * @return integer 
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Dataset
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
     * @return Dataset
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
     * Set maestro_id
     *
     * @param integer $maestroId
     * @return Dataset
     */
    public function setMaestroId($maestroId)
    {
        $this->maestro_id = $maestroId;
        return $this;
    }

    /**
     * Get maestro_id
     *
     * @return integer 
     */
    public function getMaestroId()
    {
        return $this->maestro_id;
    }

    /**
     * Set servicio_codigo
     *
     * @param string $servicioCodigo
     * @return Dataset
     */
    public function setServicioCodigo($servicioCodigo)
    {
        $this->servicio_codigo = $servicioCodigo;
        return $this;
    }

    /**
     * Get servicio_codigo
     *
     * @return string 
     */
    public function getServicioCodigo()
    {
        return $this->servicio_codigo;
    }

    /**
     * Set licencia_id
     *
     * @param integer $licenciaId
     * @return Dataset
     */
    public function setLicenciaId($licenciaId)
    {
        $this->licencia_id = $licenciaId;
        return $this;
    }

    /**
     * Get licencia_id
     *
     * @return integer 
     */
    public function getLicenciaId()
    {
        return $this->licencia_id;
    }

    /**
     * Set actualizable
     *
     * @param boolean $actualizable
     * @return Dataset
     */
    public function setActualizable($actualizable)
    {
        $this->actualizable = $actualizable;
        return $this;
    }

    /**
     * Get actualizable
     *
     * @return boolean 
     */
    public function getActualizable()
    {
        return $this->actualizable;
    }

    /**
     * Set integracion_junar
     *
     * @param datetime $integracion_junar
     * @return Dataset
     */
    public function setIntegracionJunar($integracion_junar)
    {
        $this->integracion_junar = $integracion_junar;
        return $this;
    }

    /**
     * Get integracion_junar
     *
     * @return datetime 
     */
    public function getIntegracionJunar()
    {
        return $this->integracion_junar;
    }

    /**
     * Set primera_version_publicada
     *
     * @param integer $primeraVersionPublicada
     * @return Dataset
     */
    public function setPrimeraVersionPublicada($primeraVersionPublicada)
    {
        $this->primeraVersionPublicada = $primeraVersionPublicada;
        return $this;
    }

    /**
     * Get primera_version_publicada
     *
     * @return integer 
     */
    public function getPrimeraVersionPublicada()
    {
        return $this->primeraVersionPublicada;
    }

    /**
     * Add datasetVersion
     *
     * @param Entities\Dataset $datasetVersion
     * @return Dataset
     */
    public function addDataset(\Entities\Dataset $datasetVersion)
    {
        $this->datasetVersion[] = $datasetVersion;
        return $this;
    }

    /**
     * Get datasetVersion
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDatasetVersion()
    {
        return $this->datasetVersion;
    }

    /**
     * Add logMaestro
     *
     * @param Entities\Log $logMaestro
     * @return Dataset
     */
    public function addLog(\Entities\Log $logMaestro)
    {
        $this->logMaestro[] = $logMaestro;
        return $this;
    }

    /**
     * Get logMaestro
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLogMaestro()
    {
        return $this->logMaestro;
    }

    /**
     * Get logVersion
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLogVersion()
    {
        return $this->logVersion;
    }

    /**
     * Add recursos
     *
     * @param Entities\Recurso $recursos
     * @return Dataset
     */
    public function addRecurso(\Entities\Recurso $recursos)
    {
        $this->recursos[] = $recursos;
        return $this;
    }

    /**
     * Get recursos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRecursos()
    {
        return $this->recursos;
    }

    /**
     * Add documentos
     *
     * @param Entities\Documento $documentos
     * @return Dataset
     */
    public function addDocumento(\Entities\Documento $documentos)
    {
        $this->documentos[] = $documentos;
        return $this;
    }

    /**
     * Get documentos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDocumentos()
    {
        return $this->documentos;
    }

    /**
     * Add evaluaciones
     *
     * @param Entities\Evaluacion $evaluaciones
     * @return Dataset
     */
    public function addEvaluacion(\Entities\Evaluacion $evaluaciones)
    {
        $this->evaluaciones[] = $evaluaciones;
        return $this;
    }

    /**
     * Get evaluaciones
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEvaluaciones()
    {
        return $this->evaluaciones;
    }

    /**
     * Set servicio
     *
     * @param Entities\Servicio $servicio
     * @return Dataset
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
     * Set licencia
     *
     * @param Entities\Licencia $licencia
     * @return Dataset
     */
    public function setLicencia(\Entities\Licencia $licencia = null)
    {
        $this->licencia = $licencia;
        return $this;
    }

    /**
     * Get licencia
     *
     * @return Entities\Licencia 
     */
    public function getLicencia()
    {
        return $this->licencia;
    }

    /**
     * Set datasetMaestro
     *
     * @param Entities\Dataset $datasetMaestro
     * @return Dataset
     */
    public function setDatasetMaestro(\Entities\Dataset $datasetMaestro = null)
    {
        $this->datasetMaestro = $datasetMaestro;
        return $this;
    }

    /**
     * Get datasetMaestro
     *
     * @return Entities\Dataset 
     */
    public function getDatasetMaestro()
    {
        return $this->datasetMaestro;
    }

    /**
     * Add sectores
     *
     * @param Entities\Sector $sectores
     * @return Dataset
     */
    public function addSector(\Entities\Sector $sectores)
    {
        $this->sectores[] = $sectores;
        return $this;
    }

    /**
     * Get sectores
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSectores()
    {
        return $this->sectores;
    }

    /**
     * Add tags
     *
     * @param Entities\Tag $tags
     * @return Dataset
     */
    public function addTag(\Entities\Tag $tags)
    {
        $this->tags[] = $tags;
        return $this;
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add categorias
     *
     * @param Entities\Categoria $categorias
     * @return Dataset
     */
    public function addCategoria(\Entities\Categoria $categorias)
    {
        $this->categorias[] = $categorias;
        return $this;
    }

    /**
     * Get categorias
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * Add reportes
     *
     * @param Entities\Reporte $reportes
     * @return Dataset
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
     * Add vistas
     *
     * @param Entities\Vista $vistas
     * @return Dataset
     */
    public function addVista(\Entities\Vista $vistas)
    {
        $this->vistas[] = $vistas;
        return $this;
    }

    /**
     * Get vistas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVistas()
    {
        return $this->vistas;
    }

    /**
     * Set coordenadas
     *
     * @param string $coordenadas
     * @return Dataset
     */
    public function setCoordenadas($coordenadas)
    {
        $this->coordenadas = $coordenadas;
        return $this;
    }

    /**
     * Get coordenadas
     *
     * @return string
     */
    public function getCoordenadas()
    {
        return $this->coordenadas;
    }

    /**
     * Set doc_id
     *
     * @param string $doc_id
     * @return Dataset
     */
    public function setDocId($doc_id)
    {
        $this->doc_id = $doc_id;
        return $this;
    }

    /**
     * Get doc_id
     *
     * @return string
     */
    public function getDocId()
    {
        return $this->doc_id;
    }

    /**
		 * Custom Methods
     */

    public function validate(){
    	$errors = array();

			if(!$this->getTitulo())
				$errors[] = 'Debe ingresar un título para el dataset.';
			if(!$this->getDescripcion())
				$errors[] = 'Debe ingresar una descripción para el dataset.';
			if(!$this->getServicio())
				$errors[] = 'Debe seleccionar una institución para el dataset.';
			if(!$this->getLicencia())
				$errors[] = 'Debe seleccionar una licencia para el dataset.';
            if(count($this->getCategorias()) < 1)
                $errors[] = 'Debe seleccionar a lo menos una categoría para el dataset.';
			return $errors;
    }

    public function compareWith(\Entities\Dataset $version){
    	$descripcion = '';
			$propiedades = array( 'titulo', 'descripcion', 'frecuencia', 'granularidad', 'coberturaTemporal', 'ndescargas', 'rating' );
			$entidades = array( 'servicio', 'licencia' );
			$colecciones = array( 'sectores', 'tags', 'categorias' );

			//Se comparan las propiedades del objeto
			foreach($propiedades as $propiedad){
				$getter = 'get'.ucfirst($propiedad);
				if($this->$getter() != $version->$getter()){
					$changes[] = array( 'titulo' => $propiedad, 'valor' => $version->$getter() );
				}
			}

			//Se comparan las entidades asociadas al objeto
			foreach($entidades as $entidad){
				$getter = 'get'.ucfirst($entidad);
				if($this->$getter() != $version->$getter()){
					$changes[] = array( 'titulo' => $entidad, 'valor' => $version->$getter()->getNombre() );
				}
			}

			//Se comparan las colecciones de entidades
			foreach($colecciones as $coleccion){
				$getter = 'get'.ucfirst($coleccion);
				//Verifica las entidades eliminadas
				foreach ($this->$getter() as $key => $cEntidad) {
					if(!$version->$getter()->contains($cEntidad)){
						if(method_exists($cEntidad, 'getNombre'))
							$collectionChanges[] = '<span>'.$cEntidad->getNombre().' eliminado.</span>';
						else
							$collectionChanges[] = '<span>'.$cEntidad->getId().' eliminado.</span>';
					}
				}
				//Verifica las entidades agregadas
				foreach ($version->$getter() as $key => $cEntidad) {
					if(!$this->$getter()->contains($cEntidad))
						$collectionChanges[] = '<span>'.$cEntidad->getNombre().' agregado.</span>';
				}
				if(isset($collectionChanges))
					$changes[] = array( 'titulo' => $coleccion, 'valor' => implode('</li><li>', $collectionChanges) );

				unset($collectionChanges);
			}

			//Se convierten los cambios texto html.
			if(isset($changes)){
				foreach ($changes as $key => $change) {
					$descripcion .= '<p>Modificación en <strong>'.$change["titulo"].'</strong>:';
					$descripcion .= '<ul><li>'.$change["valor"].'</li></ul>';
				}
			}else{
				$descripcion = '<p>El dataset ha sido guardado pero no se realizaron cambios.</p>';
			}

			return $descripcion;
    }

    /**
     * @return Dataset
     */
    public function getLastVersion(){
    	if($this->getDatasetVersion())
    		return $this->getDatasetVersion()->first();
    	else
    		return null;
    }

		public function hasCategoria(\Entities\Categoria $categoria_to_check){
			foreach ($this->getCategorias() as $key => $categoria) {
				if($categoria == $categoria_to_check)
					return true;
			}
			return false;
		}

		public function updateCategorias($categorias){
			//Se eliminan las categorias asociadas
			if($this->categorias)
				$this->categorias->clear();
			foreach ($categorias as $key => $categoria) {
				$this->addCategoria($categoria);
			}
		}

		public function updateTags($tags){
			//Se eliminan los tags asociados
			if($this->tags)
				$this->tags->clear();
			foreach ($tags as $key => $tag) {
				$this->addTag($tag);
			}
		}

		public function updateSectores($sectores){
			//Se eliminan los sectores asociados
			if($this->sectores)
				$this->sectores->clear();
			foreach ($sectores as $key => $sector) {
				$this->addSector($sector);
			}
		}

		public function updateRecursos($recursos){
			$CI= &get_instance();

			foreach($recursos as $recurso){
				$nuevoRecurso = $recurso->getCopy();
				$nuevoRecurso->setDataset($this);
				$CI->doctrine->em->persist($nuevoRecurso);
			}

			$CI->doctrine->em->flush();
		}

		public function updateDocumentos($documentos){
			$CI= &get_instance();

			foreach($documentos as $documento){
				$nuevoDocumento = $documento->getCopy();
				$nuevoDocumento->setDataset($this);
				$CI->doctrine->em->persist($nuevoDocumento);
			}
			
			$CI->doctrine->em->flush();
		}

		public function generaVersion($checkChanges = true){
			$versionNueva = new Dataset; //Se crea una nueva entidad para almacenar el versionado de los datasets
			$versionAnterior = $this->getLastVersion();

			//Se crean las asociaciones de la version
			$versionNueva->setTitulo($this->getTitulo());
			$versionNueva->setDescripcion($this->getDescripcion());
			$versionNueva->setLicencia($this->getLicencia());
			$versionNueva->setFrecuencia($this->getFrecuencia());
			$versionNueva->setCoberturaTemporal($this->getCoberturaTemporal());
			$versionNueva->setGranularidad($this->getGranularidad());
			$versionNueva->setServicio($this->getServicio());
			$versionNueva->updateCategorias($this->getCategorias());
			$versionNueva->updateTags($this->getTags());
			$versionNueva->updateSectores($this->getSectores());
			$versionNueva->setMaestro(false);
			$versionNueva->setPublicado(false);
			$versionNueva->setActualizable(false);
			$versionNueva->setNdescargas(0);
			$versionNueva->setUpdatedAt(new \DateTime);
			$versionNueva->setCreatedAt(new \DateTime);
            $versionNueva->setIntegracionJunar($this->getIntegracionJunar());
            $versionNueva->setCoordenadas($this->getCoordenadas());
            $versionNueva->setDocId('');

			$versionNueva->setDatasetMaestro($this);

			//Se copian los documentos y los recursos
		
			//Se hacen persistentes los cambios en la BD
			$CI= &get_instance();
			$CI->doctrine->em->persist($versionNueva);
			$CI->doctrine->em->flush();

			//Una vez que el nuevo dataset está guardado en la BD, se hacen las asociaciones con los Recursos y Documento
			$versionNueva->updateRecursos($this->getRecursos());
			$versionNueva->updateDocumentos($this->getDocumentos());

			if($checkChanges){
				$cambios = '<p>Se ha creado el dataset.</p>';
				if($versionAnterior){
					//En caso de existir un dataset anterior se obtienen los cambios para guardar en el log
					$cambios = $versionAnterior->compareWith($versionNueva);
				}

				$versionNueva->createLog($cambios);
			}

			return $versionNueva;
		}

		public function createLog($cambios){

			$CI= &get_instance();

			$log = new Log;
			
			$log->setDescripcion($cambios);
			$log->setDatasetMaestro($this->getDatasetMaestro());
			$log->setDatasetVersion($this);
			$log->setUsuario(isset($CI->user) ? $CI->user : null);
			$log->setUpdatedAt(new \DateTime);
			$log->setCreatedAt(new \DateTime);

			$CI->doctrine->em->persist($log);
			$CI->doctrine->em->flush();
		}

		public function togglePublicado(){
			$id_version_previa = null;

			$CI= &get_instance();

			$this->setPublicado(!$this->getPublicado());
			$this->setUpdatedAt(new \DateTime);

			$maestro = $this->getDatasetMaestro();
			$maestro->setPublicado($this->getPublicado());

			//Si se está publicando el dataset, se busca el publicado anterior y se despublica, solo puede haber 1 publicado.
			if($this->getPublicado()){
				$versiones = $maestro->getDatasetVersion();
				foreach($versiones as $version){
					if($version != $this && $version->getPublicado()){
						$version->setPublicado(false);
						$id_version_previa = $version->getId();
						$CI->doctrine->em->persist($version);
					}
				}
				$this->setPublicadoAt(new \DateTime);
				$maestro->setPublicadoAt(new \DateTime);
			}

            if(!$maestro->getPrimeraVersionPublicada())
                $maestro->setPrimeraVersionPublicada($this);

			$this->logCambioPublicacion();
				
			$CI->doctrine->em->persist($this);
			$CI->doctrine->em->persist($maestro);
			$CI->doctrine->em->flush();

			return $id_version_previa;
		}

		public function logCambioPublicacion(){
			$cambios = '<strong>Actualización de Estado de Publicación</strong><br />Versión '.($this->getPublicado()?'publicada':'despublicada');
			$this->createLog($cambios);
		}

		public function formatosDisponibles(){
			$formatos = array();
      foreach ($this->getRecursos() as $r)
          $formatos[] = $r->getMime();

      return array_unique($formatos);
		}

		public function checkUserAccess($rol = null){
			$CI= &get_instance();
			if($rol){
				if(!$CI->user->hasRol($rol)){
					$CI->addMessage('No tiene permisos suficientes para acceder a este dataset.');
					redirect('/backend/dataset');
				}
			}
			//Si no es un nuevo dataset, verifica los permisos
			if($this->getId()){
				if(!$CI->user->getMinisterial() && !$CI->user->getInterministerial()){
					if($CI->user->getServicio() != $this->getServicio()){
						$CI->addMessage('No tiene permiso para ver este dataset.');
						redirect('/backend/dataset');
					}
				}elseif(!$CI->user->getInterministerial()){
					if($CI->user->getServicio()->getEntidad() != $this->getServicio()->getEntidad()){
						$CI->addMessage('No tiene permiso para ver este dataset.');
						redirect('/backend/dataset');
					}
				}
			}
			return true;
		}

        public function getCantidadReportesPorEstados($estados = array(2,3,5))
        {
            $count = 0;
            foreach($this->getReportes() as $reporte){
                if(in_array($reporte->getEstado(), $estados)){
                    $count++;
                }
            }
            return $count;
        }

        public function getBtnReporteAsociadoCampo($campo = 'titulo', $claseExtra = '')
        {
            if(!$this->getMaestro())
                return '';

            $urlReporte = null;
            $tipoBoton = 'btn-danger';
            $textoBoton = 'Reportar';
            $count = 0;
            //Se busca el primer reporte pendiente y asociado al campo asignado
            foreach($this->getReportes() as $reporte){
                if($reporte->getTipoReporte()->getCampoDataset() === $campo && $reporte->getEstado() != 4){
                    if(!$urlReporte || intval($reporte->getEstado()) === 3){
                        $urlReporte = 'backend/reporte/edit/'.$reporte->getId();
                        $tipoBoton = in_array($reporte->getEstado(), array(2,5))?'btn-warning':'btn-success';
                        $textoBoton = in_array($reporte->getEstado(), array(2,5))?'Pendiente':'Revisar';
                    }
                    $count++;
                }
            }

            if($count){
                $textoBoton .= '&nbsp;<span>['.$count.']</span>';
            }

            if(!$urlReporte){
                $urlReporte = 'backend/reporte/add/'.($this->getId());
                $urlReporte .= '?campo_dataset='.$campo;
            }
            return '<a href="'.site_url($urlReporte).'" class="btn btn-small '.$tipoBoton.' '.$claseExtra.'">'.$textoBoton.'</a>';
        }

        public function getCategoriasString()
        {
            $result = array();
            foreach($this->getCategorias() as $categoria){
                $result[] = $categoria->getNombre();
            }
            return implode(', ', $result);
        }

        public function getTagsString()
        {
            $result = array();
            foreach($this->getTags() as $tag){
                $result[] = $tag->getNombre();
            }
            return implode(',', $result);
        }

        public function getNombrePrimeraCategoria()
        {
            return count($this->categorias) ? $this->categorias[0]->getNombre() : '';
        }

        public function toArray()
        {
            $result['id'] = $this->id;
            $result['titulo'] = $this->getTitulo();
            $result['descripcion'] = $this->getDescripcion();
            $result['licencia'] = array(
                'id' => $this->getLicencia()->getId(),
                'nombre' => $this->getLicencia()->getNombre()
            );
            $result['servicio'] = array(
                'codigo' => $this->getServicio()->getCodigo(),
                'nombre' => $this->getServicio()->getNombre()
            );
            $result['categorias'] = array();

            foreach($this->getCategorias() as $key => $categoria){
                $result['categorias'][$key]['id'] = $categoria->getId();
                $result['categorias'][$key]['nombre'] = $categoria->getNombre();
            }

            foreach ($this->getRecursos() as $key => $recurso) {
                $result['recursos'][$key]['id'] = $recurso->getId();
                $result['recursos'][$key]['url'] = $recurso->getUrl();
            }

            foreach ($this->getTags() as $key => $tag) {
                $result['tags'][$key] = $tag->getNombre();
            }

            $result['fecha_publicacion'] = $this->getPublicadoAt()->format('Y-m-d');
            $result['fecha_actualizacion'] = $this->getUpdatedAt() ? $this->getUpdatedAt()->format('Y-m-d') : '';
            $result['coordenadas'] = $this->getCoordenadas();
            $result['doc_id'] = $this->getDocId();
            return $result;
        }
}