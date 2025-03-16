<?php

namespace app\modules\auth\controllers;

use Yii;

/**
 *
 * @author Chetan Jeslot <cpjeslot@gmail.com>
 * @since 1.0.0
 * 
 */
class DefaultController extends \yii\web\Controller
{

    /**
     * Action index
     */
    public function actionIndex($page = 'README.md')
    {
        if (preg_match('/^docs\/images\/image\d+\.png$/',$page)) {
            $file = Yii::getAlias("@app/modules/auth/{$page}");
            return Yii::$app->response->sendFile($file);
        }
        return $this->render('index', ['page' => $page]);
    }
}
