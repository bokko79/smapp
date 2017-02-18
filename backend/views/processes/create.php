<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CcProcesses */

$this->title = 'Create Processes';
$this->params['breadcrumbs'][] = ['label' => 'Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cc-processes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_trans' => $model_trans,
    ]) ?>

</div>
