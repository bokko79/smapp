<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\CcProviders */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Providers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= c(Html::encode($this->title)) ?> <small>status: <?= $model->status ?></small></h2>

<p>
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
</p>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'type',
                    'file_id',
                    'status',
                ],
            ]) ?>
            <?= Html::a('New Provider Industry', ['/industry-providers/create', 'CcIndustryProviders[provider_id]' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?>
            <?= GridView::widget([
                'dataProvider' => $industries,
                'columns' => [
                    'id',
                    [
                        'label'=>'Industry',
                        'format' => 'raw',
                        'value'=>function ($data) {
                            return Html::a($data->industry->name, ['industries/view', 'id' => $data->id]);
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return \Yii::$app->user->can('manageCoreDatabase') ? Html::a('Update', ['/industry-providers/update', 'id' => $model->id], ['class' => '']) : '';
                            },
                        ],                        
                    ],
                ],
            ]); ?>
        </div>
        <div class="col-lg-8">            

            <?= Html::a('New Property', ['/provider-properties/create', 'CcProviderProperties[provider_id]' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?>
            <?= GridView::widget([
                'dataProvider' => $properties,
                'columns' => [
                    'id',
                    [
                        'label'=>'Property',
                        'format' => 'raw',
                        'value'=>function ($data) {
                            return Html::a($data->property->name, ['provider-properties/view', 'id' => $data->id]);
                        },
                    ],
                    [
                        'label'=>'Inheritance',
                        'format' => 'raw',
                        'value'=>function ($data) {
                            return Html::a($data->provider->name, ['providers/view', 'id' => $data->provider_id]);
                        },
                    ],
                    //'property_class',
                    'value_default',
                    // 'value_min',
                    // 'value_max',
                    // 'step',
                    // 'pattern',
                    [
                        'attribute' => 'multiple_values',
                        'format' => 'raw',
                        'value'=>function ($data) {
                            return $data->multiple_values==1 ? 'Yes' : 'No';
                        },
                    ],
                    [
                        'attribute' => 'specific_values',
                        'format' => 'raw',
                        'value'=>function ($data) {
                            return $data->specific_values==1 ? 'Yes' : 'No';
                        },
                    ],
                    // 'read_only',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return \Yii::$app->user->can('manageCoreDatabase') ? Html::a('Update', ['/provider-properties/update', 'id' => $model->id], ['class' => '']) : '';
                            },
                        ],                        
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

