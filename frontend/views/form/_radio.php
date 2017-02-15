<?php

use yii\helpers\Html;
use kartik\form\ActiveField;
use yii\helpers\ArrayHelper;

$model_list_hints = $objectProperty->object ? ArrayHelper::map($objectProperty->objectPropertyValues, 'object.id', 'object.name') : ArrayHelper::map($property->propertyValues, 'id', 'value');
$additional_option[null] = 'bilo koje';
$model_list_hints = ArrayHelper::merge($model_list_hints, $additional_option);
foreach($property->propertyValues as $propertyValue){
    if($propertyValue->selected_value==1){
        $model_object_property->value = $propertyValue->id;
        break;
    }
}
?>
	<?= $form->field($model_object_property, '['.$key.']value', [
		'hintType' => ActiveField::HINT_SPECIAL,
		'hintSettings' => ['onLabelClick' => true, 'onLabelHover' => false, 'title' => '<i class="glyphicon glyphicon-info-sign"></i> Napomena', ],
	    ])->radioList($model_list_hints)->label($property->name)->hint($property->name) ?>