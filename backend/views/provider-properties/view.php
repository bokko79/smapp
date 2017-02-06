<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\CsSkills */

$this->title = $model->provider->name. '::'. $model->property->tName;
$this->params['breadcrumbs'][] = ['label' => 'Provider Property', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= c(Html::encode($this->title)) ?> <small>id: <?= $model->id ?> required: <?= $model->required==1 ? 'yes' : 'no' ?></small></h2>

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

<?php
    if($values = $model->property->propertyValues){ ?>

    <div class="card_container record-33 grid-item grid-item fadeInUp animated" id="card_container">
        <div class="primary-context gray normal">
            <div class="head major">Values</div>
        </div>
        <div class="secondary-context">
            <ul>
            <?php
                foreach ($values as $value){
                    echo '<li>'.Html::a(c($value->name), ['/property-values/view', 'id'=>$value->id]) . ' </li> ';
                } ?>
            </ul>
        </div>
    </div>

<?php
    } ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-<?= $model->specific_values==1 ? 4 : 12 ?>">
            <div class="card_container record-full grid-item fadeInUp animated" id="card_container" style="float:none;">             

                    
                 <div class="secondary-context">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'label' => 'Provider',
                                'format' => 'raw',
                                'value'=> $model->provider ? Html::a($model->provider->name, Url::to(['/providers/view', 'id'=>$model->provider_id]), []) : null,
                            ],
                            [
                                'label' => 'Property',
                                'format' => 'raw',
                                'value'=> $model->property ? Html::a($model->property->name, Url::to(['/properties/view', 'id'=>$model->property_id]), []) : null,
                            ],
                            'property_class',
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
        <?php if($model->specific_values==1): ?>
        <div class="col-sm-8">        
            <div class="card_container record-full grid-item fadeInUp animated" id="property-values">
                <div class="primary-context gray normal">
                    <div class="head"><?= ($model->providerPropertyValues) ? Html::a('Provider Property Values', Url::to(['/provider-property-values/index', 'CcProviderPropertyValuesSearch[provider_property_id]'=>$model->id]), []) : 'Provider Property Values' ?></div>
                    <div class="subhead"><?= Html::a('New Provider Property Value', ['/provider-property-values/create', 'CcProviderPropertyValues[object_property_id]' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?></div>
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
                                    return Html::a($data->id, ['provider-property-values/view', 'id' => $data->id]);
                                },
                            ],
                            [
                                'label'=>'Provider',
                                'format' => 'raw',
                                'value'=>function ($data) {
                                    return Html::a($data->providerProperty->provider->name, ['provider-properties/view', 'id' => $data->provider_property_id]);
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
                </div>
            </div>        
        </div>      
        <?php endif; ?>      
    </div>
</div>

