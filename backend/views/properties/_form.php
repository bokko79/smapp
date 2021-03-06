<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>


<?php $form = kartik\widgets\ActiveForm::begin([
    'id' => 'login-form-horizontal',
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'fullSpan' => 7,      
    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'property_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(\common\models\CcProperties::find()->all(), 'id', 'name'),
                                'options' => ['placeholder' => 'Izaberi svojstvo ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]) ?>    

    <?= $form->field($model, 'type')->dropDownList([ 
                '1' => 'number',
                '2' => 'radio',
                '21' => 'radioButton',
                '22' => 'radio',
                '23' => 'radioButton',
                '3' => 'select',
                '31' => 'select2',
                '32' => 'select_media',
                '4' => 'multiselect',
                '41' => 'checkboxButton',
                '42' => 'multiselect_select',
                '43' => 'multiselect_select2',
                '44' => 'multiselect_media',
                '45' => 'multiselect_media_count',
                '5' => 'checkbox',
                '6' => 'text',
                '7' => 'textarea',
                '8' => 'slider',
                '9' => 'range',
                '10' => 'date',
                '11' => 'time',
                '12' => 'datetime',
                '13' => 'email',
                '14' => 'url',
                '15' => 'color',
                '16' => 'date range',
                '99' => 'file',

            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'specific_values')->widget(CheckboxX::classname(), ['pluginOptions'=>['size'=>'sm']]) ?>

    <?= $form->field($model, 'translatable_values')->widget(CheckboxX::classname(), ['pluginOptions'=>['size'=>'sm']]) ?>

    <?= $form->field($model, 'class')->dropDownList([ 
                'file' => 'file',
                'product' => 'product',
                'time' => 'time',
                'parts' => 'parts',
                'models' => 'models',
                'number' => 'number',
                'string' => 'string',
                'other' => 'drugo',

            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'description')->dropDownList([ 
                'specs' => 'svojstvo predmeta',
                'methods' => 'svojstvo akcije',
                'skills' => 'svojstvo delatnosti',

            ], ['prompt' => '']) ?>

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
            <?= !$model->isNewRecord ? Html::a('Go Back', Url::to(['view', 'id'=>$model->id]), ['class' => 'btn btn-default']) : null ?>
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>        
    </div>

<?php ActiveForm::end(); ?>
