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


<?php $form = ActiveForm::begin([
    'id' => 'create-update-object',
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'fullSpan' => 7,      
    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_MEDIUM],
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>
    <?= $form->field($model, 'name')->input('text') ?>

    <?= $form->field($model, 'object_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\CcObjects::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false,           
        ]) ?>

    <?= $form->field($model, 'class')->dropDownList(['abstract' => 'abstract', 'object' => 'object', 'product' => 'product', 'model' => 'model', 'part' => 'part'], ['style'=>'width:50%']) ?>
    
    <?= $form->field($model, 'favour')->checkbox()->label() ?>

    <?= $form->field($model, 'imageFile')->widget(FileInput::classname(), [
                        'options' => [/*'multiple' => true, */'accept' => 'image/*'],
                        'pluginOptions' => [
                            'previewFileType' => 'any',
                            'showCaption' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-info shadow',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' =>  Yii::t('app', 'Izaberite slike ili PDF'),
                            'removeLabel' =>  Yii::t('app', 'Izbaci sve'),
                            'resizeImage'=> true,
                            'maxImageWidth'=> 200,
                            'maxImageHeight'=> 200,
                            'resizePreference'=> 'width',
                        ],
                    ]) ?>

    <?php if($model->file){
        echo '<label class="control-label col-md-3" for="presentations-imagefiles">Slika predmeta</label>';
        echo '<div class="col-sm-9 margin-bottom-20">';

                $image = Html::img('/images/objects/'.$model->file->name);
                echo Html::a($image, Url::to(), [
                    'class' => 'margin-bottom-10 margin-right-10',
                    //'data-toggle'=>'modal', 'data-backdrop'=>false,  'data-target'=>'#file-delete'.$model->id
                ]);
        echo '</div>';
    } ?>

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
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save Updates', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>        
    </div>

    <?php ActiveForm::end(); ?>

