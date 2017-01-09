<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CsServices */

$this->title = $model->tName;
$this->params['breadcrumbs'][] = ['label' => 'Cs Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h2><?= Html::encode($this->title) ?></h2>

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
            'industry_id',
            'action_id',
            'object_id',
            'unit_id',
            'file_id',
            'name',
            'service_type',
            'object_class',
            'object_ownership',
            'file',
            'amount',
            'consumer',
            'consumer_children',
            'location',
            'coverage',
            'shipping',
            'geospecific',
            'time:datetime',
            'duration',
            'frequency',
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