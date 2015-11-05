<?php
namespace canis\sensors;

use Yii;

class Extension implements \yii\base\BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        Yii::setAlias('@canis/sensors', __DIR__);
    }
}