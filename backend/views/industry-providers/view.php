<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CsSkills */

$this->title = $model->industry->name. '::'. $model->provider->name;
$this->params['breadcrumbs'][] = ['label' => 'Industry Provider', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= c(Html::encode($this->title)) ?> <small>id: <?= $model->id ?></small></h2>

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
        [
            'label'=>'Industry',
            'format'=>'raw',
            'value'=> Html::a($model->industry->name, ['industries/view', 'id' => $model->industry_id]),
        ],
        [
            'label'=>'Provider',
            'format'=>'raw',
            'value'=>Html::a($model->provider->name, ['providers/view', 'id' => $model->provider_id]),
        ],
        'type',
    ],
]) ?>

