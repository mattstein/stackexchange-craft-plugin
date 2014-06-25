<?php

namespace Craft;

class StackExchangePlugin extends BasePlugin
{
	public function getName()
	{
		return Craft::t('Stack Exchange');
	}

	public function getVersion()
	{
		return '1.0.1';
	}

	public function getDeveloper()
	{
		return 'Matt Stein';
	}

	public function getDeveloperUrl()
	{
		return 'http://workingconcept.com';
	}	
}
