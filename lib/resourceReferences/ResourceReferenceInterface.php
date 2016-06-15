<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\resourceReferences;

interface ResourceReferenceInterface
{
	public function getObject();
	public function getObjectType();
	public function getResource();
}