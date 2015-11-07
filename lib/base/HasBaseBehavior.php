<?php
namespace canis\sensors\base;

abstract class HasBaseBehavior extends \yii\base\Behavior
{
	abstract protected function getObjects();
	abstract protected function getObjectType();

	public static function loadObject($config, $interfaceName)
    {
    	return BaseObject::loadObject($config, $interfaceName);
    }
}