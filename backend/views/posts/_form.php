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

    <?= $form->field($model, 'profile_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($user->profiles, 'id', 'name'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false,           
        ]) ?>

    <?= $form->field($model, 'file_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\Posts::find()->all(), 'id', 'title'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false,           
        ]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'core' => 'Core', 'news' => 'News', 'info' => 'Info', 'edu' => 'Edu', 'promo' => 'Promo', 'article' => 'Article', 'help' => 'Help', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'draft' => 'Draft', 'expired' => 'Expired', 'deleted' => 'Deleted', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'comment_status')->textInput() ?>

    <?= $form->field($model, 'next_post')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\Posts::find()->all(), 'id', 'title'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false,           
        ]) ?>

    <div class="row" style="margin:20px;">
        <div class="col-md-offset-3">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>        
    </div>

    <?php ActiveForm::end(); ?>
