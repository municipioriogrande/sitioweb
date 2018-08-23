<?php

require_once('AccessMethods.php');

/**
 * Http client used to perform requests on Eventbrite API.
 */

require_once('AccessMethods.php');
/**
 * Http client used to perform requests on Eventbrite API.
 */
class HttpClient extends AccessMethods
{
    protected $token;
    const EVENTBRITE_APIv3_BASE = "https://www.eventbriteapi.com/v3";
	public $arguments = array();
	public $status = '';
	private $seconds_expire = 3600;
	
	public function setArguments($arguments){
		$this->arguments = $arguments;
	}
	public function setTimeUpdate($seconds_expire){
		$this->seconds_expire = $seconds_expire;
	}
    /**
     * Constructor.
     *
     * @param string $token the user's auth token.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }
	public function getStatus()
    {
        return $this->status;
    }
    public function get($path, array $expand = array())
    {
        return $this->request($path, array(), $expand, $httpMethod = 'GET');
    }
    public function post($path, array $data = array())
    {
        return $this->request($path, $data, array(), $httpMethod = 'POST');
    }
    public function delete($path, array $data = array())
    {
        return $this->request($path, $data, array(), $httpMethod = 'DELETE');
    }
    public function request($path, $body, $expand, $httpMethod = 'GET')
    {
        $data = json_encode($body);
        // I think this is the only header we need.  If there is a need
        // to pass more headers to the request, we could add a parameter
        // called headers to this function and combine whatever headers are passed
        // in with this header.
       /* $options = array(
            'http'=>array(
                'method'=>$httpMethod,
                'header'=>"content-type: application/json\r\n",
                'content'=>$data,
                'ignore_errors'=>true
            )
        );*/
		$options = array(
			'http'=>array(
				'method'=>$httpMethod,
				'header'=>"content-type: application/json\r\n",
				'ignore_errors'=>true
			)
		);
	
		if ($httpMethod == 'POST') {
			$options['http']['content'] = $data;
		}
		
		$pre_vars = '';
		$add_file_name = '';
		$empty_test_array = array_filter($this->arguments);
		if (!empty($empty_test_array))
  		{
			foreach($this->arguments as $key=> $value)
			{
				$pre_vars .= $key . '=' . $value . '&';
				$add_file_name = '_' . $key . '_' . $value ;
			}
		}

        $url = self::EVENTBRITE_APIv3_BASE . $path . '?'.$pre_vars.'token=' . $this->token;
		
		//echo $url;

        if (!empty($expand)) {
            $expand_str = join(',', $expand);
            $url = $url . '&expand=' . $expand_str;
        }
		//echo 'ZZZZZ|'.$path.'|ZZZZZ';
		$file_name = str_replace('/','_',$path);
		$file_name = $file_name . $add_file_name;
		
		# JSON DE HUBSPOT
		$name_file 	= dirname(__FILE__).'/json/data_eventbrite'.$file_name.'.json';
		$context  = stream_context_create($options);
		
		
		if(empty($this->seconds_expire))
		{
			$response = $this->MRG_make_file_hubspot_blog($url,$name_file,$context);
			$this->status = 'Instantly '.$hora_actual .'|'.$hora_archivo;
		}
		else
		{
			# Si el archivo no existe lo cre por primera vez
			if(!file_exists($name_file))
			{
				//echo '|1|'.'<br>'."\r";
				$response = $this->MRG_make_file_hubspot_blog($url,$name_file,$context);
				//$status = 'Init';
			}
			else
			{
				//echo '|2|'.'<br>'."\r";
				date_default_timezone_set('UTC');
				date_default_timezone_set("America/Argentina/Ushuaia");
				setlocale(LC_ALL,"es_ES");
				
				$hora 					= getdate();
				$segundos_menos 		= 3600*3; 									// Diferencia horaria (3hs Argentina)
				//$segundos_validos 		= 3600; 										// Segundos validos para el archivo (5hs)
				$segundos_validos 		= $this->seconds_expire;
				$hora_actual 			= strtotime(gmdate("M d Y H:i:s", ($hora[0]-$segundos_menos)));	// Formateamos hora de sistema
				$hora_archivo 			= strtotime(date("M d Y H:i:s", filemtime($name_file)));	// Formateamos hora de sistema
				//$horas_resta 			= ( $this->MRG_normalice_fecha($hora_actual) ) - ( $this->MRG_normalice_fecha($hora_archivo) );
				$horas_resta 			= $hora_actual - $hora_archivo;
				
				if($horas_resta<=$segundos_validos){
					$response = json_decode(file_get_contents($name_file), true);
					if ($response == NULL) {
						$response = array();
					}
					$this->status = 'On time '.$hora_actual .'|'.$hora_archivo.'|'.$horas_resta.'<='.$segundos_validos;
				}
				else
				{
					$response = $this->MRG_make_file_hubspot_blog($url,$name_file,$context);
					$this->status = 'Off time '.$hora_actual .'|'.$hora_archivo;
				}
				//echo $status.'<br>'."\r";
			}
		}

        return $response;
    }
	
	public function MRG_normalice_fecha($valor){
		list($h, $m, $s) 			= array_pad(preg_split('/[^\d]+/', $valor), 3, 0);
		$retorno 					= 3600*$h + 60*$m + $s;
		
		return $retorno;
	}
	
	public function MRG_make_file_hubspot_blog($url_post,$namefile,$context)
	{
		/*
		echo '|a|<br>'."\r";
		echo $url_post.'<br>'."\r";
		echo $namefile.'<br>'."\r";
		echo $context.'<br>'."\r";
		*/
		$name_file 	= $namefile;

		$result = file_get_contents($url_post, false, $context);
		
		$response = json_decode($result, true);
        if ($response == NULL) {
            $response = array();
        }
        //$response['response_headers'] = $http_response_header;
		
		if(is_array($response))
		{
			# Eliminamos archivo
			if(file_exists($namefile)){
				@unlink($namefile);
			}
	
			# Creamos archivo
			$fp = fopen($namefile,"w");
			if($fp != false){
				fwrite($fp, json_encode($response));
				fclose($fp);
			}
			
			return $response;
		}
	}
}
