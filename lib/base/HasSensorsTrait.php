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

    protected function getDefaultSensors()
    {
        $sensors = [];
        foreach (static::defaultSensors() as $sensorConfig) {
            if (($sensor = static::loadObject($sensorConfig, SensorInterface::class))) {
                $sensor->parentObject = $this;
                $sensors[] = $sensor;
            }
        }
        return $sensors;
    }


	public function getSensors()
	{
		$sensors = array_merge($this->getDefaultSensors(), $this->_sensors);
		foreach ($sensors as $k => $sensor) {
			if ($sensor === false) {
				unset($sensors[$k]);
			}
		}
		return $sensors;
	}
}