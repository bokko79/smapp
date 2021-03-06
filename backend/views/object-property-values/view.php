<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CsObjectPropertyValues */

$this->title = $model->objectProperty->property->name . ' ' . $model->objectProperty->object->name . ': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Object Property Values'), 'url' => ['index']];
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
            'label' => 'Object Property',
            'format' => 'raw',
            'value'=> Html::a($model->objectProperty->property->name . ' ' . $model->objectProperty->object->tNameGen, Url::to(['/object-properties/view', 'id'=>$model->object_property_id]), []),
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
        'value_type',
        'value_class',
        [
            'label' => 'Countable',
            'value'=> ($model->countable_value==1 or $model->countable_value==2) ? ($model->countable_value==1 ? 'Single' : 'Multiple') : 'No',
        ],
        'default_part_no',
        [
            'label' => 'Selected',
            'value'=> $model->selected_value==1 ? 'Yes' : 'No',
        ],
    ],
]) ?>
