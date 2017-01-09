<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CsServiceIndustryPropertyValues */

$this->title = Yii::t('app', 'Create New Service Provider Property Values');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Provider Property Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= Html::encode($this->title) ?></h2>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
