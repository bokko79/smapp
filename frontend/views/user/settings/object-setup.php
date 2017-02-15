<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use PetraBarus\Yii2\GooglePlacesAutoComplete\GooglePlacesAutoComplete;
use kartik\widgets\ActiveField;
use kartik\slider\Slider;
use kartik\builder\Form;
use kartik\builder\FormGrid;

switch ($object->name) {
    default:
        $your = 'Vaše';
        break;
}

 $form = kartik\widgets\ActiveForm::begin([
    'id' => 'form-horizontal',
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'fullSpan' => 12,      
    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_MEDIUM],
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>

    <fieldset class="settings" style="margin:30px 0 !important;">  

<div class="wrapper headline" style="">
    <label class="head">
        <span class="badge">1</span>&nbsp;
        <?= Yii::t('app', 'Reč-dve o {object}...', ['your'=>$your, 'object'=>$object->name]) ?>
    </label>
    <?= ' <span class="red">*</span>' ?>
    <i class="fa fa-chevron-down chevron"></i>
</div>
<div class="wrapper body fadeIn animated" style="border-top:none;">
<?php // $this->render('../_hint.php', ['message'=>$message]) ?>

<?php foreach($model_properties as $model_property) {
        $objectProperty = $model_property->objectProperty;
        $property = $objectProperty->property;
        //$serviceObjectProperty = $objectProperty->serviceSpec($service->id);
        //if($serviceSpec and $serviceSpec->readOnly==0):
        switch($objectProperty->property_type)
        {      

            default:
                echo $this->render('//form/'.$objectProperty->inputType('user').'.php', ['form'=>$form, 'key'=>$property->id, 'model_object_property'=>$model_property, 'model_object_property_value'=>$model_property_value, 'objectProperty'=>$objectProperty, 'property'=>$property, /*'service'=>$service,*/ 'object_ownership'=>'user', 'object'=>$object]);
                //echo Html::activeHiddenInput($model_object_property, 'checkUserObject', ['id'=>'checkUserObject_model_spec'.$property->id]);
                //echo Html::activeHiddenInput($model_object_property, '['.$property->id.']checkIfRequired', ['id'=>'checkIfRequired_model_spec'.$property->id]);
        }
        
        //endif;   
    } ?>

</div>

 </fieldset>
<?php ActiveForm::end(); ?>

