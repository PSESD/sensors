<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\sites;

use canis\sensors\remote\HttpTest;

class StaticSite extends Base
{
	protected function defaultSensors()
	{
		$sensors = parent::defaultSensors();
		$sensors['provider-sensor'] = [
			'class' => HttpTest::className()
		];
		return $sensors;
	}
}