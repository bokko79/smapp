<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */
/* @var $model common\models\CcObjects */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card_container record-full grid-item fadeInUp animated" id="card_container" style="float:none;">
                <div class="primary-context gray">
                    <h2><?= c(Html::encode($this->title)) ?> <small>class: <?= $model->class ?></small></h2>

                    <p>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?= Html::a('Add New Child', Url::to(['/objects/create', 'CcObjects[object_id]'=>$model->id]), ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Services', Url::to('#services'), ['class' => 'btn btn-link']) ?>
                    </p>
                </div>
                <table class="main-context"> 
                    <tr>
                        <td class="body-area">
                            <div class="primary-context">
                                <div class="head">Karakteristike</div>                                
                            </div>
                            <div class="secondary-context cont">
                                <table class="table table-striped">                                
                                    <tr><td>Path</td>
                                        <td>
                                            <?php foreach ($model->getPath($model) as $path){
                                                echo Html::a(c($path->name), ['view', 'id'=>$path->id]) . ' / ';
                                            } ?> <?= c($model->name) ?>
                                        </td>
                                    </tr>
                                    <tr><td>Class</td>
                                        <td><?= $model->class ?></td>
                                    </tr>
                                    <tr><td>Level</td>
                                        <td><?= $model->level ?></td>
                                    </tr>
                                    <tr><td>Parent</td>
                                        <td><h4><b>
                                            <?= $model->parent ? Html::a(c($model->parent->name), ['view', 'id'=>$model->parent->id]) : null ?></b></h4>
                                        </td>
                                    </tr>
                                    <tr><td>Children</td>
                                        <td>
                                            <?php
                                                foreach ($model->children as $key => $child){
                                                    echo Html::a(c($child->name), ['view', 'id'=>$child->id]) . ($key==count($model->children)-1 ? null : ' <br> ');
                                                } ?>
                                        </td>
                                    </tr>
                                    <tr><td>Molds</td>
                                        <td>
                                            <?php
                                                foreach ($model->molds as $key => $mold){
                                                    echo Html::a(c($mold->name), ['view', 'id'=>$mold->id]) . ($key==count($model->molds)-1 ? null : ' <br> ');
                                                } ?>
                                        </td>
                                    </tr>
                                    <tr><td>Models</td>
                                        <td>
                                            <?php
                                                foreach ($model->models as $key => $mod){
                                                    echo Html::a(c($mod->name), ['view', 'id'=>$mod->id]) . ($key==count($model->models)-1 ? null : ' <br> ');
                                                } ?>
                                        </td>
                                    </tr>
                                    <tr><td>Parts</td>
                                        <td>
                                            <?php
                                                foreach ($model->parts as $key => $part){
                                                    echo Html::a(c($part->name), ['view', 'id'=>$part->id]) . ($key==count($model->parts)-1 ? null : ' <br> ');
                                                } ?>
                                        </td>
                                    </tr>
                                    <tr><td>Containers</td>
                                        <td>
                                            <?php
                                                foreach ($model->objectContainers as $key => $container){
                                                    echo Html::a(c($container->name), ['view', 'id'=>$container->id]) . ($key==count($model->objectContainers)-1 ? null : ' <br> ');
                                                } ?>
                                        </td>
                                    </tr>
                                    <tr><td>Siblings</td>
                                        <td>
                                            <?php
                                                if($model->parent){
                                                    foreach ($model->siblings as $key => $sibling){
                                                        echo Html::a(c($sibling->name), ['view', 'id'=>$sibling->id]) . ($key==count($model->siblings)-1 ? null : ' <br> ');
                                                    }
                                                } ?>
                                        </td>
                                    </tr>                                    
                                    <tr><td>Favourable</td>
                                        <td><?= $model->favour==1 ? 'Yes' : 'No' ?></td>
                                    </tr>
                                    <tr><td>Hint</td>
                                        <td><?= $model->hint ?></td>
                                    </tr>
                                    <tr><td>Description</td>
                                        <td><?= $model->description ?></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        <td class="media-area 200">
                            <div >                
                                <div class="image">
                                    <?php /* Html::img('/images/objects/'.$model->file->ime) */ ?>
                                </div>
                            </div> 
                        </td>
                    </tr>                        
                </table>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card_container record-full grid-item fadeInUp animated" id="properties">
                <div class="primary-context gray normal">
                    <div class="head"><?= ($model->objectProperties) ? Html::a('Properties', Url::to(['/object-properties/index', 'CcObjectPropertiesSearch[object_id]'=>$model->id]), []) : 'Properties' ?></div>
                    <div class="subhead"><?= Html::a('New Property', ['/object-properties/create', 'CcObjectProperties[object_id]' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?></div>
                </div>
                <div class="secondary-context">
                    <?= GridView::widget([
                        'dataProvider' => $properties,
                        'columns' => [
                            'id',
                            [
                                'label'=>'Property',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return Html::a($data->property->name, ['object-properties/view', 'id' => $data->id]);
                                },
                            ],
                            [
                                'label'=>'Inheritance',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return Html::a($data->object->name, ['objects/view', 'id' => $data->object_id]);
                                },
                            ],
                            [
                                'label'=>'Unit',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return $data->unit ? Html::a($data->unit->name, ['units/view', 'id' => $data->id]) : null;
                                },
                            ],
                            'property_class',
                            [
                                'attribute' => 'property_type',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return ($data->property_type=='parts' or $data->property_type=='models') ? Html::a($data->property_type, Url::to(), ['data-toggle'=>'modal', 'data-backdrop'=>false,  'data-target'=>'#object-property-values-modal'.$data->id]) : $data->property_type;
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
                                        return \Yii::$app->user->can('manageCoreDatabase') ? Html::a('Update', ['/object-properties/update', 'id' => $model->id], ['class' => '']) : '';
                                    },
                                ],                        
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
            <div>
                <?php foreach($properties->getModels() as $objectProperty){
                    if($objectProperty->property_type=='parts' or $objectProperty->property_type=='integral_part'){
                        echo \Yii::$app->user->can('manageCoreDatabase') ? Html::a('Copy ' . $objectProperty->id, ['/object-properties/parents', 'id' => $model->id, 'parentId' => $objectProperty->object_id], ['class' => '']).'<br>' : '';
                    }                    
                } ?>
            </div>
            <div>
                <?php foreach($model->getProperties() as $objectProperty){
                    if($objectProperty->inheritance=='inherited' and ($objectProperty->property_type=='parts' or $objectProperty->property_type=='models')){
                        echo $objectProperty->property->name.'<ul>';
                        foreach($objectProperty->getAllPropertyValues($model) as $value){
                            echo $value->object ? '<li>'.$value->object->name.'</li>' : '<li>'.$value->propertyValue->value.'</li>';
                        }
                        echo '</ul>';
                    }                    
                } ?>
            </div>
            <?= Highcharts::widget([
               'options' => [
					'title' => ['text' => $model->name.' Price',/* 'x'=>-20*/],
					'subtitle' => ['text' => 'Source: WorldClimate.com', /*'x'=>-20*/],
					'xAxis' => [
						'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
					],
					'yAxis' => [
						'title' => ['text' => 'Temperature (°C)'],
						//'plotLines' => ['value'=>0, 'width'=>1, 'color'=>'#808080'],
					],
					'series' => [
						['name' => 'Tokyo', 'data' => [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]],
						/*['name' => 'New York', 'data' => [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]],*/
						['name' => 'Berlin', 'data' => [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]],
						/*['name' => 'London', 'data' => [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]]*/
					],
                    'tooltip' => [
                    	'valueSuffix' => '°C'
                    ],
                    'legend' => [
                    	'layout' => 'vertical',
                        'align' => 'right',
                        'verticalAlign' => 'middle',
                        'borderWidth' => 0,
                    ],
               ]
            ]); ?>
        </div>
            
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="card_container record-full grid-item fadeInUp animated" id="services">
                <div class="primary-context gray normal">
                    <div class="head"><?= ($model->services) ? Html::a('Services', Url::to(['/services/index', 'CcServicesSearch[object_id]'=>$model->id]), []) : 'Services' ?></div>
                    <div class="subhead"><?= Html::a('New Service', ['/services/create', 'CcServices[object_id]' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?></div>
                </div>
                <div class="secondary-context">
                    <?= GridView::widget([
                        'dataProvider' => $services,
                        'columns' => [
                            'id',
                            'name',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('<i class="material-icons">remove_red_eye</i>', ['view', 'id' => $model->id], ['class' => '']);
                                    },

                                    'update' => function ($url, $model, $key) {
                                        return \Yii::$app->user->can('manageCoreDatabase') ? Html::a('<i class="material-icons">edit</i>', ['update', 'id' => $model->id], ['class' => '']) : '';
                                    },

                                    'delete' => function ($url, $model, $key) {
                                        return \Yii::$app->user->can('manageCoreDatabase') ? Html::a('<i class="material-icons">delete</i>', ['delete', 'id' => $model->id], ['class' => '', 'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?','method' => 'post']]) : '';
                                    },
                                ],                       
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
            
    </div>
</div>



<?php 
    if($oproperties = $model->getProperties()){
        foreach($oproperties as $oproperty){
            if($oproperty->property_type=='parts' or $oproperty->property_type=='models' or $oproperty->property_type=='owner'){
                Modal::begin([
                'id'=>'object-property-values-modal'.$oproperty->id,
                'size'=>Modal::SIZE_SMALL,
                'class'=>'overlay_modal',
                'header'=> 'Property values '.Html::a($oproperty->property->name, Url::to(['/object-property-values/index', 'CcObjectPropertyValuesSearch[object_property_id]'=>$oproperty->id])),
            ]); ?>
                <div id="loading"><i class="fa fa-cog fa-spin fa-3x gray-color"></i></div>
            <?php Modal::end();
            }             
        }
    }  ?>

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

