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

		if ( ! empty($request->items)) {

			foreach($request->items as $item)
			{
				foreach($item as $key => $value)
				{
					if (is_array($value))
					{
						$this->_updateKeys($value);
					}
					else
					{
						$this->_updateKeys($item);
					}
				}
			}

			if (sizeof($request->items) > 1)
				return $request->items;
			else
				return $request->items[0];
		} else {
			return false;
		}
	}

	public function getProfile($id)
	{
		$request = $this->getProfiles($id);

		return $request;
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


	private function _updateKeys($item)
	{
		foreach($item as $key => $value) {
			if (strpos($key, '_') !== FALSE) {
				$item->{$this->_to_camel_case($key)} = $value;
				unset($item->{$key});
			}
		}
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