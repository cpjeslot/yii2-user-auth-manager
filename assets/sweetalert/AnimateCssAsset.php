<?php

namespace app\assets\sweetalert;

class AnimateCssAsset extends BaseAsset
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = '@npm/animate.css';
        $this->css[] = 'animate' . $this->min() . '.css';
        parent::init();
    }

     /**
     * @return string
     */
    public function min()
    {
        return YII_ENV_DEV ? '' : '.min';
    }
}
