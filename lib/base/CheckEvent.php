<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */
namespace psesd\sensors\base;

class CheckEvent extends \canis\messageStore\Simple
{
	public $sensorInstance;
	public $state = 'normal';
	public $verifyState = false;
	public $notify = false;
	public $pause = false;
    public $dataValue;
	
	public function __sleep()
    {
        $keys = array_keys((array) $this);
        $bad = ["\0*\0_cache", "sensorInstance"];
        foreach ($keys as $k => $key) {
            if (in_array($key, $bad)) {
                unset($keys[$k]);
            }
        }

        return $keys;
    }
}