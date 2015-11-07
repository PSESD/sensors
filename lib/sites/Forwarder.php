<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */

namespace canis\sensors\sites;

class Forwarder extends Base
{
	public $from;
	public $to;
	public function simpleProperties()
    {
        return array_merge(parent::simpleProperties(), [
            'from' => $this->from,
            'to' => $this->to
        ]);
    }
}