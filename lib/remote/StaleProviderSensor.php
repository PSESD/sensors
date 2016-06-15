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

class StaleProviderSensor extends \canis\sensors\remote\Sensor
{
	public function name()
	{
		return 'Stale Provider';
	}

	public function getId()
	{
		return 'stale-provider';
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
		if ($providerModel->dataObject->isStale()) {
			$event->state = static::STATE_ERROR;
		} else {
			$event->state = static::STATE_NORMAL;
		}
	}

	public function getCheckInterval($sensorInstance)
	{
		$providerModel = $sensorInstance->objectModel;
		if (!$providerModel) {
			return '+1 minute';
		}
		$failedAttempts = 2;
		$checkInterval = "+5 minutes";
        if (isset($providerModel->dataObject->attributes['checkInterval'])) {
            $checkInterval = $providerModel->dataObject->attributes['checkInterval'];
        }
		$timeFromNow = strtotime($checkInterval) - time();
		$timeAgain = time() + ($timeFromNow * $failedAttempts);
		return gmdate('c', $timeAgain);
	}
}