<?php
namespace psesd\sensors;

use Yii;

class Extension implements \yii\base\BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        Yii::setAlias('@psesd/sensors', __DIR__);
    }
}