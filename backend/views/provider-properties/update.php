<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CsSkills */

$this->title = 'Update Provider Property: ' . ' ' . $model->property->name;
$this->params['breadcrumbs'][] = ['label' => 'Provider Property', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<h2><?= Html::encode($this->title) ?> <small>id: <?= $model->id ?> required: <?= $model->required==1 ? 'yes' : 'no' ?></small></h2>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

