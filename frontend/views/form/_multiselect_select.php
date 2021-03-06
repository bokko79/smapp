<?php

use yii\helpers\Html;
use kartik\form\ActiveField;
use yii\helpers\ArrayHelper;
use kartik\builder\Form;

$model_list = ArrayHelper::map($property->propertyValues, 'id', 'tName');

foreach($property->propertyValues as $propertyValue){
    if($propertyValue->selected_value==1){
        $model_object_property->objectPropertyValues[] = $propertyValue->id;
    }
}
?>
<?= $form->field($model_object_property, '['.$key.']objectPropertyValues', [
        'hintType' => ActiveField::HINT_SPECIAL,
        'hintSettings' => ['onLabelClick' => true, 'onLabelHover' => false, 'title' => '<i class="glyphicon glyphicon-info-sign"></i> Napomena', ],
        ])->dropDownList($model_list, ['multiple'=>true, 'size'=>6])->label($property->label)->hint($property->tHint) ?>