<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CsSkills */

$this->title = 'Update Industry Provider: ' . ' ' . $model->provider->name;
$this->params['breadcrumbs'][] = ['label' => 'Industry Provider', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<h2><?= Html::encode($this->title) ?> <small>id: <?= $model->id ?></small></h2>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

