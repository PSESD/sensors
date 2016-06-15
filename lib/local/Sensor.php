<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\local;

use Yii;

abstract class Sensor extends \psesd\sensors\base\Sensor
{
	protected $_id;
	public function setId($id)
	{
		$this->_id = $id;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function getCheckInterval($sensorInstance)
	{
		return false;
	}

	public function getDefaultCheckRetries()
	{
		return 0;
	}

	public function onInstantiation($sensorInstance)
	{
		return $sensorInstance->check();
	}
}