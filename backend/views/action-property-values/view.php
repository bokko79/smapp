<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\CsActionPropertyValues */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Action Property Values'), 'url' => ['index']];
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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Action Property',
                'format' => 'raw',
                'value'=> Html::a($model->actionProperty->property->name . ' ' . $model->actionProperty->action->name, Url::to(['/action-properties/view', 'id'=>$model->action_property_id]), []),
            ],
            [
                'label' => 'Property Value',
                'format' => 'raw',
                'value'=> $model->property_value_id ? Html::a($model->propertyValue->value, Url::to(['/property-values/view', 'id'=>$model->property_value_id]), []) : null,
            ],
            [
                'label' => 'Object',
                'format' => 'raw',
                'value'=> $model->object ? Html::a($model->object->name, Url::to(['/objects/view', 'id'=>$model->object_id]), []) : null,
            ],           
            [
                'label' => 'Selected',
                'value'=> $model->selected_value==1 ? 'Yes' : 'No',
            ],
        ],
    ]) ?>