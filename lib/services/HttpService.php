<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\services;

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