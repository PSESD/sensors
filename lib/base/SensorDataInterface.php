<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\base;

interface SensorDataInterface
{
	public function getDataValue();
	public function getDataValueFormatted();
}