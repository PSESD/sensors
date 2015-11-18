<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\base;

use Yii;

abstract class Sensor
	extends BaseObject
	implements SensorInterface
{
	const STATE_CHECK_FAIL = 'checkFail';
	const STATE_ERROR = 'error';
	const STATE_LOW = 'low';
	const STATE_NORMAL = 'normal';
	const STATE_HIGH = 'high';
	const STATE_UNCHECKED = 'unchecked';
	
	abstract public function name();

	public function behaviors()
	{
		return array_merge(parent::behaviors(), [
			'HasSensors' => ['class' => HasSensorsBehavior::className()]
		]);
	}

	public function getName()
	{
		return $this->name();
	}


	public function onInstantiation($sensorInstance)
	{
		return true;
	}

	public function check($sensorInstance)
	{
		$event = new CheckEvent;
		$event->sensorInstance = $sensorInstance;
		try {
			$this->doCheck($event);
		} catch (\Exception $e) {
			$event->state = static::STATE_CHECK_FAIL;
			$event->addError('Exception: ' . $e->getMessage());
			echo $e->getMessage() . PHP_EOL;
		}
		return $event;
	}

	abstract protected function doCheck(CheckEvent $event);

	public function setCheckRetries($retries)
	{
		$this->_checkRetries = $retries;
	}

	public function getCheckRetries()
	{
		if (isset($this->_checkRetries)) {
			return $this->_checkRetries;
		}
		return $this->getDefaultCheckRetries();
	}

	public function getDefaultCheckRetries()
	{
		return 1;
	}

	public function setCheckRetryInterval($interval)
	{
		$this->_checkRetryInterval = $interval;
	}

	public function getCheckRetryInterval()
	{
		if (isset($this->_checkRetryInterval)) {
			return $this->_checkRetryInterval;
		}
		return $this->getDefaultCheckRetryInterval();
	}

	public function getDefaultCheckRetryInterval()
	{
		return 5;
	}

	public function discoverInitialCheck($providerInstance)
	{
		return '+1 minute';
	}

	public function getCheckInterval($sensorInstance)
	{
		return '+1 minute';
	}

	public function getFailbackTime($sensorInstance)
	{
		return '+1 minute';
	}
}