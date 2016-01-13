<?php
/**
 * @link https://www.psesd.org
 *
 * @copyright Copyright (c) 2016 Puget Sound ESD
 * @license https://raw.githubusercontent.com/PSESD/sensor/master/LICENSE/
 */

namespace psesd\sensors\remote;

use Yii;
use psesd\sensors\base\CheckEvent;
use linslin\yii2\curl;

class HttpTest extends \psesd\sensors\remote\Sensor
{
	public function name()
	{
		return 'HTTP Test';
	}

	public function getId()
	{
		return 'simple-http-test';
	}

	public function getDefaultCheckRetries()
	{
		return 3;
	}

	protected function testUrl($url, $maxRedirects)
	{
		$curlOptions = [
			CURLOPT_USERAGENT      => 'Canis Site Monitor',
	        CURLOPT_TIMEOUT        => $this->getTimeout(),
	        CURLOPT_CONNECTTIMEOUT => $this->getTimeout(),
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_HEADER         => false,
	        CURLOPT_FOLLOWLOCATION => true,
	        CURLOPT_MAXREDIRS	   => $maxRedirects
        ];
        $headers = [];
		$ch = curl_init($url);
		curl_setopt_array($ch, $curlOptions);

		$response = curl_exec($ch);

		if ($response === false) {
			switch (curl_errno($ch)) {
                case 7:
                	return ['response' => false, 'responseCode' => 'timeout'];
                break;
            }
		}

		$responseCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return ['response' => $response, 'responseCode' => $responseCode];
	}

	protected function doCheck(CheckEvent $event)
	{
		if (empty($event->sensorInstance->objectModel)) {
			$event->state = static::STATE_CHECK_FAIL;
			return;
		}
		$objectModel = $event->sensorInstance->objectModel;
		$url = $objectModel->dataObject->object->getTestUrl();
		if (!$url || !class_exists('linslin\yii2\curl\Curl')) {
			$event->state = static::STATE_UNCHECKED;
			return;
		}
		$redirects = 10;
		$result = $this->testUrl($url, $redirects);
		$response = $result['response'];
		$responseCode = $result['responseCode'];
        
        if (!$response || $responseCode !== 200) {
        	$event->state = static::STATE_ERROR;
        	$event->verifyState = true;
        	$event->addError("The url '{$url}' returned a response code of {$responseCode}");
        } else {
        	$lookFor = $objectModel->dataObject->object->getTestLookFor();
        	if (!$lookFor || strpos($response, $lookFor) !== false) {
        		$event->state = static::STATE_NORMAL;
        	} else {
        		$event->verifyState = true;
	        	$event->state = static::STATE_ERROR;
	        	$event->addError("The url '{$url}' did not contain the look for text");
        	}
        }

	}

	public function getTimeout()
	{
		return 30;
	}

	public function getCheckInterval($sensorInstance)
	{
		return '+1 minute';
	}
}