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


	<?= $form->field($model, 'process_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\CcProcesses::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false,           
        ]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'service' => 'Service', 'task' => 'Task', 'advice' => 'Advice', 'process' => 'Process', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'task_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'task_number')->input('number') ?>

    <hr>
    <h4>Translations</h4>
    <?= $form->field($model_trans, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model_trans, 'name_gen')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model_trans, 'name_dat')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model_trans, 'name_akk')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model_trans, 'name_inst')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model_trans, 'name_pl')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model_trans, 'name_pl_gen')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model_trans, 'name_gender')->dropDownList(['m' => 'muški', 'f' => 'ženski', 'n' => 'srednji'], ['style'=>'width:50%']) ?>
    <hr>
    <?= $form->field($model_trans, 'description')->textArea() ?>
    <?= $form->field($model_trans, 'subtext')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model_trans, 'hint')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model_trans, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model_trans, 'subtitle')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model_trans, 'note')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model_trans, 'additional_note')->textInput(['maxlength' => true]) ?>
    <hr>  

    <div class="row" style="margin:20px;">
        <div class="col-md-offset-3">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>        
    </div>

<?php ActiveForm::end(); ?>