<?php

namespace Craft;

class StackExchangeVariable
{
	
	public function getProfile($id)
	{		
		return craft()->stackExchange->getProfile($id);
	}	
	
}
