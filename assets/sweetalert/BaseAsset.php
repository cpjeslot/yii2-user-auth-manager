<?php

namespace app\assets\sweetalert;

use yii\web\AssetBundle;

class BaseAsset extends AssetBundle
{
    /**
     * @return string
     */
    public function min()
    {
        return YII_ENV_DEV ? '' : '.min';
    }
}
