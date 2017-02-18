<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CcProcessTasks */

$this->title = 'Create Process Tasks';
$this->params['breadcrumbs'][] = ['label' => 'Process Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cc-process-tasks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_trans' => $model_trans,
    ]) ?>

</div>
