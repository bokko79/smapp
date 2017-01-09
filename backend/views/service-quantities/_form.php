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
    <?= $form->field($model, 'service_id')->textInput() ?>

    <?= $form->field($model, 'amount_default')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount_min')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount_max')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount_step')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'consumer_default')->textInput() ?>

    <?= $form->field($model, 'consumer_min')->textInput() ?>

    <?= $form->field($model, 'consumer_max')->textInput() ?>

    <?= $form->field($model, 'consumer_step')->textInput(['maxlength' => true]) ?>

    <div class="row" style="margin:20px;">
        <div class="col-md-offset-3">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>        
    </div>
    <?php ActiveForm::end(); ?>