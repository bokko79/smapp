<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CsPropertiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Properties';
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= Html::encode($this->title) ?> <small>Properties</small></h2>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<p>
    <?= Html::a('Create New Property', ['create'], ['class' => 'btn btn-success']) ?>
</p>
<?php Pjax::begin(); ?>    
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        [
            'attribute'=>'name',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data->name, Url::to(['view', 'id' => $data->id]));
            },
        ],
        'type',
        [
            'attribute' => 'specific_values',
            'format' => 'raw',
            'value'=>function ($data) {
                return $data->specific_values==1 ? 'Yes' : 'No';
            },
        ], 

       [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return \Yii::$app->user->can('manageCoreDatabase') ? Html::a('Update', ['update', 'id' => $model->id], ['class' => '']) : '';
                },
            ],                        
        ],
    ],
]); ?>
<?php Pjax::end(); ?>
