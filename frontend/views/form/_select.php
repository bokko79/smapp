<?php

use yii\helpers\Html;
use kartik\form\ActiveField;
use yii\helpers\ArrayHelper;

$model_list = $objectProperty->object ? ArrayHelper::map($objectProperty->objectPropertyValues, 'object.id', 'object.name') : ArrayHelper::map($property->propertyValues, 'id', 'value');
/*foreach($property->propertyValues as $propertyValue){
    if($propertyValue->selected_value==1){
        $model_object_property->value = $propertyValue->id;
        break;
    }
}*/
?>
	<?= $form->field($model_object_property, '['.$key.']value', [
		'hintType' => ActiveField::HINT_SPECIAL,
		'hintSettings' => ['onLabelClick' => true, 'onLabelHover' => false, 'title' => '<i class="glyphicon glyphicon-info-sign"></i> Napomena', ],
	    ])->dropDownList($model_list, ['prompt'=>'Izaberite...', 'class'=>'input-lg'])->label($property->name)->hint($property->name) ?>
