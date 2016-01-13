<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\sites;

class Forwarder extends Base
{
	public $from;
	public $to;
	
	public function getObjectTypeDescriptor()
    {
        return 'Forwarding Site';
    }

	public function simpleProperties()
    {
        return array_merge(parent::simpleProperties(), [
            'from' => $this->from,
            'to' => $this->to
        ]);
    }
}