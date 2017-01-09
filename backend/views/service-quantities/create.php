<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CsServiceQuantities */

$this->title = Yii::t('app', 'Create New Service Quantities');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Quantities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= Html::encode($this->title) ?></h2>

<?= $this->render('_form', [
    'model' => $model,
]) ?>