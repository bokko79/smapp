<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

$this->title = $model->property->name . '  ' . $model->object->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Object Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-<?= ($model->property_type=='parts' or $model->property_type=='models' or $model->property_type=='owner' or $model->property_type=='values' or $model->property_type=='issues') ? 4 : 12 ?>">
            <div class="card_container record-full grid-item fadeInUp animated" id="card_container" style="float:none;">
                <div class="primary-context gray">

                    <h2><?= c(Html::encode($this->title)) ?> <small>id: <?= $model->id ?> required: <?= $model->required==1 ? 'yes' : 'no' ?></small></h2>

                    <p>
                        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?= Html::a('Property Values', Url::to('#property-values'), ['class' => 'btn btn-link']) ?>
                    </p>
                </div>


                    
                 <div class="secondary-context">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'label' => 'Object',
                                'format' => 'raw',
                                'value'=> $model->object ? Html::a($model->object->name, Url::to(['/objects/view', 'id'=>$model->object_id]), []) : null,
                            ],
                            [
                                'label' => 'Property',
                                'format' => 'raw',
                                'value'=> $model->property ? Html::a($model->property->name, Url::to(['/properties/view', 'id'=>$model->property_id]), []) : null,
                            ],
                            [
                                'label' => 'Unit',
                                'format' => 'raw',
                                'value'=> $model->unit ? Html::a($model->unit->name, Url::to(['/units/view', 'id'=>$model->unit_id]), []) : null,
                            ],
                            [
                                'label' => 'Unit Imperial',
                                'format' => 'raw',
                                'value'=> $model->unitImperial ? Html::a($model->unitImperial->name, Url::to(['/units/view', 'id'=>$model->unit_imperial_id]), []) : null,
                            ],
                            'property_class',
                            'property_type',
                            'input_type',
                            'value_default',
                            'value_min',
                            'value_max',
                            'step',
                            'pattern',
                            'display_order',
                            [
                                'label' => 'Multiple Values',
                                'value'=> $model->multiple_values==1 ? 'Yes' : 'No',
                            ],
                            [
                                'label' => 'Specific Values',
                                'value'=> $model->specific_values==1 ? 'Yes' : 'No',
                            ],
                            [
                                'label' => 'Read Only',
                                'value'=> $model->read_only==1 ? 'Yes' : 'No',
                            ],
                            [
                                'label' => 'Required object property',
                                'value'=> $model->required==1 ? 'Yes' : 'No',
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <?php if($model->property_type=='parts' or $model->property_type=='models' or $model->property_type=='owner' or $model->property_type=='values' or $model->property_type=='issues'): ?>
        <div class="col-sm-8">        
            <div class="card_container record-full grid-item fadeInUp animated" id="property-values">
                <div class="primary-context gray normal">
                    <div class="head"><?= ($model->objectPropertyValues) ? Html::a('Object Property Values', Url::to(['/object-property-values/index', 'CcObjectPropertyValuesSearch[object_property_id]'=>$model->id]), []) : 'Object Property Values' ?></div>
                    <div class="subhead"><?= Html::a('New Object Property Value', ['/object-property-values/create', 'CcObjectPropertyValues[object_property_id]' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?></div>
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
                                    return Html::a($data->id, ['object-property-values/view', 'id' => $data->id]);
                                },
                            ],
                            [
                                'label'=>'Object',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return Html::a($data->objectProperty->object->name, ['object-properties/view', 'id' => $data->object_property_id]);
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
                            'value_type',
                            'value_class',
                            [
                                'attribute' => 'countable_value',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return ($data->countable_value==1 or $data->countable_value==2) ? ($data->countable_value==1 ? 'Single' : 'Multiple') : 'No';
                                },
                            ],
                            'default_part_no',
                            [
                                'attribute' => 'selected_value',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return $data->selected_value==1 ? 'Yes' : 'No';
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
                    <?php
                        echo '<h3>Disabled values</h3>';
                        if($objectPropertyValues = $model->objectPropertyValues){
                            foreach($objectPropertyValues as $objectPropertyValue){
                                if($objectPropertyValue->value_class=='disabled'){
                                    echo Html::a('id='.$objectPropertyValue->id.': '.$objectPropertyValue->object->name, ['/object-property-values/update', 'id' => $objectPropertyValue->id], ['class' => '', 'target' => 'blank']).'<br>';                                    
                                }
                            }
                        }
                    ?>
                </div>
            </div>        
        </div>      
        <?php endif; ?>      
    </div>
</div>
