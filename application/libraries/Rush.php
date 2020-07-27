<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
	WeServe RUSH Interface Integration
	Author: Ben Zarmaynine E. Obra
	Added: January 15, 2020

	Library designed to integrate RUSH Web Services for WeServe
**/

class Rush {

	private $base_uri;
	private $headers;
	private $ws_method = '';
	private $user;

	function __construct($WeServeID = null){

		$this->base_uri = 'http://10.15.7.64/rushwebservice_dev/rushws.asmx';
		$this->headers = array("Content-type: text/xml","Accept: text/xml");
		$this->user = (isset($WeServeID) ? $WeServeID[0] : 'IT00');

	}

	public function rushPOST($method,$body){

		if ($method && $body) {

			/*
				Iniatialization of necessary varibales
			*/
			$soapAction = 'SOAPAction: http://tempuri.org/RushWebService/RUSHWS/'.$method;
			$this->ws_method = $method;

			array_push($this->headers, $soapAction);
			
			return $this->xmlResponse($body);

			


		} else {

			return false;
		}

	}

	public function rushGET($method,$body){

		if ($method && $body) {
			
		}
	}


	private function xmlResponse($body){

		if (is_array($body) && $body) {
			
			$body_params = $this->parseMethod($body);

			if ($body_params) {

				$totalResponse = $this->totalResponse($body_params);

				/*
					Create RUSH Ticket
				*/


				$rush_ticket = $this->SOAPinit($totalResponse);

				if ($rush_ticket) {
					array_pop($this->headers);
					return $rush_ticket;
				}

			} else {

				return false;
			}
	

		} else {

			return false;
		}

	}

	private function SOAPinit($body){

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_URL, $this->base_uri);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		curl_setopt($ch, CURLOPT_POST, 1);

       
		$httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE); // this results 0 every time

		$responseBody = curl_exec($ch);

		$responseInfo = curl_getinfo($ch);
		curl_close($ch);       

		$json  = json_encode($responseBody);
		$configData = json_decode($json, true);		

		//var_dump($configData);exit;

		$ticket_num = strip_tags($responseBody,'');

		return $ticket_num;

	}

	private function totalResponse($parsedMethod){

		if ($parsedMethod) {
			if($this->ws_method == "PostRequestFormUsingXmlString"){
				$xmlResponse = '<?xml version="1.0" encoding="utf-8"?>
				<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
					<soap:Header>
						<AuthHeader xmlns="http://tempuri.org/RushWebService/RUSHWS">
							<SystemID>7</SystemID>
						</AuthHeader>
					</soap:Header>
					<soap:Body>
						<'.$this->ws_method.' xmlns="http://tempuri.org/RushWebService/RUSHWS">
							'.$parsedMethod.'
						</'.$this->ws_method.'>
					</soap:Body>
				</soap:Envelope>';
			}
			else if($this->ws_method == "GetStatCd"){
				$xmlResponse = '<?xml version="1.0" encoding="utf-8"?>
				<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				  <soap:Body>
					<'.$this->ws_method.' xmlns="http://tempuri.org/RushWebService/RUSHWS">
					  '.$parsedMethod.'
					</'.$this->ws_method.'>
				  </soap:Body>
				</soap:Envelope>';
			}

		} else {

			return false;
		}
		
		return $xmlResponse;
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
	

	function parseMethod($body){

		if ($body && is_array($body)) {
			
			switch ($this->ws_method) {
				case 'PostRequestFormUsingXmlString':
						/**
						 * RUSH Field handlers 
						 */
						$xml = new SimpleXMLElement('<REQST_PART_DTL/>');
						$request_dtl = $this->array_to_xml($body,$xml);
						//end
						$body_params = '<xmlString>
											<![CDATA[
											<NewDataSet>
											<REQST_MAST>
												<REQST_CD>SCR_RSH_05_01</REQST_CD>                
												<REQSTER>'.$this->user.'</REQSTER>
												<WFLOW_CD>SCR_RSH_05_01</WFLOW_CD>   
												<RMK /><MO_REQST_NUM />
											</REQST_MAST>
											<REQST_PART>
												<PART_CD>'.$body['PART_CD'].'</PART_CD>                            
												<LINE_NUM>1</LINE_NUM>
												<REQD_DT>'. date("m-d-Y") .'</REQD_DT>    
												<RMK />
											</REQST_PART>'.$request_dtl.'
											</NewDataSet>]]>
										</xmlString>';
					break;
				case 'GetStatCd':
					$body_params = '<reqstNum>'.$body['REQST_NUM'].'</reqstNum>';
					break;
				default:
					foreach ($body as $key => $value) {
						
						$body_params = '<'.$key.'>'.$value.'</'.$key.'>';
					}
					break;
			}

			return $body_params;

		} else {
			
			return false;
		}

	}


}