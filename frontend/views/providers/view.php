<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CcProviders */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Providers'];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= c(Html::encode($this->title)) ?> <small>status: <?= $model->status ?></small></h2>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'category_id',
        'file_id',
        'status',
        'hit_counter',
    ],
]) ?>
