<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CcProviders */

$this->title = 'Create New Provider';
$this->params['breadcrumbs'][] = ['label' => 'Providers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= Html::encode($this->title) ?> <small>Nova delatnost</small></h2>

<?= $this->render('_form', [
    'model' => $model,
    'model_trans' => $model_trans,
]) ?>
