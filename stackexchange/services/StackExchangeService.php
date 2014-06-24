<?php

namespace Craft;

class StackExchangeService extends BaseApplicationComponent
{

	protected $_apiUrl;
	
	public function init()
	{
		parent::init();

		$this->_apiUrl = 'http://api.stackexchange.com/2.2/';
	}


	public function getProfiles($ids = array())
	{
		$ids     = is_array($ids) ? implode(";", $ids) : $ids;
		$request = $this->_curlRequest('users/'.$ids, array( 'site' => 'craftcms' ));

		if ( ! empty($request->items))
			return $request->items;
		else
			return false;
	}


	public function getProfile($id)
	{
		$request = $this->getProfiles($id);

		if ( ! empty($request[0]))
			return $request[0];
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


	/**
	 * Translates a string with underscores
	 * into camel case (e.g. first_name -> firstName)
	 * https://gist.githubusercontent.com/paulferrett/8141290/raw/camel_case_functions.php
	 *
	 * @param string $str String in underscore format
	 * @param bool $capitalise_first_char If true, capitalise the first char in $str
	 * @return string $str translated into camel caps
	 */
	
	private function _to_camel_case($str, $capitalise_first_char = false)
	{
		if ($capitalise_first_char) {
			$str[0] = strtoupper($str[0]);
		}

		$func = create_function('$c', 'return strtoupper($c[1]);');
		
		return preg_replace_callback('/_([a-z])/', $func, $str);
	}


}