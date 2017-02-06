<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;

//$model->value_class = 'protected';
?>


<?php $form = kartik\widgets\ActiveForm::begin([
    'id' => 'form-horizontal',
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'fullSpan' => 7,      
    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_MEDIUM],
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>


    <?= $form->field($model, 'object_property_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\CcObjectProperties::find()->joinWith('object as o')->joinWith('property as p')->groupBy(['o.id', 'p.id'])->all(), 'id', 'displayName'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false,           
        ]) ?>

    <?= $form->field($model, 'property_value_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\CcPropertyValues::find()->all(), 'id', 'value'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false,
            'pluginOptions' => [
                'allowClear' => true
            ],           
        ]) ?>

    <?= $form->field($model, 'object_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\CcObjects::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false, 
            'pluginOptions' => [
                'allowClear' => true
            ],          
        ]) ?>

    <?= $form->field($model, 'file_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\Files::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false, 
            'pluginOptions' => [
                'allowClear' => true
            ],          
        ]) ?>

        <?= $form->field($model, 'value_type')->dropDownList(['value' => 'value', 'model' => 'model', 'part' => 'part', 'other' => 'other', 'integral_part' => 'integral part', 'file' => 'file'], ['style'=>'width:50%']) ?>

        <?= $form->field($model, 'value_class')->dropDownList([ 'public' => 'Public', 'private' => 'Private', 'protected' => 'Protected', 'disabled' => 'Disabled',], ['prompt' => '',]) ?>

        <?= $form->field($model, 'countable_value')->dropDownList([0 => 'No', 1 => 'Yes - single', 2 => 'Yes - multiple'], ['style'=>'width:50%']) ?>

        <?= $form->field($model, 'default_part_no')->input('number', ['min'=>1, 'style'=>'width:50%']) ?>

    <?= $form->field($model, 'selected_value')->checkbox() ?>

    <div class="row" style="margin:20px;">
        <div class="col-md-offset-3">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>        
    </div>

    <?php ActiveForm::end(); ?>
