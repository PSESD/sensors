<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\local;

use Yii;
use canis\sensors\base\CheckEvent;
use canis\sensors\base\SensorDataInterface;

class DynamicData
	extends Dynamic
	implements SensorDataInterface
{
	public $dataValuePrefix;
	public $dataValuePostfix;

	public function simpleProperties()
    {
    	$properties = parent::simpleProperties();
    	$properties['dataValuePrefix'] = $this->dataValuePrefix;
    	$properties['dataValuePostfix'] = $this->dataValuePostfix;
    	return $properties;
    }

	public function getDataValue()
	{
		if (isset($this->payload['dataValue'])) {
			return $this->payload['dataValue'];
		}
		return null;
	}

	public function formatDataPoint($dataValue)
	{
		if ($dataValue === null) {
			return;
		}
		return $this->dataValuePrefix . $dataValue . $this->dataValuePostfix;
	}

	public function getDataValueFormatted()
	{
		return $this->formatDataPoint($this->dataValue);
	}

}