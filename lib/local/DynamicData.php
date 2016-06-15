<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\local;

use Yii;
use psesd\sensors\base\CheckEvent;
use psesd\sensors\base\SensorDataInterface;

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