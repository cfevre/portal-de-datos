<?php
	class widgetHelper{
		public function catalogosTop($showTitle = true, $limit = 6){
			$widget_data['showTitle'] = $showTitle;
			$widget_data['catalogos']['recientes'] = $this->doctrine->em->getRepository('Entities\Dataset')->findDatasetsNuevos($limit);
			$widget_data['catalogos']['masvistos'] = $this->doctrine->em->getRepository('Entities\Dataset')->getMasVistos($limit, date('Y-m-d', strtotime('1 month ago')));
			$widget_data['catalogos']['masdescargados'] = $this->doctrine->em->getRepository('Entities\Dataset')->getMasDescargados($limit, date('Y-m-d', strtotime('1 month ago')));
            $widget_data['ndatasets'] = $this->doctrine->em->getRepository('Entities\Dataset')->getTotalDatasetsPublicados();
			return $this->load->view('widget/catalogos_top', $widget_data, true);
		}

		public function catalogosPorEntidad(){
			$widget_data['entidades'] = $this->doctrine->em->getRepository('Entities\Entidad')->findWithDataset();
			return $this->load->view('widget/catalogos_por_filtro', $widget_data, true);
		}
		public function listadoCatalogosPorEntidad(){
			$widget_data['entidades'] = $this->doctrine->em->getRepository('Entities\Entidad')->findWithDataset();
			return $this->load->view('widget/lista_catalogos', $widget_data, true);
		}
		public function listadoEntidades(){
			$widget_data['servicios'] = $this->doctrine->em->getRepository('Entities\Servicio')->findAll();
			return $this->load->view('widget/listado_entidades.php', $widget_data, true);
		}
		public function entidadSeleccionada(){
			$widget_data['entidades'] = $this->doctrine->em->getRepository('Entities\Servicio')->findAll();
			return $this->load->view('widget/backend/entidad_seleccionada.php', $widget_data, true);
		}

		public function catalogosMasDescargados($limit = 5){
			$widget_data['catalogos']['masdescargados'] = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(null, array('ndescargas' => 'DESC'), $limit);
			return $this->load->view('widget/catalogos_mas_descargados', $widget_data, true);
		}

		public function etiquetasPopulares($limit = 15){
			$widget_data['tags'] = $this->doctrine->em->getRepository('Entities\Tag')->findPopulares($limit);
			return $this->load->view('widget/tags_populares', $widget_data, true);
		}

		public function compartirRedesSociales(){
			$CI = &get_instance();
			$CI->loadScript('twitter','http://platform.twitter.com/widgets.js');
			$CI->loadScript('facebook','http://connect.facebook.net/es_CL/all.js#appId=107645905993653&amp;xfbml=1');
			return $this->load->view('widget/compartir_redes_sociales', null, true);
		}

		public function streamRedesSociales(){
			return $this->load->view('widget/stream_redes_sociales', null, true);
		}

		public function banner($nombre_banner = 'colabora'){
			return $this->load->view('widget/banner_'.$nombre_banner, null, true);
		}

		public function rating($dataset){
			$rating = $dataset->getDatasetMaestro()->getRating();
			$datasetid = $dataset->getId();

			$evaluados = json_decode($this->input->cookie('evaluados'));

			$puedeEvaluar = (!$evaluados || !in_array($dataset->getDatasetMaestro()->getId(), $evaluados));

			$widget_data['rating'] = floatval($rating)*2;
			$widget_data['datasetid'] = $datasetid;
			$widget_data['puedeEvaluar'] = $puedeEvaluar;
			return $this->load->view('widget/rating', $widget_data, true);
		}

		public function junarDestacados(){
			return $this->load->view('widget/junar_destacados', null, true);
		}

		public function ultimasNoticias($limit = 10, $backend = false){
			$widget_data['noticias'] = $this->doctrine->em->getRepository('Entities\Noticia')->findWithOrdering(null, array('created_at' => 'DESC'), $limit, 0);
			if($backend){
				return $this->load->view('widget/backend/ultimas_noticias', $widget_data, true);
			}else{
				return $this->load->view('widget/ultimas_noticias', $widget_data, true);
			}
		}

		public function ultimosDatasets($limit = 10, $backend = false){
			if($backend){
				$options = null;
				if(!$this->user->getMinisterial() && !$this->user->getInterministerial()){
					$options['servicio_codigo'] = $this->user->getServicio()->getCodigo();
				}elseif(!$this->user->getInterministerial()){
					$options['entidad_codigo'] = $this->user->getServicio()->getEntidad()->getCodigo();
				}
				$widget_data['datasets'] = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering($options, array('updated_at' => 'DESC'), $limit, 0);
				return $this->load->view('widget/backend/ultimos_datasets', $widget_data, true);
			}else{
				$widget_data['datasets'] = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(null, array('updated_at' => 'DESC'), $limit, 0);
				return $this->load->view('widget/ultimos_datasets', $widget_data, true);
			}
		}

		public function buscador(){
			$widget_data['search_string'] = $this->input->get('q', true)?$this->input->get('q', true):'';
			return $this->load->view('widget/buscador', $widget_data, true);
		}

        public function categoriasConMasDatasets($limit = 15)
        {
            $widget_data['categorias'] = $this->doctrine->em->getRepository('Entities\Categoria')->getCategoriasConTotales($limit);
            return $this->load->view('widget/categorias', $widget_data, true);
        }
         public function totalCategorias()
        {
            $widget_data['total_categorias'] = $this->doctrine->em->getRepository('Entities\Categoria')->getTodasCategorias();
            return $this->load->view('widget/total_categorias', $widget_data, true);
        }
         public function categoriasSeleccionadas()
        {
            $widget_data['categorias_seleccionadas'] = $this->doctrine->em->getRepository('Entities\Categoria')->getTodasCategorias();
            return $this->load->view('widget/backend/categorias_seleccionadas', $widget_data, true);
        }

        public function reportes()
        {
            if($this->user->hasRol('mantencion')){
                $cant_reportes_aprobacion = $this->doctrine->em->getRepository('Entities\Dataset')->getDatasetsConReportesPorEstadosUsuario($this->user, array(3));
                $widget_data['cant_reportes_aprobacion'] = $cant_reportes_aprobacion;

                $cant_reportes_moderacion = $this->doctrine->em->getRepository('Entities\Dataset')->getDatasetsConReportesPorEstadosUsuario($this->user, array(1));
                $widget_data['cant_reportes_moderacion'] = $cant_reportes_moderacion;
            }

            $cant_reportes = $this->doctrine->em->getRepository('Entities\Dataset')->getDatasetsConReportesPorEstadosUsuario($this->user, array(2));
            $widget_data['cant_reportes'] = $cant_reportes;

            return $this->load->view('widget/backend/reportes', $widget_data, true);
        }
	}
?>