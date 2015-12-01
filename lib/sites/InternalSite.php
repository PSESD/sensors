<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\sites;

use canis\sensors\remote\HttpTest;

class InternalSite extends Base
{
	public function defaultSensors()
	{
		$sensors = parent::defaultSensors();
		return $sensors;
	}
}