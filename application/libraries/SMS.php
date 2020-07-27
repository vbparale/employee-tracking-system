<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *  CI Library Class for FLI SMS feature
 *  Author: Ben Zaraynine E. Obra
 *  Date:  May 1, 2020
 * 
 */

 use GuzzleHttp\Client;
 use GuzzleHttp\Cookie\CookieJar;
 use GuzzleHttp\Exception\ClientException;

class sms {

    /**
     * Temporary API essentials
     */

     protected $HOST = 'http://10.15.7.199/';
     protected $BASE_URI = 'smsgateway/api/v1/';
    //end
    private $client;
    private $functionKey;

    public $headers = array('Accept' => 'application/json');
    public $native = false;
    public $endpoint = 'sms/send';

    function __construct(){

        $this->functionKey = '';

        $this->client = new Client([
            'headers' => $this->headers
        ]);

    }

    public function send($body=null){

        $validation = array('success' => 'fail','data' => [
            'content' => 'Parameters received not initialized',
            'status' => null
        ]);

        $this->functionKey = 'send';

        if($body){

            if(isset($body['mobile'])){
                
                $response = $this->response($body);

                if ($response) {
                    
                    $validation['success'] = 'true';
                    $validation['data']['content'] = $response['contents']['transaction_id'];
                    $validation['data']['status'] = $response['status'];
                    $validation['data']['reason'] = $response['reason'];

                } else {

                    $validation['success'] = 'error';
                    $validation['data']['content'] = 'Error upon processing API response';
                }
                
            } else {

                $validation['data']['content'] = 'Array key named "mobile" is a must';
            }
        }

        return $validation;
    }

    private function response($body){

        $response = false;
        
        if($this->client && $body){

            $parsedBody = $this->BodyParser($body);
            
            if ($parsedBody) {
                
                $guzzleInit = $this->guzzleinit($parsedBody,$this->endpoint);

                if ($guzzleInit) {
                    
                    $response['status'] = $guzzleInit->getStatusCode();

                    $content = $guzzleInit->getBody()->getContents();
                    $response['contents'] = ($this->native ? $content : json_decode($content,true));
                    $response['reason'] = $guzzleInit->getReasonPhrase();
    
                } else {

                    $response['status'] = 'false';
                    $response['contents'] = 'Failed on initializing Guzzle HTTP';
                }                    

            }           

        }            
        
        return $response;
    }

    private function guzzleinit($body,$endpoint){

        if($body && $endpoint){

            if (is_array($body)) {
                
                $body = array('json' => $body);

            } else {

                $body = array('body' => $body);
            }

            $uri = $this->HOST.$this->BASE_URI.$endpoint;

            try {
                
                switch($this->functionKey){

                    case 'send':
                        $totalReposponse = $this->client->post($uri,$body);
                    break;
                    default:
                        $totalReposponse = $this->client->get($uri);
                    break;
                }

                return $totalReposponse;

            } catch (ClientException $e) {

                return $e->getResponse();
            }

            
        } else {

            return false;
        }

    }

    private function BodyParser($arrayVal){

        $output = false;
        
        if ($arrayVal && is_array($arrayVal)) {
            
            switch($this->headers['Accept']){
                
                case 'application/text':
                case 'application/xml':
                    $xml = new SimpleXMLElement('<root/>');
                    $output = $this->array_to_xml($arrayVal,$xml);
                break;
                default:
                $output = $arrayVal;
                break;
            }

        }
        
        return $output;

    }

	/*
		Array to PHP converter
		Reference link: https://stackoverflow.com/questions/37618094/php-convert-array-to-xml	 
	*/

	function array_to_xml($array, $xml) {

		$output = false;

	    foreach($array as $key => $value) { 

	        if(is_array($value)) {   

	            if(!is_numeric($key)){

	                $subnode = $xml->addChild($key);
	                array_to_xml($value, $subnode);

	            } else {

	                array_to_xml($value, $subnode);

	            }

	        } else {

	            $xml->addChild($key, $value);
	        }
	    }

		$dom = dom_import_simplexml($xml);
		
		if ($dom) {
			
			$output = $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement);
		}

		return $output;    

    }
        
}