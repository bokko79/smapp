<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Provider Properties';
$this->params['breadcrumbs'][] = $this->title;
?>
<h2><?= Html::encode($this->title) ?> <small>Svojstva delatnosti</small></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create New Provider Property', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Providers'), ['/providers/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Yii::t('app', 'Properties'), ['/properties/index'], ['class' => 'btn btn-danger']) ?>
    </p>
<?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'provider_id',
            'provider.name',
            'property_id',
            'property.name',
            //'value_default',
            //'value_min',
            //'value_max',
            //'step',
            //'display_order',
            //'multiple_values',
            //'read_only',
            //'required',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
