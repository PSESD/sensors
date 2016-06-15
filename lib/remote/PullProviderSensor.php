<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\remote;

use Yii;
use psesd\sensors\base\CheckEvent;

class PullProviderSensor extends \psesd\sensors\remote\Sensor
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