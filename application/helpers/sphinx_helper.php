<?php

/*
 * SPHINX HELPER:
 * Wrapper para la api de Sphinx para Redchile
 * 
 */

/*Toma el resultado de search y retorna solo el set de ids de fichas*/
function search_wrapper($search_result,$weights = FALSE){
    
    if(!function_exists("lambda_search")){
        function lambda_search($x){return $x['weight'];}
    }
    list($result_set,$status,$message,$full_result) = $search_result;
    
    if($status && $result_set && is_array($result_set) && count($result_set)){
        if(!$weights){
            return array_keys($result_set);
        }else{
            return array_combine(
                    array_keys($result_set), 
                    array_values(
                            array_map(
                                    "lambda_search",
                                    $result_set)));
        }
    }
    
    return array();
}

/*Busca usando sphinx*/
function search($string, $filters = array(), $limit = null, $offset = null, $ordering = null) {

    $status = FALSE;
    $message = "Default";
    $result_set = array();
    
    $CI =& get_instance();
    
    /* Para que esto funcione debe estar instalado sphinx y corriendo el demonio searchd en el servidor */
    /* http://www.hackido.com/2009/01/install-sphinx-search-on-ubuntu.html */
    /* O buscar en synaptic en caso de ubuntu por sphinx */
    /* IMPORTANTE: La api debe coincidir con la version de sphinx instalada!*/

    /* Cargo API de sphinx */
    $CI->load->library("sphinxclient");

    /* Config de Sphinx para Redchile de acuerdo a sphinx.conf */
    $CI->config->load('sphinx');

    $port = $CI->config->item('port');
    $server = $CI->config->item('server');
    $index = $CI->config->item('index');

    /*Asigno limites a la consulta*/
    if($limit !== null && $offset !== null){
        $CI->sphinxclient->SetLimits($offset,$limit,10000);
    }
    
    $CI->sphinxclient->SetServer($server, $port);
    $CI->sphinxclient->SetSortMode(SPH_SORT_EXTENDED,"id DESC,@weight DESC");
    
    $CI->sphinxclient->SetMatchMode(SPH_MATCH_EXTENDED2);
    $CI->sphinxclient->setRankingMode(SPH_RANK_PROXIMITY_BM25);
    
    //Se asignan pesos a los campos especificos.
    //Cada match suma 200 o 50 puntos respectivamente.
    //En otro campo un match va a sumar 1 punto.
    //El total aparece en el campo @weight de sphinx.
    $CI->sphinxclient->SetFieldWeights(array('titulo'=> 400, 'descripcion' => 200, 'tags'=>200));
    
    /*Reseteo filtros, para poder invocar el objeto y hacer filtros varias veces*/
    $CI->sphinxclient->ResetFilters();
    
    /* Asigno filtros */
    //Except: Campos que requieren AND logico.
    $excep = array("servicio_codigo");

    if(is_array($filters) && count($filters)>0){
        foreach($filters as $field=>$values){
          //En este caso, por cada campo se genera un filtro.
          //Sphinx toma como OR los valores posibles para mismo un campo si se definene en el mismo filtro.
          $CI->sphinxclient->SetFilter($field,$values);
        }
    }
    
    /* Hago la consulta */
    $result = $CI->sphinxclient->Query($string, $index); //String, Index
    
    return $result;
    
}

?>
