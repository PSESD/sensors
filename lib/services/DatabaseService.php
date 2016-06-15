<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\services;

class DatabaseService extends Base
{
	public function getType()
	{
		return 'db';
	}
	public function getDefaultName()
	{
		return 'Database';
	}
	public function getDefaultId()
	{
		return 'db';
	}
}