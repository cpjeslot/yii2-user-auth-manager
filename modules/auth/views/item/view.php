<?php

use app\modules\auth\AnimateAsset;
use app\modules\auth\components\ItemController;
use app\modules\auth\models\AuthItem;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model AuthItem */
/* @var $context ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('auth', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
$opts = Json::htmlEncode([
        'items' => $model->getItems(),
        'users' => $model->getUsers(),
        'getUserUrl' => Url::to(['get-users', 'id' => $model->name])
    ]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';
?>
<div class="auth-item-view">
    <h1><?= Html::encode($this->title); ?></h1>
    <p>
        <?= Html::a(Yii::t('auth', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']); ?>
        <?=
        Html::a(Yii::t('auth', 'Delete'), ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data-confirm' => Yii::t('auth', 'Are you sure to delete this item?'),
            'data-method' => 'post',
        ]);
        ?>
        <?= Html::a(Yii::t('auth', 'Create'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>
    <div class="row">
        <div class="col-sm-11">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'description:ntext',
                    'ruleName',
                    'data:ntext',
                ],
                'template' => '<tr><th style="width:25%">{label}</th><td>{value}</td></tr>',
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-11">
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th><?= Yii::t('auth', 'Assigned users'); ?></th>
                    </tr>
                    <tr>
                        <td id="list-users"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <input class="form-control search" data-target="available"
                   placeholder="<?= Yii::t('auth', 'Search for available'); ?>">
            <select multiple size="20" class="form-control list" data-target="available"></select>
        </div>
        <div class="col-sm-1">
            <br><br>
            <?=
            Html::a('&gt;&gt;' . $animateIcon, ['assign', 'id' => $model->name], [
                'class' => 'btn btn-success btn-assign',
                'data-target' => 'available',
                'title' => Yii::t('auth', 'Assign'),
            ]);
            ?><br><br>
            <?=
            Html::a('&lt;&lt;' . $animateIcon, ['remove', 'id' => $model->name], [
                'class' => 'btn btn-danger btn-assign',
                'data-target' => 'assigned',
                'title' => Yii::t('auth', 'Remove'),
            ]);
            ?>
        </div>
        <div class="col-sm-5">
            <input class="form-control search" data-target="assigned"
                   placeholder="<?= Yii::t('auth', 'Search for assigned'); ?>">
            <select multiple size="20" class="form-control list" data-target="assigned"></select>
        </div>
    </div>
</div>
