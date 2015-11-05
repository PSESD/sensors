<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\base;

interface BaseInterface
{
	public function getId();
	public function getMeta();
	// public function loadModels(callable $modelBuilder);
	// public function cleanModels(callable $modelBuilder);

}