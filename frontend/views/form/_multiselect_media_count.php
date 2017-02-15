<?php

use yii\helpers\Html;
use kartik\form\ActiveField;
use yii\helpers\ArrayHelper;
use kartik\builder\Form;
use kartik\checkbox\CheckboxX;

switch($objectProperty->property_type)
{
    case 'part':
        $model_list = ArrayHelper::map($property->propertyValues, 'id', 'mediaWithCheckbox');

    default:
        //$model_list = ArrayHelper::map($objectProperty->objectParts, 'part_id', 'partDescription');
        $model_list = ArrayHelper::map($property->propertyValues, 'id', 'mediaWithCheckbox');

        /*foreach($property->propertyValues as $propertyValue){
            if($propertyValue->selected_value==1){
                $model_object_property->orderServiceObjectPropertyValues[] = $propertyValue->id;
            }
        }*/
    break;
        
}

?>
<div class="enclosedCheckboxes">
    <?= Form::widget([
        'model'=>$model_object_property,
        'form'=>$form,
        'options'=>['tag'=>'div', 'style'=>'margin:10px 0;'],
        'contentBefore'=>'',
        'attributes'=> [
        	'['.$key.']orderServiceObjectPropertyValues' => [
        		'type'=>Form::INPUT_CHECKBOX_LIST,
        		'label' => $property->label .'<br><div class="checkbox col-sm-offset-3"><label><input type="checkbox" id="ckbCheckAll'. $property->id .'"> <i>Izaberite/Poništite sve</i></label></div>',
        		'hint'=> $property->tHint,
        		'fieldConfig'=>[
                    'hintType' => ActiveField::HINT_SPECIAL,
    				'hintSettings' => ['onLabelClick' => false, 'onLabelHover' => true, 'title' => '<i class="glyphicon glyphicon-info-sign"></i> Napomena', ],
                ],	    		
        		'items' => $model_list,
        		'options'=>['tag'=>'ul', 'class'=>'column2 multiselect', 'style'=>'padding:13px 20px 20px; background:#f8f8f8; border:1px solid #ddd; border-radius:4px;'],
        	]
        ]
    ]) ?>
</div>
<?php  /*
    foreach($property->propertyValues as $propertyValue){ ?>
    <label class="cbx-label" for="OrderServiceObjectProperties[id]">
        <div class="card_container record-md grid-item fadeInUp animated" id="card_container" style="float:none;">        
                <div class="media-area square">                
                    <div class="image">
                        <?= Html::img('@web/images/cards/info/info_docs'.rand(0, 9).'.jpg') ?>                                        
                    </div>
                    <div class="primary-context in-media dark">
                        <div class="head"><?= $propertyValue->tName ?></div>
                    </div>
                    <div class="action-area" style="height:40px; position: absolute; top:0; right:0;">
                        <?= $form->field($model_object_property, '['.$key.']id')->widget(CheckboxX::classname(), []) ?>
                    </div> 
                </div>            
                      
        </div>
    </label>
<?php
*/