<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\base;

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
	public $payload;

	protected $_isCritical;

	abstract public function name();

	public function getDefaultIsCritical()
	{
		return true;
	}

	public function getIsCritical()
	{
		if (!isset($this->_isCritical)) {
			return $this->getDefaultIsCritical();
		}
		return $this->_isCritical;
	}

	public function setIsCritical($isCritical)
	{
		$this->_isCritical = $isCritical;
		return $this;
	}

	public function getObjectTypeDescriptor()
	{
		return 'Sensor';
	}

	public function simpleProperties()
    {
    	$properties = parent::simpleProperties();
    	$properties['payload'] = $this->payload;
    	return $properties;
    }

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

	public function describeEvent($sensorInstance, $event)
	{
		$shiftParts = [];
		$oldState = $event->old_state === static::STATE_CHECK_FAIL ? 'Check Fail' : $event->old_state;
		$newState = $event->new_state === static::STATE_CHECK_FAIL ? 'Check Fail' : $event->new_state;;

		$shiftParts[] = ucfirst($oldState);
		$shiftParts[] = 'to';
		$shiftParts[] = ucfirst($newState);

		return implode(' ', $shiftParts);
	}
	
	public function describeEventFormatted($sensorInstance, $event)
	{
		$shiftParts = [];
		$oldState = $event->old_state === static::STATE_CHECK_FAIL ? 'Check Fail' : $event->old_state;
		$newState = $event->new_state === static::STATE_CHECK_FAIL ? 'Check Fail' : $event->new_state;;
		$shiftParts[] = ucfirst($oldState);
		$shiftParts[] = '<span class="fa fa-arrow-right"></span>';
		$shiftParts[] = ucfirst($newState);

		return implode(' ', $shiftParts);
	}

	public function describe($sensorInstance)
	{
		if ($sensorInstance->model->state === static::STATE_NORMAL) {
			return 'All is normal';
		}
		if ($sensorInstance->model->state === static::STATE_UNCHECKED) {
			return 'Sensor is unchecked';
		}
		if ($sensorInstance->model->state === static::STATE_LOW) {
			return 'Sensor is low';
		}
		if ($sensorInstance->model->state === static::STATE_HIGH) {
			return 'Sensor is high';
		}
		if ($sensorInstance->model->state === static::STATE_ERROR) {
			return 'Sensor contains an error';
		}
		if ($sensorInstance->model->state === static::STATE_FAIL) {
			return 'Sensor could not be checked';
		}
		return 'Unknown sensor state';
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