<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\remote;

use Yii;
use canis\sensors\base\CheckEvent;

class ProviderSensor extends \canis\sensors\remote\Sensor
{
	public function name()
	{
		return 'Sensor Provider';
	}

	public function getId()
	{
		return 'provider-sensor';
	}

	public function getDefaultCheckRetries()
	{
		return 1;
	}

	protected function doCheck(CheckEvent $event)
	{
		if (empty($event->sensorInstance->objectModel)) {
			$event->state = static::STATE_CHECK_FAIL;
			return;
		}
		$providerModel = $event->sensorInstance->objectModel;
		$providerModel->dataObject->check($event);
	}

	public function getCheckInterval($sensorInstance)
	{
		$providerModel = $sensorInstance->objectModel;
		if (!$providerModel) {
			return '+1 minute';
		}
		return $providerModel->dataObject->attributes['checkInterval'];
	}
}