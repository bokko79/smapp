<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\Modal;

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
                        <?php /* Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) */ ?>
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
                                    <tr>
                                        <td>
                                            Path
                                        </td>
                                        <td>
                                            <?php foreach ($model->getPath($model) as $path){
                                                echo Html::a(c($path->name), ['view', 'id'=>$path->id]) . ' / ';
                                            } ?> <?= c($model->name) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Class
                                        </td>
                                        <td>
                                            <?= $model->class ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Level
                                        </td>
                                        <td>
                                            <?= $model->level ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Parent
                                        </td>
                                        <td><h4><b>
                                            <?= $model->parent ? Html::a(c($model->parent->name), ['view', 'id'=>$model->parent->id]) : null ?></b></h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Children
                                        </td>
                                        <td>
                                            <?php
                                                foreach ($model->children as $key => $child){
                                                    echo Html::a(c($child->name), ['view', 'id'=>$child->id]) . ($key==count($model->children)-1 ? null : ' <br> ');
                                                } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Parts
                                        </td>
                                        <td>
                                            <?php
                                                foreach ($model->parts as $key => $part){
                                                    echo Html::a(c($part->name), ['view', 'id'=>$part->id]) . ($key==count($model->parts)-1 ? null : ' <br> ');
                                                } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Containers
                                        </td>
                                        <td>
                                            <?php
                                                foreach ($model->containers as $key => $container){
                                                    echo Html::a(c($container->name), ['view', 'id'=>$container->id]) . ($key==count($model->containers)-1 ? null : ' <br> ');
                                                } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Siblings
                                        </td>
                                        <td>
                                            <?php
                                                if($model->parent){
                                                    foreach ($model->siblings as $key => $sibling){
                                                        echo Html::a(c($sibling->name), ['view', 'id'=>$sibling->id]) . ($key==count($model->siblings)-1 ? null : ' <br> ');
                                                    }
                                                } ?>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            Favourable
                                        </td>
                                        <td>
                                            <?= $model->favour==1 ? 'Yes' : 'No' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Hint
                                        </td>
                                        <td>
                                            <?= $model->tHint ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Description
                                        </td>
                                        <td>
                                            <?= $model->tDescription ?>
                                        </td>
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
                            'property_type',
                            'value_default',
                            // 'value_min',
                            // 'value_max',
                            // 'step',
                            // 'pattern',
                            [
                                'attribute' => 'multiple_values',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return $data->multiple_values==1 ? Html::a('Yes', Url::to(), ['data-toggle'=>'modal', 'data-backdrop'=>false,  'data-target'=>'#object-property-values-modal'.$data->id]) : 'No';
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
    if($oproperties = $model->getProperties($model)){
        foreach($oproperties as $oproperty){
            if($oproperty->multiple_values==1){
                Modal::begin([
                'id'=>'object-property-values-modal'.$oproperty->id,
                'size'=>Modal::SIZE_SMALL,
                'class'=>'overlay_modal',
                'header'=> 'Property values '.Html::a($oproperty->property->tName, Url::to(['/object-property-values/index', 'CcObjectPropertyValuesSearch[object_property_id]'=>$oproperty->id])),
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

