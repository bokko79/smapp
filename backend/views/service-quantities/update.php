<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CsServiceQuantities */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Service Quantity',
]) . ' ' . $model->service_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Quantities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->service_id, 'url' => ['view', 'id' => $model->service_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
