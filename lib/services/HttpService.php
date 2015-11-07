<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\services;

class HttpService extends Base
{

	public function getType()
	{
		return 'web';
	}

	public function getDefaultName()
	{
		return 'Web';
	}
	public function getDefaultId()
	{
		return 'http';
	}
}