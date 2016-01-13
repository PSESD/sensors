<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\services;

class HttpsService extends HttpService
{
	public function getDefaultName()
	{
		return 'Secure Web';
	}
	public function getDefaultId()
	{
		return 'https';
	}
}