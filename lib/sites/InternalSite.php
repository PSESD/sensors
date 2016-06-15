<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\sites;

use psesd\sensors\remote\HttpTest;

class InternalSite extends Base
{

	public function getObjectTypeDescriptor()
    {
        return 'Internal Only Site';
    }

	public function defaultSensors()
	{
		$sensors = parent::defaultSensors();
		return $sensors;
	}
}