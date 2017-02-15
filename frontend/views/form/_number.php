<?php

use yii\helpers\Html;
use kartik\form\ActiveField;
use yii\helpers\ArrayHelper;

$model_object_property->value = $objectProperty->value_default;
?>
<div class="form-group kv-fieldset-inline">
    <?= Html::activeLabel($model_object_property, '['.$key.']value', [
        'label'=>$property->label, 
        'class'=>'col-sm-3 control-label'
    ]); ?>
    <div class="col-sm-3" style="padding-right:0">
        <?= $form->field($model_object_property, '['.$key.']value',[
                'addon' => [
                    'append' => ['content'=>($objectProperty->unit!=null) ? $objectProperty->unit->sign : null],
                    'groupOptions' => ['class'=>'input-group-lg']],
                'feedbackIcon' => [
                    'success' => 'ok',
                    'error' => 'exclamation-sign',
                    'successOptions' => ['class'=>'text-primary', 'style'=>'padding-right:60%'],
                    'errorOptions' => ['class'=>'text-primary', 'style'=>'padding-right:60%; top: 6px;']
                ],
                //'hintType' => ActiveField::HINT_SPECIAL,
                //'hintSettings' => ['onLabelClick' => true, 'onLabelHover' => false, 'title' => '<i class="glyphicon glyphicon-info-sign"></i> Napomena', ],
                'showLabels'=>false
            ])->input('number', ['min'=>$objectProperty->value_min, 'max'=>$objectProperty->value_max, 'step'=>$objectProperty->step])->label($property->name)->hint($property->name) ?>
    </div>        
</div>