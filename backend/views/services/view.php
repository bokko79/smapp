<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model common\models\CsServices */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cs Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php if($model->quantities){
            echo Html::a('View Quantities', ['service-quantities/view', 'id' => $model->id], ['class' => 'btn btn-info']);
        } else {
            echo Html::a('Create Quantities', ['service-quantities/create', 'CcServiceQuantities[service_id]' => $model->id], ['class' => 'btn btn-default']);
        } ?>
    </p>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    [
                        'label'=>'Industry',
                        'format'=>'raw',
                        'value'=> Html::a($model->industry->name, ['industries/view', 'id' => $model->industry_id]),
                    ],
                    [
                        'label'=>'Action',
                        'format'=>'raw',
                        'value'=> Html::a($model->action->name, ['actions/view', 'id' => $model->action_id]),
                    ],
                    [
                        'label'=>'Object',
                        'format'=>'raw',
                        'value'=> Html::a($model->object->name, ['objects/view', 'id' => $model->object_id]),
                    ],
                    /*[
                        'label'=>'Units',
                        'format'=>'raw',
                        'value'=> Html::a($model->unit->sign, ['units/view', 'id' => $model->unit_id]),
                    ],*/
                    'unit.sign',
                    'file_id',                    
                    'serviceType',
                    'object_class',
                    'serviceObjectOwnership',
                    'serviceFile',
                    'serviceAmount',
                    'serviceConsumer',
                    'serviceConsumerChildren',
                    'serviceLocation',
                    'serviceCoverage',
                    'shipping',
                    'geospecific',
                    'serviceTime',
                    'serviceDuration',
                    'serviceFrequency',
                    'availability',
                    'installation',
                    'tools',
                    'turn_key',
                    'support',
                    'ordering',
                    'pricing',
                    'terms',
                    'labour_type',
                    'process',
                    'dat',
                    'status',
                    'hit_counter',
                ],
            ]) ?>
        </div>

        <div class="col-lg-8">
        <?= Html::a('Add new Service object property', ['service-object-properties/create', 'CcServiceObjectProperties[service_id]' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= GridView::widget([
                    'dataProvider' => $properties,
                    'columns' => [
                        'id',
                        [
                            'label'=>'Property',
                            'format' => 'raw',
                            'value'=>function ($data) {
                                return Html::a($data->objectProperty->property->name, ['service-object-properties/view', 'id' => $data->id]);
                            },
                        ],
                        [
                            'label'=>'Inheritance',
                            'format' => 'raw',
                            'value'=>function ($data) {
                                return Html::a($data->objectProperty->object->name, ['objects/view', 'id' => $data->objectProperty->object_id]);
                            },
                        ],
                        [
                            'label'=>'Unit',
                            'format' => 'raw',
                            'value'=>function ($data) {
                                return $data->unit ? Html::a($data->unit->name, ['units/view', 'id' => $data->id]) : null;
                            },
                        ],
                        [
                            'attribute' => 'property_type',
                            'format' => 'raw',
                            'value'=>function ($data) {
                                return ($data->property_type=='parts' or $data->property_type=='models' or $data->property_type=='object_models' or $data->property_type=='owner') ? Html::a($data->property_type, Url::to(), ['data-toggle'=>'modal', 'data-backdrop'=>false,  'data-target'=>'#service-object-property-values-modal'.$data->id]) : $data->property_type;
                            },
                        ],
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
                                    return \Yii::$app->user->can('manageCoreDatabase') ? Html::a('Update', ['/service-object-properties/update', 'id' => $model->id], ['class' => '']) : '';
                                },
                            ],                        
                        ],
                    ],
                ]); ?>
        <h2><?= $model->object->name ?></h2>
            <h3><?= $model->serviceObjectProperties ? 'service object models' : Html::a('Add Service object models property', ['service-object-properties/create', 'CcServiceObjectProperties[service_id]' => $model->id], ['class' => 'btn btn-info']) ?></h3>
            <?php 
                // all service object properties
                
                if($model->serviceObjectModels){
                    foreach ($model->serviceObjectModels as $objectModel){
                        echo '<h4><b>'.c($objectModel->name). '</b></h4><ul><b>models</b>';
                        // models modeling properties
                        if($model->getSOMModelProperties($objectModel)){
                            foreach($model->getSOMModelProperties($objectModel) as $SOMModelProperty){
                                echo '<li>'.$SOMModelProperty->property->name.'</li><ul>';
                                // model's models
                                if($SOMModelPropertyValues = $SOMModelProperty->objectPropertyValues){  
                                    foreach($SOMModelPropertyValues as $SOMModelPropertyValue){
                                        if($SOMModelPropertyValue->object){
                                            echo $SOMModelProperty->read_only ? '<li><i>'.$SOMModelPropertyValue->object->name.' (read only)</i></li>' : '<li>'.$SOMModelPropertyValue->object->name.'</li>';
                                        }
                                    }
                                }
                                echo '</ul>';
                            }
                        }
                        echo '</ul><ul><b>properties</b>';
                        // models properties
                        if($model->getSOMProperties($objectModel)){
                            foreach($model->getSOMProperties($objectModel) as $SOMModelProperty){
                                echo '<li>'.$SOMModelProperty->property->name;
                                echo ($SOMModelProperty->property_type=='numeric' and $SOMModelProperty->unit) ? ' ['.$SOMModelProperty->unit->sign.']' : null;
                                echo '</li><ul>';
                                // model's property
                                if($SOMModelPropertyValues = $SOMModelProperty->objectPropertyValues){  
                                    foreach($SOMModelPropertyValues as $SOMModelPropertyValue){
                                        if($SOMModelPropertyValue->object){
                                            echo '<li>'.$SOMModelPropertyValue->object->name.'</li>';
                                        }
                                    }
                                }
                                echo '</ul>';
                            }
                        }
                        echo '</ul><ul><b>parts</b>';
                        // models parts
                        if($model->getSOMParts($objectModel)){
                            foreach($model->getSOMParts($objectModel) as $SOMModelProperty){
                                echo '<li>'.$SOMModelProperty->property->name.'</li><ul>';
                                // model's property 
                                if($SOMModelPropertyValues = $SOMModelProperty->objectPropertyValues){  
                                    foreach($SOMModelPropertyValues as $SOMModelPropertyValue){
                                        if($SOMModelPropertyValue->object){
                                            echo '<li>';
                                            if($SOMModelPropertyValue->value_type=='integral_part'){
                                                echo $SOMModelProperty->read_only ? '<i>'.$SOMModelPropertyValue->object->name.' (read only)(integral part)</i>' : $SOMModelPropertyValue->object->name.' (integral part)';
                                            } else {
                                                echo $SOMModelPropertyValue->object->name.' (yes/no)';
                                            }
                                            if($SOMModelPropertyValue->countable_value==2){
                                                echo 'number of '. $SOMModelPropertyValue->object->name;
                                            }
                                            echo '</li><ul><b>models</b>';/*
                                            // models modeling properties
                                            if($model->getSOMModelProperties($SOMModelPropertyValue->object)){
                                                foreach($model->getSOMModelProperties($SOMModelPropertyValue->object) as $SOMModelProperty){
                                                    echo '<li>'.$SOMModelProperty->property->name.'</li><ul>';
                                                    // model's models
                                                    if($SOMModelPropertyValues = $SOMModelProperty->objectPropertyValues){  
                                                        foreach($SOMModelPropertyValues as $SOMModelPropertyValue){
                                                            if($SOMModelPropertyValue->object){
                                                                echo $SOMModelProperty->read_only ? '<li><i>'.$SOMModelPropertyValue->object->name.' (read only)</i></li>' : '<li>'.$SOMModelPropertyValue->object->name.'</li>';
                                                            }
                                                        }
                                                    }                                                    
                                                    echo '</ul>';
                                                }
                                            }
                                            */
                                            echo '</ul><ul><b>properties</b>';/*
                                            // models properties
                                            if($model->getSOMProperties($SOMModelPropertyValue->object)){
                                                foreach($model->getSOMProperties($SOMModelPropertyValue->object) as $SOMModelProperty){
                                                    echo '<li>'.$SOMModelProperty->property->name;
                                                    echo ($SOMModelProperty->property_type=='numeric' and $SOMModelProperty->unit) ? ' ['.$SOMModelProperty->unit->sign.']' : null;
                                                    echo '</li><ul>';
                                                    // model's property
                                                    if($SOMModelPropertyValues = $SOMModelProperty->objectPropertyValues){  
                                                        foreach($SOMModelPropertyValues as $SOMModelPropertyValue){
                                                            if($SOMModelPropertyValue->object){
                                                                echo '<li>'.$SOMModelPropertyValue->object->name.'</li>';
                                                            }
                                                        }
                                                    }
                                                    echo '</ul>';
                                                }
                                            } */
                                            echo '</ul>';
                                        }
                                    }
                                }
                                echo '</ul>';
                            }
                        } 
                        echo '</ul><ul><b>containers</b>';
                        // model containers
                        if($objectModel->containers){
                            foreach($objectModel->containers as $container){
                                echo '<li>'.$container->name;
                                echo '</li>';
                            }
                        }
                        echo '</ul>';
                    }
                } ?>
        </div>
    </div>
</div>

<?php 
    if($oproperties = $model->serviceObjectProperties){
        foreach($oproperties as $oproperty){
            if($oproperty->property_type=='parts' or $oproperty->property_type=='models' or $oproperty->property_type=='object_models' or $oproperty->property_type=='owner'){
                Modal::begin([
                'id'=>'service-object-property-values-modal'.$oproperty->id,
                'size'=>Modal::SIZE_SMALL,
                'class'=>'overlay_modal',
                'header'=> 'Property values '.Html::a($oproperty->objectProperty->property->name, Url::to(['/service-object-property-values/index', 'CcServiceObjectPropertyValuesSearch[service_object_property_id]'=>$oproperty->id])),
            ]); ?>
                <div id="loading"><i class="fa fa-cog fa-spin fa-3x gray-color"></i></div>
            <?php Modal::end();
            }             
        }
    } ?>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'><div id='loading'><i class='fa fa-cog fa-spin fa-3x gray-color'></i></div></div>";
yii\bootstrap\Modal::end();
?>