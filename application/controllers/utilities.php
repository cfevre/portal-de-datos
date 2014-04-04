<?php

class utilities extends CI_Controller {


    function __construct()
    {
        parent::__construct();

        if(!$this->input->is_cli_request())
            exit;
    }

    public function descargaRecursos(){
        $recursos = $this->doctrine->em->getRepository('Entities\Recurso')->getRecursosPublicados();
        $dirRespaldos = FCPATH."respaldos_datasets/";
        $requestHeaders = array(
            "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Accept-Encoding" => "gzip,deflate",
            "Accept-Language" => "es-419,es;q=0.8,en-US;q=0.6,en;q=0.4",
            "Cache-Control" => "max-age=0",
            "Connection" => "keep-alive",
            "Cookie" => "ASP.NET_SessionId=xlf1hmlxz5uz3j2kebpjf3qm",
            "Host" => "data.mineduc.cl",
            "User-Agent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36"
        );
        $inicio = new DateTime();
        $descargados = 0;
        $errores = 0;
        $timeouts = 0;
        $yadescargados = 0;
        $total = count($recursos);
        $logArray = array(array('institución', 'dataset', 'recurso', 'url_recurso', 'archivo_descargado', 'estado'));

        for($i = 0; $i < $total; $i++){
            $safeUrl = str_replace(" ", "%20", $recursos[$i]['url']);
            echo "\033[34m";
            echo "Descargando recurso: ";
            echo "\033[37m";
            echo $recursos[$i]['codigo'];
            echo " (recurso ".($i+1)." de ".$total.")";
            echo "\n";
            echo "\033[34m";
            echo "Url del recurso: ";
            echo "\033[37m";
            echo $safeUrl;
            echo "\n";
            echo "\033[34m";
            echo "Mime del recurso: ";
            echo "\033[37m";
            echo $recursos[$i]['mime'];
            echo "\n";

            $ch = curl_init($safeUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
            $response = curl_exec($ch);

            if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == "200"){
                $pathInfo = pathinfo($safeUrl);
                $filename = $pathInfo['filename'] . '-' . $recursos[$i]['codigo'] . '.' . (isset($pathInfo['extension']) ? $pathInfo['extension'] : 'txt');
                echo $filename;
                echo "\n";
                if(file_exists($dirRespaldos.$filename)){
                    echo "\033[33m";
                    echo "Archivo ya descargado.\n";
                    echo "\033[37m";
                    $yadescargados++;
                    $logArray[] = $this->addToLog($recursos[$i], $filename, 'descargado');
                } else {
                    echo "\033[32m";
                    echo "Url válida.\n";
                    echo "\033[34m";
                    echo "\tcontent-type del recurso: ";
                    echo "\033[37m";
                    print_r(curl_getinfo($ch, CURLINFO_CONTENT_TYPE));
                    echo "\n";
                    echo "\033[34m";
                    echo "\tFile name: ";
                    echo "\033[37m";
                    echo $filename;
                    echo "\n";

                    $fp = fopen($dirRespaldos.$filename, 'w');

                    curl_close($ch);
                    $ch = curl_init($safeUrl);
                    curl_setopt($ch, CURLOPT_FILE, $fp);

                    $response = curl_exec($ch);
                    curl_close($ch);
                    fclose($fp);
                    echo "\033[32m";
                    echo "\tDescarga completa!\n";
                    echo "\033[37m";
                    $descargados ++;
                    $logArray[] = $this->addToLog($recursos[$i], $filename, 'descargado');
                }
            }else{
                if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == "0"){
                    echo "\033[31m";
                    echo "No se pudo consultar la url, Timeout";
                    echo "\033[37m";
                    $timeouts++;
                    $logArray[] = $this->addToLog($recursos[$i], '-', 'error [timeout]');
                } else {
                    echo "\033[31m";
                    echo "Url no válida, se ignora la descarga";
                    echo "\033[37m";
                    echo "\n";
                    echo "\033[34m";
                    echo "\tCodigo HTTP: ";
                    echo curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    echo "\033[37m";
                    $errores++;
                    $logArray[] = $this->addToLog($recursos[$i], '-', 'error [url inválida]');
                }
                log_message('error', 'El recurso '.$recursos[$i]['id'].' no se ha podido descargar');
                curl_close($ch);
                echo "\n";
            }

            echo "=====================================================";
            echo "\n\n";
        }
        //Crea el archivo de log
        $logFile = FCPATH."log_respaldos.csv";
        if(file_exists($logFile))
            unlink($logFile);
        $lfr = fopen($logFile, "w");
        foreach($logArray as $logRow)
            fputcsv($lfr, $logRow, "\t");
        fclose($lfr);

        echo "\n";
        $fin = new DateTime();
        $delta = $fin->getTimestamp() - $inicio->getTimestamp();
        echo "\033[34m";
        echo "Tiempo de ejecución: ";
        echo "\033[37m";
        echo $delta . " segundos.";
        echo "\n";
        echo "\033[34m";
        echo "Archivos descargados: ";
        echo "\033[37m";
        echo $descargados;
        echo "\n";
        echo "\033[34m";
        echo "Omitidos (descargados previamente): ";
        echo "\033[37m";
        echo $yadescargados;
        echo "\n";
        echo "\033[34m";
        echo "Url con error: ";
        echo "\033[37m";
        echo $errores;
        echo "\n";
        echo "\033[34m";
        echo "Timeouts: ";
        echo "\033[37m";
        echo $timeouts;
        echo "\n";
    }

    public function addToLog($recurso, $filename, $estado){
        return array($recurso['dataset']['servicio']['nombre'], $recurso['dataset']['titulo'], $recurso['descripcion'], $recurso['url'], $filename, $estado);
    }
} 