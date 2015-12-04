<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\services;

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