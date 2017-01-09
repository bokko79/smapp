<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CsServiceQuantitiesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cs-service-quantities-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'service_id') ?>

    <?= $form->field($model, 'amount_default') ?>

    <?= $form->field($model, 'amount_min') ?>

    <?= $form->field($model, 'amount_max') ?>

    <?= $form->field($model, 'amount_step') ?>

    <?php // echo $form->field($model, 'consumer_default') ?>

    <?php // echo $form->field($model, 'consumer_min') ?>

    <?php // echo $form->field($model, 'consumer_max') ?>

    <?php // echo $form->field($model, 'consumer_step') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
