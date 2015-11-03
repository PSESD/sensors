<?php
/**
 * @link http://canis.io
 *
 * @copyright Copyright (c) 2015 Canis
 * @license http://canis.io/license/
 */
namespace canis\sensors\base;

class CheckEvent extends \yii\base\Event
{
	public $sensorInstance;
	public $state = 'normal';
	public $verifyState = false;
	public $notify = false;
	public $pause = false;
	protected $_messages = [];

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

	public function getMessageType($type)
	{
		$messages = [];
		foreach ($this->_messages as $message) {
			if ($message['type'] === $type) {
				$messages[] = $message['message'];
			}
		}
		return $messages;
	}

	public function getErrors()
	{
		return $this->getMessageType('error');
	}

	public function getWarnings()
	{
		return $this->getMessageType('warning');
	}

	public function getInfo()
	{
		return $this->getMessageType('info');
	}

	protected function addMessage($type, $message)
	{
		$this->_messages[] = ['time' => microtime(), 'type' => $type, 'message' => $message];
		return true;
	}  
	public function addError($message)
	{
		return $this->addMessage('error', $message);
	}  

	public function addInfo($message)
	{
		return $this->addMessage('info', $message);
	}

	public function addWarning($message)
	{
		return $this->addMessage('warning', $message);
	}  
}