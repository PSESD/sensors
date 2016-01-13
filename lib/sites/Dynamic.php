<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\sites;

use psesd\sensors\remote\HttpTest;

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