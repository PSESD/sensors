<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\base;

interface BaseInterface
{
	public function getId();
	public function getMeta();
	// public function loadModels(callable $modelBuilder);
	// public function cleanModels(callable $modelBuilder);

}