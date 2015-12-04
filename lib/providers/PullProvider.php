<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\providers;

use Yii;
use canis\sensors\remote\PullProviderSensor;

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