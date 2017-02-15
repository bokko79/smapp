<?php

use yii\helpers\Html;
use kartik\form\ActiveField;
use yii\helpers\ArrayHelper;

$model_object_property->value = $objectProperty->value_default;
?>
<div class="form-group kv-fieldset-inline">
    <?= Html::activeLabel($model_object_property, '['.$key.']value', [
        'label'=>$property->name, 
        'class'=>'col-sm-3 control-label'
    ]); ?>
    <div class="col-sm-9" style="padding-right:0">
	<?= $form->field($model_object_property, '['.$key.']value', [
			'showLabels' => false,
			'hintType' => ActiveField::HINT_SPECIAL,
			'hintSettings' => ['onLabelClick' => true, 'onLabelHover' => false, 'title' => '<i class="glyphicon glyphicon-info-sign"></i> Napomena', ],
	    ])->input('text', ['value'=>$objectProperty->value_default, 'class'=>'input-lg'])->label($property->name)->hint($property->name) ?>
	</div>        
</div>