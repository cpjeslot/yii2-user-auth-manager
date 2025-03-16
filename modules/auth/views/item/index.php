<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\auth\components\RouteRule;
use app\modules\auth\components\Configs;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\modules\auth\models\search\AuthItem */
/* @var $context app\modules\auth\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = Yii::t('auth', $labels['Items']);
$this->params['breadcrumbs'][] = $this->title;

$rules = array_keys(Configs::authManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);
?>
<div class="role-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('auth', 'Create ' . $labels['Item']), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => Yii::t('auth', 'Name'),
            ],
            [
                'attribute' => 'ruleName',
                'label' => Yii::t('auth', 'Rule Name'),
                'filter' => $rules
            ],
            [
                'attribute' => 'description',
                'label' => Yii::t('auth', 'Description'),
            ],
            ['class' => 'yii\grid\ActionColumn',],
        ],
    ])
    ?>

</div>
