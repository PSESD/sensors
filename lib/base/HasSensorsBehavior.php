<?php
namespace psesd\sensors\base;

class HasSensorsBehavior extends HasBaseBehavior
{
	protected $_sensors = [];
	
	protected function getObjects()
	{
		return $this->getSensors();
	}

	protected function getObjectType()
	{
		return 'sensor';
	}

	public function setSensors($sensors)
	{
		$this->_sensors = [];
		foreach ($sensors as $sensorConfig) {
			if (($sensor = static::loadObject($sensorConfig, SensorInterface::class))) {
				$sensor->parentObject = $this->owner;
				$this->_sensors[] = $sensor;
			} else {
				if (!isset($this->owner->invalidEntries['sensors'])) {
					$this->owner->invalidEntries['sensors'] = [];
				}
				$this->owner->invalidEntries['sensors'][] = $sensorConfig;
			}
		}
		return $this;
	}

    protected function getDefaultSensors()
    {
        $sensors = [];
        foreach ($this->owner->defaultSensors() as $sensorConfig) {
            if (($sensor = static::loadObject($sensorConfig, SensorInterface::class))) {
                $sensor->parentObject = $this->owner;
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