<?php

	/**
	 * AviaryFX PHP SDK
	 * 
	 * @version 1.0
	 * @author Bruce Drummond
	 * @package AviaryFX
	 */
	class AviaryFX 
	{
		
		const VERSION = "0.2";
		const PLATFORM = "web";
		const HARDWARE_VERSION = "1.0";
	 	const SOFTWARE_VERSION = "PHP";
		const APP_VERSION = "1.0";

		const SERVER 			= 	"http://cartonapi.aviary.com/services";
		const GET_TIME_URL		=	"/util/getTime";
		const GET_FILTERS_URL 	= 	"/filter/getFilters";
		const UPLOAD_URL 		= 	"/ostrich/upload";
		const RENDER_URL 		= 	"/ostrich/render";
		
		protected $api_key;
		protected $api_secret;
		
		/**
		 * Constructor
		 * 
		 * @param string $api_key
		 * @param string $api_secret
		 */
		public function __construct($api_key, $api_secret)
		{
			$this->api_key = $api_key;
			$this->api_secret = $api_secret;
		}
		
		/**
		 * Gets a list of available filters.
		 * 
		 * @return array Array of filters with label, uid, description and parameter list for each filter. 
		 */
		public function getFilters()
		{
			$api_key = $this->api_key;
			$api_secret = $this->api_secret;
			$version = self::VERSION;
			$platform = self::PLATFORM;
			$hardware_version = self::HARDWARE_VERSION;
			$software_version = self::SOFTWARE_VERSION;
			$app_version = self::APP_VERSION;
			$ts = $this->getTime();
			$paramsToHash = compact('api_key', 'platform', 'hardware_version', 'software_version', 'app_version', 'ts', 'version');
			$api_sig = $this->getApiSignature($paramsToHash);
			$params = compact('api_key', 'platform', 'hardware_version', 'software_version', 'app_version', 'ts', 'version', 'api_sig');
			$url = self::SERVER . self::GET_FILTERS_URL;
			$result = $this->request($url, $params);
			if($result != null) {
				$xml = new SimpleXMLElement($result);
		  		$filters = new SimpleXMLElement('<filters />');
		  		foreach ($xml->filters->filter as $item) {
		  			$filter = $filters->addChild('filterInfo');
		  			$filter->addChild('label', $item['label']);
		  			$filter->addChild('uid', $item['uid']);
		  			$filter->addChild('description', $item->description);
		  		 	$parameters = $filter->addChild('parameterList');
		  			foreach ($item->filtermetadata->parameter as $parameter) {
		  				$parameterNode = $parameters->addChild("parameter");
		  				foreach ($parameter->attributes() as $key => $value) {
		  					$parameterNode->addAttribute($key, $value);
		  				}
		  			}
		  		}
		  		return $this->objectsIntoArray( $filters );
			}
		}
		
		/**
		 * Uploads an image to the Aviary server.
		 * 
		 * @param string $filename
		 * @return array Array with url to the file
		 */
		public function upload($filename)
		{
			$api_key = $this->api_key;
			$api_secret = $this->api_secret;
			$version = self::VERSION;
			$platform = self::PLATFORM;
			$hardware_version = self::HARDWARE_VERSION;
			$software_version = self::SOFTWARE_VERSION;
			$app_version = self::APP_VERSION;
			$ts = $this->getTime();
			$paramsToHash = compact('api_key', 'platform', 'hardware_version', 'software_version', 'app_version', 'ts', 'version');
			$api_sig = $this->getApiSignature($paramsToHash);
			$file = '@' . $filename;
			$params = compact('api_key', 'platform', 'hardware_version', 'software_version', 'app_version', 'ts', 'version', 'file', 'api_sig');
			$url = self::SERVER . self::UPLOAD_URL;
			$result = $this->request($url, $params);
			if($result != null) {
				$xml = new SimpleXMLElement($result);
		  		$url = $xml->response->files->file['url'];
		  		$uploadresponse = new SimpleXMLElement('<uploadresponse />');
		  		$uploadresponse->addChild('url', $url);
		  		return $this->objectsIntoArray( $uploadresponse );
			}
		}
		
		/**
		 * Renders a filter options thumbnail grid and returns render parameters for each option.
		 * 
		 * @param string $backgroundcolor
		 * @param string $format
		 * @param string $quality
		 * @param string $scale
		 * @param string $filepath
		 * @param string $filterid
		 * @param string $cols
		 * @param string $rows
		 * @param string $cellwidth
		 * @param string $cellheight
		 * @return array Array with url to thumbnail grid and render option parameters
		 */
		public function renderOptions($backgroundcolor, $format, $quality, $scale, $filepath, $filterid, $cols, $rows, $cellwidth, $cellheight)
		{
			$api_key = $this->api_key;
			$api_secret = $this->api_secret;
			$version = self::VERSION;
			$platform = self::PLATFORM;
			$hardware_version = self::HARDWARE_VERSION;
			$software_version = self::SOFTWARE_VERSION;
			$app_version = self::APP_VERSION;
			$calltype = "filteruse";
			$ts = $this->getTime();
			$paramsToHash = compact(	'api_key', 'platform', 'hardware_version', 'software_version', 'app_version', 'ts', 'version', 'calltype', 'backgroundcolor', 
										'format', 'quality', 'scale', 'filepath', 'filterid', 'cols', 'rows', 'cellwidth', 'cellheight');
			$api_sig = $this->getApiSignature($paramsToHash);
			$params = compact(	'api_key', 'platform', 'hardware_version', 'software_version', 'app_version', 'ts', 'version', 'calltype', 'backgroundcolor',
								'format', 'quality', 'scale', 'filepath', 'filterid', 'cols', 'rows', 'cellwidth', 'cellheight', 'api_sig');
			$url = self::SERVER . self::RENDER_URL;
			$result = $this->request($url, $params);
			if($result != null) {
				$xml = new SimpleXMLElement($result);
				$renderOptionsGrid = new SimpleXMLElement('<renderOptionsGrid />');
				$renderOptionsGrid->addChild('url', $xml->ostrichrenderresponse->url);
				$renderOptionParams = $xml->ostrichrenderresponse->renders;
				$renderReponse = compact('renderOptionsGrid', 'renderOptionParams');
				return $this->objectsIntoArray( $renderReponse ); 
			}
		}
		
		/**
		 * Renders image based on render parameters.
		 * 
		 * @param string $backgroundcolor
		 * @param string $format
		 * @param string $quality
		 * @param string $scale
		 * @param string $filepath
		 * @param string $filterid
		 * @param string $width
		 * @param string $height
		 * @param array $renderparameters
		 * @return array Array with URL to rendered image
		 */
		public function render($backgroundcolor, $format, $quality, $scale, $filepath, $filterid, $width, $height, $renderparameters)
		{
			$api_key = $this->api_key;
			$api_secret = $this->api_secret;
			$version = self::VERSION;
			$platform = self::PLATFORM;
			$hardware_version = self::HARDWARE_VERSION;
			$software_version = self::SOFTWARE_VERSION;
			$app_version = self::APP_VERSION;
			$calltype = "filteruse";
			$cols = "0";
			$rows = "0";
			$cellwidth = $width;
			$cellheight = $height;
			$ts = $this->getTime();
  			$renderparameters = $this->array2xml($renderparameters);
			$paramsToHash = compact(	'api_key', 'platform', 'hardware_version', 'software_version', 'app_version', 'ts', 'version', 'calltype', 'backgroundcolor', 
										'format', 'quality', 'scale', 'filepath', 'filterid', 'cols', 'rows', 'cellwidth', 'cellheight', 'renderparameters');
			$api_sig = $this->getApiSignature($paramsToHash);
			$params = compact(	'api_key', 'platform', 'hardware_version', 'software_version', 'app_version', 'ts', 'version', 'calltype', 'backgroundcolor', 
								'format', 'quality', 'scale', 'filepath', 'filterid', 'cols', 'rows', 'cellwidth', 'cellheight', 'renderparameters', 'api_sig');
			$url = self::SERVER . self::RENDER_URL;
			$result = $this->request($url, $params);
			if($result != null) {
				$xml = new SimpleXMLElement($result);
				$renderedImage = $xml->ostrichrenderresponse->url;
				$renderResponse = new SimpleXMLElement('<renderresponse />');
				$renderResponse->addChild('url', $renderedImage);
				return $this->objectsIntoArray($renderResponse);
			}
		}
		
		/**
		 * Returns the current server time
		 * 
		 * @return string Current time on the server
		 */
		protected function getTime()
		{
			$api_key = $this->api_key;
			$platform = self::PLATFORM;
			$hardware_version = self::HARDWARE_VERSION;
			$software_version = self::SOFTWARE_VERSION;
			$app_version = self::APP_VERSION;
			$ts = time();
			$paramsToHash = compact('api_key', 'platform', 'hardware_version', 'software_version', 'app_version', 'ts');
			$api_sig = $this->getApiSignature($paramsToHash);
			$params = compact('api_key', 'platform', 'hardware_version', 'software_version', 'app_version', 'ts', 'api_sig');
			$url = self::SERVER . self::GET_TIME_URL;
			$result = $this->request($url, $params);
			if($result != null) {
				$xml = new SimpleXMLElement($result);
			  	$serverTime = $xml['servertime'];
			  	return $serverTime;
			}
		}
		
		/**
		 * Returns the api signature for the params
		 * 
		 * @param array $paramsToHash
		 * @return string Api signature string
		 */
		protected function getApiSignature($paramsToHash)
		{
			$paramString = '';
			ksort($paramsToHash);
			foreach($paramsToHash as $keys => $values) {
				$paramString[] = $keys . $values;
			}
			$stringToMD5 = implode("", $paramString);
			$api_sig = md5( $this->api_secret . $stringToMD5 );
			return $api_sig;
		}
		
		/**
		 * Makes a curl request and returns the response
		 * 
		 * @param string $url
		 * @param array $params
		 * @return string Server response as a string
		 */
		protected function request($url, $params) 
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HEADER, FALSE);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($curl, CURLOPT_POST, TRUE);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
			if( curl_exec($curl) === false ) {
			    echo "Error: " . curl_error($curl);
			} else {
			    $response = curl_exec($curl);
			}
			curl_close($curl);
			return $response;
		}
		
		/**
		 * Converts a SimpleXMLObject into an array. http://php.net/manual/en/book.simplexml.php
		 * 
		 * @param SimpleXMLObject $arrObjData
		 * @param array $arrSkipIndices
		 * @return array Array for the converted object
		 */
		protected function objectsIntoArray($arrObjData, $arrSkipIndices = array())
		{
		    $arrData = array();
		    
		    if ( is_object($arrObjData) ) {
		        $arrObjData = get_object_vars($arrObjData);
		    }
		    
		    if ( is_array($arrObjData) ) {
		        foreach ($arrObjData as $index => $value) {
		            if ( is_object($value) || is_array($value) ) {
		                $value = $this->objectsIntoArray($value, $arrSkipIndices); // recursive call
		            }
		            if ( in_array($index, $arrSkipIndices) ) {
		                continue;
		            }
		            $arrData[$index] = $value;
		        }
		    }
		    return $arrData;
		}
		
		/**
		 * Converts an array into a SimpleXMLObject and returns the filter parameters as xml
		 * 
		 * @param array $data
		 * @param string $rootNodeName
		 * @param string $xml
		 * @return xml Filter parameters as XML
		 */
		protected function array2xml($data, $rootNodeName = 'parameters', $xml=null)
		{
			$output = new SimpleXMLElement('<response />');
	        if (ini_get('zend.ze1_compatibility_mode') == 1) {
	            ini_set ('zend.ze1_compatibility_mode', 0);
	        }
	
	        if ( is_null($xml) ) {
	            $xml = $output->addChild($rootNodeName);
	        }
	
	        foreach($data as $key => $value) {
	            if ( is_numeric($key) ) {
	                $key = $rootNodeName;
	            }
	
	            $key = preg_replace('/[^a-z0-9\-\_\.\:]/i', '', $key);
	
	            if ( is_array($value) ) {
	                if($key != "attributes") {
	                	$node = $this->isAssoc($value) ? $xml->addChild($key) : $xml;
	                } else {
	                	$node = $this->isAssoc($value) ? $xml : $xml;
	                }
	                $this->array2xml($value, $key, $node);
	            } else {
	                $value = htmlentities($value);
	                $xml->addAttribute($key, (string) $value);
	            }
	        }
	        return $output->parameters->asXML();
		}
		
		protected function isAssoc( $array ) {
	        return ( is_array($array) && 0 !== count( array_diff_key( $array, array_keys( array_keys($array) ) ) ) );
	    }
	
	}

?>