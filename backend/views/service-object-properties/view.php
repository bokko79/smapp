<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\CsServiceObjectProperties */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cs Service Object Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= Html::encode($this->title) ?></h2>

<p>
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>
</p>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-<?= ($model->property_type=='parts' or $model->property_type=='models' or $model->property_type=='object_models') ? 4 : 12 ?>">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                        [
                            'label'=>'Service',
                            'format'=>'raw',
                            'value'=> Html::a($model->service->name, ['services/view', 'id' => $model->service_id]),
                        ],
                        [
                            'label'=>'ObjectProperty',
                            'format'=>'raw',
                            'value'=> Html::a($model->objectProperty->property->name .' '.$model->objectProperty->object->name, ['object-properties/view', 'id' => $model->object_property_id]),
                        ],
                        'property_type',
                        'input_type',
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
        <?php if($model->property_type=='parts' or $model->property_type=='models' or $model->property_type=='object_models'): ?>
        <div class="col-sm-8">
            <?= ($model->serviceObjectPropertyValues) ? Html::a('Service Object Property Values', Url::to(['/service-object-property-values/index', 'CcServiceObjectPropertyValuesSearch[service_object_property_id]'=>$model->id]), []) : 'Service Object Property Values' ?>
            <div class="subhead"><?= Html::a('New Service Object Property Value', ['/service-object-property-values/create', 'CcServiceObjectPropertyValues[service_object_property_id]' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?></div>        
            <?= GridView::widget([
                'dataProvider' => $propertyValues,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],

                    [
                        'label'=>'ID',
                        'format' => 'raw',
                        'value'=>function ($data) {
                            return Html::a($data->id, ['object-property-values/view', 'id' => $data->id]);
                        },
                    ],
                    [
                        'label'=>'Object',
                        'format' => 'raw',
                        'value'=>function ($data) {
                            return Html::a($data->serviceObjectProperty->objectProperty->object->name, ['object-properties/view', 'id' => $data->serviceObjectProperty->object_property_id]);
                        },
                    ],
                    [
                        'label'=>'Property Value',
                        'format' => 'raw',
                        'value'=>function ($data) {
                            return $data->objectPropertyValue->propertyValue ? Html::a($data->objectPropertyValue->propertyValue->value, ['property-values/view', 'id' => $data->objectPropertyValue->property_value_id]) : null;
                        },
                    ],
                    [
                        'label'=>'Value:Object',
                        'format' => 'raw',
                        'value'=>function ($data) {
                            return $data->objectPropertyValue->object ? Html::a($data->objectPropertyValue->object->name, ['objects/view', 'id' => $data->objectPropertyValue->object_id]) : null;
                        },
                    ],
                    [
                        'label'=>'Value:File',
                        'format' => 'raw',
                        'value'=>function ($data) {
                            return $data->objectPropertyValue->file ? Html::a($data->objectPropertyValue->file->name, ['files/view', 'id' => $data->objectPropertyValue->file_id]) : null;
                        },
                    ],
                    [
                        'attribute' => 'selected_value',
                        'format' => 'raw',
                        'value'=>function ($data) {
                            return $data->objectPropertyValue->selected_value==1 ? 'Yes' : 'No';
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return \Yii::$app->user->can('manageCoreDatabase') ? Html::a('Upd', ['/object-property-values/update', 'id' => $model->id], ['class' => '', 'target' => 'blank']) : '';
                            },
                            'delete' => function ($url, $model, $key) {
                                return \Yii::$app->user->can('manageCoreDatabase') ? Html::a('Del', ['/object-property-values/delete', 'id' => $model->id], ['data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],]) : '';
                            },
                        ],                        
                    ],
                ],
            ]); ?>
        </div>
        <?php endif; ?>
    </div>
</div>
