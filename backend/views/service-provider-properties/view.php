<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CsServiceSkills */

$this->title = $model->service->name . ' - ' . $model->providerProperty->property->name;
$this->params['breadcrumbs'][] = ['label' => 'Service Provider Property', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= c(Html::encode($this->title)) ?> <small>required: <?= $model->required ?></small></h2>

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

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'service_id',
        'provider_property_id',
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
