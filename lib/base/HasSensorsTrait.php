<?php
namespace canis\sensors\base;

trait HasSensorsTrait
{
	protected $_sensors = [];
	
	public function setSensors($sensors)
	{
		$this->_sensors = [];
		foreach ($sensors as $sensorConfig) {
			if (($sensor = static::loadObject($sensorConfig, SensorInterface::class))) {
				$sensor->parentObject = $this;
				$this->_sensors[] = $sensor;
			} else {
				if (!isset($this->invalidEntries['sensors'])) {
					$this->invalidEntries['sensors'] = [];
				}
				$this->invalidEntries['sensors'][] = $sensorConfig;
			}
		}
		return $this;
	}

	public function getSensors()
	{
		return $this->_sensors;
	}
}