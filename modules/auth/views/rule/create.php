<?php

use yii\helpers\Html;

/* @var $this  yii\web\View */
/* @var $model app\modules\auth\models\BizRule */

$this->title = Yii::t('auth', 'Create Rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('auth', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>
