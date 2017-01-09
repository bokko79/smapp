<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CsSkills */

$this->title = 'Create New Provider Property';
$this->params['breadcrumbs'][] = ['label' => 'Provider Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= Html::encode($this->title) ?> <small>Novo svojstvo delatnosti</small></h2>

<p>
    <?= Html::a('New Provider', ['/providers/create'], ['class' => 'btn btn-warning']) ?>
    <?= Html::a('New Property', ['/properties/create'], ['class' => 'btn btn-danger']) ?>
</p>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

