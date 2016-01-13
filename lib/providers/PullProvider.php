<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\providers;

use Yii;
use psesd\sensors\remote\PullProviderSensor;

class PullProvider 
	extends Base
	implements PullProviderInterface
{
	
	public function getObjectTypeDescriptor()
	{
		return 'Pull Provider';
	}

	public function defaultSensors()
	{
		$sensors = parent::defaultSensors();
		$sensors['provider-sensor'] = [
			'class' => PullProviderSensor::className()
		];
		return $sensors;
	}

}