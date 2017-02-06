<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\CsMethods */

$this->title = $model->property->name . ' ' . $model->action->name;
$this->params['breadcrumbs'][] = ['label' => 'Action Property', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= Html::encode($this->title) ?></h2>

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
        <div class="col-sm-4">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'label' => 'Action',
                        'format' => 'raw',
                        'value'=> $model->action ? Html::a($model->action->name, Url::to(['/actions/view', 'id'=>$model->action_id]), []) : null,
                    ],
                    [
                        'label' => 'Property',
                        'format' => 'raw',
                        'value'=> $model->property ? Html::a($model->property->name, Url::to(['/properties/view', 'id'=>$model->property_id]), []) : null,
                    ],
                    'value_default',
                    'value_min',
                    'value_max',
                    'step',
                    'pattern',
                    'display_order',
                    'multiple_values',
                    'specific_values',
                    'read_only',
                    'required',
                ],
            ]) ?>
        </div>

        <div class="col-sm-8">
            <div class="card_container record-full grid-item fadeInUp animated" id="property-values">
                <div class="primary-context gray normal">
                    <div class="head"><?= ($model->actionPropertyValues) ? Html::a('Action Property Values', Url::to(['/action-property-values/index', 'CcActionPropertyValuesSearch[action_property_id]'=>$model->id]), []) : 'Action Property Values' ?></div>
                    <div class="subhead"><?= Html::a('New Action Property Value', ['/action-property-values/create', 'CcActionPropertyValues[action_property_id]' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?></div>
                </div>
                <div class="secondary-context">
                    <?= GridView::widget([
                        'dataProvider' => $propertyValues,
                        'columns' => [
                            //['class' => 'yii\grid\SerialColumn'],

                            [
                                'label'=>'ID',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return Html::a($data->id, ['action-property-values/view', 'id' => $data->id]);
                                },
                            ],
                            [
                                'label'=>'Action',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return Html::a($data->actionProperty->action->name, ['action-properties/view', 'id' => $data->action_property_id]);
                                },
                            ],
                            [
                                'label'=>'Property Value',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return $data->propertyValue ? Html::a($data->propertyValue->value, ['property-values/view', 'id' => $data->property_value_id]) : null;
                                },
                            ],
                            [
                                'label'=>'Value:Object',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return $data->object ? Html::a($data->object->name, ['objects/view', 'id' => $data->object_id]) : null;
                                },
                            ],
                            [
                                'attribute' => 'selected_value',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return $data->selected_value==1 ? 'Yes' : 'No';
                                },
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',                  
                            ],
                        ],
                    ]); ?>
                </div>
            </div> 
        </div>
    </div>
</div>
