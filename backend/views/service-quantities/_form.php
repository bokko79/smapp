<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
?>


<?php $form = kartik\widgets\ActiveForm::begin([
    'id' => 'form-horizontal',
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'fullSpan' => 7,      
    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_MEDIUM],
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>
    <?= $form->field($model, 'service_id')->input('number') ?>

    <?= $form->field($model, 'amount_default')->input('number') ?>

    <?= $form->field($model, 'amount_min')->input('number') ?>

    <?= $form->field($model, 'amount_max')->input('number') ?>

    <?= $form->field($model, 'amount_step')->input('number', ['step'=>0.01]) ?>

    <?= $form->field($model, 'consumer_default')->input('number') ?>

    <?= $form->field($model, 'consumer_min')->input('number') ?>

    <?= $form->field($model, 'consumer_max')->input('number') ?>

    <?= $form->field($model, 'consumer_step')->input('number') ?>

    <div class="row" style="margin:20px;">
        <div class="col-md-offset-3">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>        
    </div>
    <?php ActiveForm::end(); ?>