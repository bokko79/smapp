<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CcProcesses */

$this->title = 'Update Processes: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cc-processes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_trans' => $model_trans,
    ]) ?>

</div>
