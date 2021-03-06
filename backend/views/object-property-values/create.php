<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CsObjectPropertyValues */

$this->title = Yii::t('app', 'Create New Object Property Value');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Object Property Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>