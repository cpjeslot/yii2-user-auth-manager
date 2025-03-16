<?php

namespace app\assets\sweetalert;

class SweetAlert2Asset extends BaseAsset
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = '@npm/sweetalert2/dist';
        $min = $this->min();
        $this->js[] = 'sweetalert2' . $min . '.js';
        $this->css[] = 'sweetalert2' . $min . '.css';
        parent::init();
    }
}
