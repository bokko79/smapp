<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CsServiceObjectPropertyValues */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Object Property Values'), 'url' => ['index']];
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
        'serviceObjectProperty.id',
        [
            'label' => 'Service Object Property',
            'format' => 'raw',
            'value'=> Html::a($model->serviceObjectProperty->id, Url::to(['/service-object-properties/view', 'id'=>$model->serviceObjectProperty->id]), []),
        ],
        'serviceObjectProperty.service.name',
        'serviceObjectProperty.property_type',
        'serviceObjectProperty.objectProperty.property.name',
        'serviceObjectProperty.objectProperty.object.name',
        'objectPropertyValue.object.name',
    ],
]) ?>