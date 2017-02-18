<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use kartik\checkbox\CheckboxX;
?>


<?php $form = kartik\widgets\ActiveForm::begin([
    'id' => 'form-horizontal',
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'fullSpan' => 7,      
    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_MEDIUM],
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>

    <?= $form->field($model, 'industry_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\CcIndustries::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false,           
        ]) ?>

    <?= $form->field($model, 'action_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\CcActions::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false,           
        ]) ?>

    <?= $form->field($model, 'object_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\CcObjects::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false,           
        ]) ?>

    <?= $form->field($model, 'unit_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\CcUnits::find()->all(), 'id', 'sign'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false,           
        ]) ?>

    <?= $form->field($model, 'file_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'service_type')->dropDownList([ 
                1 => 'create', 
                2 => 'read', 
                3 => 'update', 
                4 => 'delete', 
                5 => 'rent', 
                6 => 'fix', 
                7 => 'deliver', 
                8 => 'replace',
                9 => 'transport', 
                10 => 'show', 
                11 => 'perform', 
                12 => 'copy_paste',
                13 => 'sell', 
                14 => 'prepare', 
                15 => 'install', 
                16 => 'book', 
                17 => 'organize', 
                18 => 'save', 
                19 => 'care', 
                20 => 'represent',
                21 => 'buy',
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'industry_class')->dropDownList([ 'public' => 'Public', 'private' => 'Private', 'protected' => 'Protected', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'object_class')->dropDownList([ 'object' => 'Object', 'products' => 'Products', 'models' => 'Models', 'part' => 'Part', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'object_ownership')->dropDownList([ 
                0 => 'consumer', 
                1 => 'providers', 
                2 => 'users', 
                3 => 'providers multiple', 
                4 => 'users multiple', 
                5 => 'providers 2bcreated', 
                6 => 'users 2bcreate', 
                7 => 'providers intangible', 
                8 => 'users intangible',
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'file')->dropDownList([ 
                0 => 'no', 
                1 => 'required', 
                2 => 'optional', 
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'amount')->dropDownList([ 
                0 => 'no', 
                1 => 'required', 
                2 => 'optional', 
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'consumer')->dropDownList([ 
                0 => 'no', 
                1 => 'required', 
                2 => 'optional', 
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'consumer_children')->dropDownList([ 
                0 => 'no', 
                1 => 'required', 
                2 => 'optional', 
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'location')->dropDownList([ 
                0 => 'no', 
                1 => 'users', 
                2 => 'users start-end', 
                3 => 'users or providers', 
                4 => 'optional users start-end', 
                5 => 'providers', 
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'coverage')->dropDownList([ 
                0 => 'within', 
                1 => 'HQ only', 
                2 => 'city', 
                3 => 'region (up to 200km)', 
                4 => 'country', 
                5 => 'countries (up to 1000km)', 
                6 => 'worldwide', 
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'shipping')->widget(CheckboxX::classname(), ['pluginOptions'=>['size'=>'sm']]) ?>

    <?= $form->field($model, 'geospecific')->widget(CheckboxX::classname(), ['pluginOptions'=>['size'=>'sm']]) ?>

    <?= $form->field($model, 'time')->dropDownList([ 
                0 => 'no', 
                1 => 'users required', 
                2 => 'asap', 
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'duration')->dropDownList([ 
                0 => 'no', 
                1 => 'users required', 
                2 => 'optional', 
                3 => 'same as unit', 
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'frequency')->dropDownList([ 
                0 => 'no', 
                1 => 'once', 
                2 => 'return', 
                3 => 'frequently', 
                4 => 'indefinite', 
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'availability')->widget(CheckboxX::classname(), ['pluginOptions'=>['size'=>'sm']]) ?>

    <?= $form->field($model, 'installation')->widget(CheckboxX::classname(), ['pluginOptions'=>['size'=>'sm']]) ?>

    <?= $form->field($model, 'tools')->widget(CheckboxX::classname(), ['pluginOptions'=>['size'=>'sm']]) ?>

    <?= $form->field($model, 'turn_key')->widget(CheckboxX::classname(), ['pluginOptions'=>['size'=>'sm']]) ?>

    <?= $form->field($model, 'support')->widget(CheckboxX::classname(), ['pluginOptions'=>['size'=>'sm']]) ?>

    <?= $form->field($model, 'ordering')->dropDownList([ 
                0 => 'no', 
                1 => 'confirmation required', 
                2 => 'automatic', 
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'pricing')->dropDownList([ 
                0 => 'no', 
                1 => 'standard', 
                2 => 'special', 
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'terms')->widget(CheckboxX::classname(), ['pluginOptions'=>['size'=>'sm']]) ?>

    <?= $form->field($model, 'labour_type')->dropDownList([ 
                0 => 'equipment', 
                1 => 'human', 
            ], ['prompt' => '']) ?>

    <?= $form->field($model, 'process')->widget(CheckboxX::classname(), ['pluginOptions'=>['size'=>'sm']]) ?>

    <?= $form->field($model, 'dat')->dropDownList([ 'open' => 'Open', 'closed' => 'Closed', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'approved' => 'Approved', 'submitted' => 'Submitted', 'rejected' => 'Rejected', 'to_finish' => 'To finish', 'updated' => 'Updated', ], ['prompt' => '']) ?>

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