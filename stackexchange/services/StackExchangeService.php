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
		if ( ! empty($data))
			$uri .= '?' . http_build_query($data);

		$cachedResponse = craft()->fileCache->get($uri);

		if ($cachedResponse) {
			return json_decode($cachedResponse);
		}

		try {
			$client   = new \Guzzle\Http\Client($this->_apiUrl);
			$request  = $client->get($uri, array(), array(
				'headers' => array(
					'Content-Type'    => 'application/json; charset=utf-8',
					'Accept'          => 'application/json, text/javascript, */*; q=0.01',
					'Accept-Encoding' => 'gzip'
				)
			));

			$response = $request->send();

			if ( ! $response->isSuccessful()) {
				return;
			}

			craft()->fileCache->set($uri, $response->getBody(true), 1800); // set to expire in 30 minutes

			return json_decode($response->getBody(true));
		} catch(\Exception $e) {
			return;
		}

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