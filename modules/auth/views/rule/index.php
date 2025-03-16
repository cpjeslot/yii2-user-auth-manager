<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this  yii\web\View */
/* @var $model app\modules\auth\models\BizRule */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\modules\auth\models\search\BizRule */

$this->title = Yii::t('auth', 'Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('auth', 'Create Rule'), ['create'], ['class' => 'btn btn-success']) ?>
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
            ['class' => 'yii\grid\ActionColumn',],
        ],
    ]);
    ?>

</div>
