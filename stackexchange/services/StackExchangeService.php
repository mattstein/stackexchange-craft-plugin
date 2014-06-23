<?php

namespace Craft;

class StackExchangeService extends BaseApplicationComponent
{

	protected $_stackExchange;
	protected $_apiUrl;

	
	public function __construct($stackExchange = null)
	{
		$this->_stackExchange = $stackExchange;
		$this->_apiUrl        = 'http://api.stackexchange.com/2.2/';
	}

	
	public function getProfile($id)
	{
		$request = $this->_curlRequest('users/'.$id, array( 'site' => 'craftcms' ));

		if ( ! empty($request->items[0]))
			return $request->items[0];
		else
			return false;
	}

	
	private function _curlRequest($uri = '', $data = array())
	{
		$baseUrl = $this->_apiUrl;
		$apiUrl  = $baseUrl . $uri;
		
		if ( ! empty($data))
			$apiUrl .= '?' . http_build_query($data);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8","Accept:application/json, text/javascript, */*; q=0.01")); 
		curl_setopt($ch, CURLOPT_URL, $apiUrl);
		curl_setopt($ch, CURLOPT_ENCODING , "gzip");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);

		$response = trim(curl_exec($ch));
		curl_close($ch);

		return json_decode($response);
	}

}