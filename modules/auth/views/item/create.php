<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\auth\models\AuthItem */
/* @var $context app\modules\auth\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = Yii::t('auth', 'Create ' . $labels['Item']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('auth', $labels['Items']), 'url' => ['index']];
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
