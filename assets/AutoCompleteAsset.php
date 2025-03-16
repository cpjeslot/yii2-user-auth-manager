<?php

namespace app\assets;

use yii\web\AssetBundle;

class AutoCompleteAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-ui'; // Path to jQuery UI installed by Bower or NPM

    public $css = [
        'themes/base/jquery-ui.min.css', // jQuery UI CSS file
    ];

    public $js = [
        'jquery-ui.min.js', // jQuery UI JavaScript file
    ];

    public $depends = [
        'yii\web\JqueryAsset', // Ensure that jQuery is loaded first
    ];
}
