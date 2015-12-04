<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\sites;

use canis\sensors\remote\HttpTest;

class Dynamic extends Base
{
	public function getObjectTypeDescriptor()
    {
        return 'Dynamic Site';
    }

	public function defaultSensors()
	{
		$sensors = parent::defaultSensors();
		$sensors['http-test'] = [
			'class' => HttpTest::className()
		];
		return $sensors;
	}
}