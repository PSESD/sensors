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
	public function loadModels(callable $modelBuilder)
	{
		if ($this->getModel() === null) {
			$this->_model = $modelBuilder($this);
		}
		if (!$this->_model) {
			return false;
		}
		return true;
	}

	public function cleanModels(callable $modelBuilder)
	{
		
	}
}