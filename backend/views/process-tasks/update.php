<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CcProcessTasks */

$this->title = 'Update Process Tasks: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Process Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cc-process-tasks-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_trans' => $model_trans,
    ]) ?>

</div>
