<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\CsActions */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h2><?= c(Html::encode($this->title)) ?> <small>Action: <?= $model->status ?></small></h2>

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

<p>Services</p>
<p>Industries</p>
<p>Properties</p>
<div class="row">

    <div class="col-sm-12">
        <div class="card_container record-full grid-item fadeInUp animated" id="properties">
            <div class="primary-context gray normal">
                <div class="head"><?= ($model->actionProperties) ? Html::a('Properties', Url::to(['/action-properties/index', 'CcActionPropertiesSearch[object_id]'=>$model->id]), []) : 'Properties' ?></div>
                <div class="subhead"><?= Html::a('New Property', ['/action-properties/create', 'CcActionProperties[object_id]' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?></div>
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
                                return Html::a($data->property->name, ['action-properties/view', 'id' => $data->id]);
                            },
                        ],
                        [
                            'label'=>'Inheritance',
                            'format' => 'raw',
                            'value'=>function ($data) {
                                return Html::a($data->action->name, ['actions/view', 'id' => $data->action_id]);
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
                                return $data->multiple_values==1 ? Html::a('Yes', Url::to(), ['data-toggle'=>'modal', 'data-backdrop'=>false,  'data-target'=>'#action-property-values-modal'.$data->id]) : 'No';
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
                                    return \Yii::$app->user->can('manageCoreDatabase') ? Html::a('Update', ['/action-properties/update', 'id' => $model->id], ['class' => '']) : '';
                                },
                            ],                        
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
        
</div>
<p>Objects</p>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'object_mode',
        'status',
    ],
]) ?>

