<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Participacion
 */
class Participacion
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $nombre
     */
    private $nombre;

    /**
     * @var string $apellidos
     */
    private $apellidos;

    /**
     * @var string $email
     */
    private $email;

                /**
                 * @var integer $edad
                 */
                private $edad;

                /**
                 * @var string $region
                 */
                private $region;

                /**
                 * @var string $ocupacion
                 */
                private $ocupacion;

    /**
     * @var string $titulo
     */
    private $titulo;

    /**
     * @var text $mensaje
     */
    private $mensaje;

                /**
                 * @var string $institucion
                 */
                private $institucion;
    /**
     * @var string $categorias
     */
    private $categorias;
    /**
     * @var string $categoria
     */
    private $categoria;
    /**
     * @var integer $publicado
     */
    private $publicado;
    /**
     * @var datetime $created_at
     */
    private $created_at;
    /**
     * @var datetime $updated_at
     */
    private $updated_at;
    /**
     * @var Entities\Servicio
     */
    private $servicio;
    /**
     * @var string $enlace
     */
    private $enlace;

    public function __construct()
    {
        $this->categorias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get categoria
     *
     * @return string 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     * @return Participacion
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
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
     * Set nombre
     *
     * @param string $nombre
     * @return Participacion
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
     * Set apellidos
     *
     * @param string $apellidos
     * @return Participacion
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Participacion
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
     * Set titulo
     *
     * @param string $titulo
     * @return Participacion
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
     * Set mensaje
     *
     * @param text $mensaje
     * @return Participacion
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
        return $this;
    }

    /**
     * Get mensaje
     *
     * @return text 
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set publicado
     *
     * @param integer $publicado
     * @return Participacion
     */
    public function setPublicado($publicado)
    {
        $this->publicado = $publicado;
        return $this;
    }

    /**
     * Get publicado
     *
     * @return integer 
     */
    public function getPublicado()
    {
        return $this->publicado;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Participacion
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
     * @return Participacion
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
     * Set edad
     *
     * @param integer $edad
     * @return Participacion
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;
        return $this;
    }

    /**
     * Get edad
     *
     * @return integer 
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set region
     *
     * @param integer $region
     * @return Participacion
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get region
     *
     * @return integer 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set ocupacion
     *
     * @param integer $ocupacion
     * @return Participacion
     */
    public function setOcupacion($ocupacion)
    {
        $this->ocupacion = $ocupacion;
        return $this;
    }

    /**
     * Get ocupacion
     *
     * @return integer 
     */
    public function getOcupacion()
    {
        return $this->ocupacion;
    }

    /**
     * Set institucion
     *
     * @param integer $institucion
     * @return Participacion
     */
    public function setInstitucion($institucion)
    {
        $this->institucion = $institucion;
        return $this;
    }

    /**
     * Get institucion
     *
     * @return integer 
     */
    public function getInstitucion()
    {
        return $this->institucion;
    }
    /**
     * Set servicio
     *
     * @param Entities\Servicio $servicio
     * @return Participacion
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
     * Get enlace
     *
     * @return Entities\Participacion 
     */
    public function getEnlace()
    {
        return $this->enlace;
    }

    /**
     * Set enlace
     *
     * @param string $servicioCodigo
     * @return Participacion
     */
    public function setEnlace($enlace)
    {
        $this->enlace = $enlace;
        return $this;
    }

    /**
     * Add categorias
     *
     * @param Entities\Categoria $categorias
     * @return Participacion
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
		 * Custom Methods
     */

    public function validate(){
    	$errors = array();

			if(!$this->getNombre())
				$errors[] = 'Debe ingresar un nombre.';
			if(!$this->getApellidos())
				$errors[] = 'Debe ingresar al menos un apellido.';
			if(!$this->getEmail())
				$errors[] = 'Debe un E-mail.';
			elseif(!filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL))
				$errors[] = 'Debe un E-mail válido.';
			if(!$this->getTitulo())
				$errors[] = 'Debe ingresar un titulo.';
			if(!$this->getMensaje())
				$errors[] = 'Debe ingresar un mensaje.';
            if(!$this->getInstitucion())
                $errors[] = 'Debe ingresar una institucion.';
            if(count($this->getCategorias()) < 1)
                $errors[] = 'Debe seleccionar a lo menos una categoría para la participacion.';
			return $errors;
    }

    public function publicado(){

        $strPublicado = '';

            if($this->getPublicado()==1){
                $estadoClass = 'btn-success';
                $estadoName = 'Procesado';
                $icon = 'icon-ok-circle';
                $linkEnProceso = '#EnProceso';
                $linkProcesado = '#';
            }else if($this->getPublicado()==2){
                $estadoClass = 'btn-warning';
                $estadoName = 'En Proceso';
                $icon = 'icon-time';
                $linkEnProceso = '#';
                $linkProcesado = '#EnEspera';
            }else if($this->getPublicado()==3){
                $estadoClass = 'btn-danger';
                $estadoName = 'Ingresado';
                $icon = 'icon-info-sign';
                $linkEnProceso = '#';
                $linkProcesado = '#';
            }else if($this->getPublicado()==4){
                $estadoClass = 'btn-info';
                $estadoName = 'En Espera de Aprobación';
                $icon = 'icon-time';
                $linkEnProceso = '#';
                $linkProcesado = '#';
            }else{
                $estadoClass = 'btn-danger';
                $estadoName = 'No Procesado';
                $icon = 'icon-off';
                $linkEnProceso = '#EnProceso';
                $linkProcesado = '#';
            }
            $strPublicado='<div class="btn-group">
                            <a class="btn btn-mini '.$estadoClass.'">
                                <i class="'.$icon.'"></i>
                                <span class="proceso">'.$estadoName.'</span>
                            </a>
                            <a href="#" class="btn '.$estadoClass.' btn-mini dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </a>
                              <ul class="dropdown-menu">
                                <li><a href="'.$linkEnProceso.'" data-toggle="modal" role="button">En Proceso</a></li>
                                <li><a href="'.$linkProcesado.'" data-toggle="modal" role="button">Procesado</a></li>
                              </ul>
                            </div>';
        return $strPublicado;
    }
        public function publicado_view(){
            $strPublicado = '';
            if($this->getPublicado()==1){
                $btn='btn-success';
            }else if($this->getPublicado()==2 || $this->getPublicado()==4){
                $btn='btn-warning';
            }
            else{
                $btn='btn-danger';
            }

            $strPublicado='<a class="btn btn-mini '.$btn.'"> 
                                    &nbsp;
                                </a>'; 
        return $strPublicado;
    }
    public function publicado_ver($opt){
        $strPublicado ='';
        switch ($opt) {
            case '1':
               if($this->getPublicado()==1){
                $btn='btn-success';
                $icon='icon-ok-circle';
                $estadoName='Procesado';
            }else if($this->getPublicado()==2){
                $btn='btn-warning';
                $icon='icon-time';
                $estadoName='En Proceso';
            }else if($this->getPublicado()==3){
                $btn='btn-danger';
                $icon='icon-info-sign';
                $estadoName='Ingresado';
            }else if($this->getPublicado()==4){
                $btn = 'btn-info';
                $estadoName = 'En Espera';
                $icon = 'icon-time';
            }else{
                $btn='btn-danger';
                $icon='icon-off';
                $estadoName='No Procesado';
            }
            break;
            
            case '2':
            if($this->getPublicado()==1){
                $btn='btn-success';
                $icon='icon-ok-circle';
                $estadoName='Procesado';
            }else if($this->getPublicado()==2 || $this->getPublicado()==4){
                $btn='btn-warning';
                $icon='icon-time';
                $estadoName='En Proceso';
            }else{
                $btn='btn-danger';
                $icon='icon-off';
                $estadoName='No Procesado';
            }
            break;
        }
        $strPublicado='<button class="btn btn-mini '.$btn.'"> 
                            <i class="'.$icon.'"></i>
                            <span class="proceso">'.$estadoName.'</span>
                       </button>';
        return $strPublicado;
    }
    public function publicado_mail(){
        $strPublicado ='';
         if($this->getPublicado()==1){
                $estadoName='Procesado';
            }else if($this->getPublicado()==2){
                $estadoName='En Proceso';
            }else{
                $estadoName='No Procesado';
            }
            $strPublicado='<span class="proceso">'.$estadoName.'</span>';
        return $strPublicado;
    }
    public function regiones_backend($opcion,$opt){

        $ArrayRegiones = array(
            "1" => "I Tarapaca",
            "2" => "II Antofagasta",
            "3" => "III Atacama",
            "4" => "IV Coquimbo",
            "5" => "V Valparaiso",
            "6" => "VI Ohiggins",
            "7" => "VII Maule",
            "8" => "VIII Bio-Bio",
            "9" => "IX Araucania",
            "10" => "X Los Lagos",
            "11" => "XI Aysen",
            "12" => "XII Magallanes",
            "13" => "XIII Metropolitana",
            "14" => "XIV Los Rios",
            "15" => "XV Arica y Parinacota",
        );
        switch ($opt) {
            case '1':
            $strRegiones='<option value="">- Seleccione -</option>';
                foreach ($ArrayRegiones as $key => $region) {
                    if ($opcion == $key) {
                        $strRegiones.='<option value="'.$key.'" selected>'.$region.'</option>';
                    }else{
                        $strRegiones.='<option value="'.$key.'">'.$region.'</option>';
                    }
        }break;
            case '2':
             foreach ($ArrayRegiones as $key => $region) {
                    if ($opcion == $key) {
                        $strRegiones=$region;
                        return $strRegiones;
                    }else{
                        $strRegiones='';
                    }
        }
        break; 
        }
        return $strRegiones;
    }
    public function updateCategorias($categorias){
            //Se eliminan las categorias asociadas
            if($this->categorias)
                $this->categorias->clear();
            foreach ($categorias as $key => $categoria) {
                $this->addCategoria($categoria);
            }
        }
    public function hasCategoria(\Entities\Categoria $categoria_to_check){
            foreach ($this->getCategorias() as $key => $categoria) {
                if($categoria == $categoria_to_check)
                    return true;
            }
            return false;
        }
    public function votacion($suscripcion){
        $strVotacion='';
        foreach ($suscripcion as $key => $subscription){
                     $strVotacion = $subscription[1];;
                    }
        return $strVotacion;
    }
}