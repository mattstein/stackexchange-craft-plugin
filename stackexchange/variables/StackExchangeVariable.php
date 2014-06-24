<?php

namespace Craft;

class StackExchangeVariable
{
	
	public function getProfile($id)
	{		
		return craft()->stackExchange->getProfile($id);
	}	

	public function getProfiles($ids = array())
	{		
		return craft()->stackExchange->getProfiles($ids);
	}	
	
}
