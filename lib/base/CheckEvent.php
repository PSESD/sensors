<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */
namespace canis\sensors\base;

class CheckEvent extends \canis\messageStore\Simple
{
	public $sensorInstance;
	public $state = 'normal';
	public $verifyState = false;
	public $notify = false;
	public $pause = false;
	
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