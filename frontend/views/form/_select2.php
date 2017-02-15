<?php

use yii\helpers\Html;
use kartik\form\ActiveField;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

$model_list = $objectProperty->object ? ArrayHelper::map($objectProperty->objectPropertyValues, 'object.id', 'object.name') : ArrayHelper::map($property->propertyValues, 'id', 'value');

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
        ])->widget(Select2::classname(), [
            'data' => $model_list,
            'options' => ['placeholder' => 'Izaberite...'],
            'size' => Select2::LARGE,
            'language' => 'sr-Latn',
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label($property->name)->hint($property->name) ?>
