<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_object_properties".
 *
 * @property string $id
 * @property string $object_id
 * @property integer $property_id
 * @property integer $unit_id
 * @property integer $unit_imperial_id
 * @property string $property_class
 * @property string $property_type
 * @property integer $input_type
 * @property string $value_default
 * @property integer $value_min
 * @property string $value_max
 * @property string $step
 * @property string $pattern
 * @property integer $display_order
 * @property integer $multiple_values
 * @property integer $specific_values
 * @property integer $read_only
 * @property integer $required
 */
class CcObjectProperties extends \yii\db\ActiveRecord
{
    public $inheritance;

    public $primary_object;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_object_properties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'property_id'], 'required'],
            [['object_id', 'property_id', 'unit_id', 'unit_imperial_id', 'input_type', 'value_min', 'value_max', 'display_order', 'multiple_values', 'specific_values', 'read_only', 'required'], 'integer'],
            [['property_class', 'property_type'], 'string'],
            [['step'], 'number'],
            [['value_default'], 'string', 'max' => 128],
            [['pattern'], 'string', 'max' => 32],
            [['unit_id', 'unit_imperial_id', 'input_type', 'value_min', 'value_max', 'value_default', 'step', 'pattern'], 'default', /*'skipOnEmpty' => true,*/ 'value' => null, /*'on' => 'insert'*/],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'object_id' => Yii::t('app', 'Object ID'),
            'property_id' => Yii::t('app', 'Property ID'),
            'unit_id' => Yii::t('app', 'Unit ID'),
            'unit_imperial_id' => Yii::t('app', 'Unit Imperial ID'),
            'property_class' => Yii::t('app', 'Class'),
            'property_type' => Yii::t('app', 'Type'),
            'input_type' => Yii::t('app', 'Input Type'),
            'value_default' => Yii::t('app', 'Value Default'),
            'value_min' => Yii::t('app', 'Value Min'),
            'value_max' => Yii::t('app', 'Value Max'),
            'step' => Yii::t('app', 'Step'),
            'pattern' => Yii::t('app', 'Pattern'),
            'display_order' => Yii::t('app', 'Display Order'),
            'multiple_values' => Yii::t('app', 'Multiple Values'),
            'specific_values' => Yii::t('app', 'Specific Values'),
            'read_only' => Yii::t('app', 'Read Only'),
            'required' => Yii::t('app', 'Required'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceObjectProperties()
    {
        return $this->hasMany(CcServiceObjectProperties::className(), ['object_property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectPropertyValues()
    {
        return $this->hasMany(CcObjectPropertyValues::className(), ['object_property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(CcObjects::className(), ['id' => 'object_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(CcProperties::className(), ['id' => 'property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(CCUnits::className(), ['id' => 'unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitImperial()
    {
        return $this->hasOne(CCUnits::className(), ['id' => 'unit_imperial_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderServiceObjectProperties()
    {
        return $this->hasMany(OrderServiceObjectProperties::className(), ['object_property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresentationObjectProperties()
    {
        return $this->hasMany(PresentationObjectProperties::className(), ['object_property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserObjectProperties()
    {
        return $this->hasMany(UserObjectProperties::className(), ['object_property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function serviceObjectProperty($service_id)
    {
        return CCServiceObjectProperties::find()->where('object_property_id='.$this->id.' AND service_id='.$service_id)->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getName()
    {
        return $this->property->tName . '  ' . (($this->object) ? $this->object->tNameGen : null);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisplayName()
    {
        return $this->property->name . '  ' . (($this->object) ? $this->object->name : null);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllValues()
    { 
        $values     = [];
        $check      = [];
        $checkFile  = [];
        $checkValue = [];

        // object
        $object     = $this->object;

        // values of object's property
        /*if($objectPropertyValues = $this->objectPropertyValues){
            foreach($objectPropertyValues as $objectPropertyValue){
                if($objectPropertyValue->value_class=='disabled'){
                    $check[] = $objectPropertyValue->object_id;
                } else {
                    if(!in_array($objectPropertyValue, $values) and !in_array($objectPropertyValue->object_id, $check)){
                        $values[] = $objectPropertyValue; 
                        $check[] = $objectPropertyValue->object_id;
                    }
                }
            }
        }*/

        // public and protected values of inherited properties
        if($objectProperties = $object->getAllProperties()){ // all object properties
            foreach($objectProperties as $objectProperty){
                if($objectProperty->property_id==$this->property_id and $objectPropertyValues = $objectProperty->objectPropertyValues){
                    foreach($objectPropertyValues as $objectPropertyValue){
                        if($objectProperty->inheritance=='own'){ // own property                    
                            if($objectPropertyValue->value_class!='disabled'){
                                if(!in_array($objectPropertyValue, $values) and (!in_array($objectPropertyValue->property_value_id, $checkValue) or !in_array($objectPropertyValue->object_id, $check) or !in_array($objectPropertyValue->file_id, $checkFile))){
                                    $values[] = $objectPropertyValue;
                                }   
                            }
                        } else { // inherited property
                            if(!in_array($objectPropertyValue, $values) and ($objectPropertyValue->value_class=='protected' or $objectPropertyValue->value_class=='public') and (!in_array($objectPropertyValue->property_value_id, $checkValue) or !in_array($objectPropertyValue->object_id, $check) or !in_array($objectPropertyValue->file_id, $checkFile))){
                                $values[] = $objectPropertyValue;
                            }
                        }
                        $checkFile[]    = ($objectPropertyValue->value_type=='file') ? $objectPropertyValue->file_id : null;
                        $checkValue[]   = ($objectPropertyValue->value_type=='value') ? $objectPropertyValue->property_value_id : null;
                        $check[]        = ($objectPropertyValue->value_type=='part' or $objectPropertyValue->value_type=='model' or $objectPropertyValue->value_type=='integral_part' or $objectPropertyValue->value_type=='other') ? $objectPropertyValue->object_id : null;                                                                                         
                    }                                                         
                }
            }
        }

        // public and protected values of molds
        /*if($molds = $object->molds){
            foreach (array_reverse($molds) as $key => $mold) {
                if($objectPropertiesmm = $mold->objectProperties){
                    foreach($objectPropertiesmm as $objectPropertymm){
                        if($objectPropertymm->property_id==$this->property_id and $objectPropertyValuesmm = $objectPropertymm->objectPropertyValues){
                            foreach($objectPropertyValuesmm as $objectPropertyValuemm){
                                if(!in_array($objectPropertyValuemm, $values) and ($objectPropertyValuemm->value_class=='protected' or $objectPropertyValuemm->value_class=='public') and !in_array($objectPropertyValuemm->object_id, $check)){
                                    $values[] = $objectPropertyValuemm;
                                    $check[] = $objectPropertyValuemm->object_id;
                                }                                   
                            }                                
                        }
                    }
                }                    
            }
        }*/

        return $values;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllPropertyValues($object)
    { 
        $values = [];
        $check = [];

        // values of object property
        if($objectPropertyValues = $this->objectPropertyValues){
            foreach($objectPropertyValues as $objectPropertyValue){
                if(!in_array($objectPropertyValue, $values) and $objectPropertyValue->value_class!='disabled'){
                    $values[] = $objectPropertyValue; 
                    $check[] = $objectPropertyValue->object_id;                   
                }                
            }
        }

        // public and protected values of inherited properties
        if($inheritedProperties = $object->getProperties()){
            foreach($inheritedProperties as $inheritedProperty){
                if($inheritedProperty->property_id==$this->property_id and $inheritedProperty->inheritance=='inherited' and $objectPropertyValuesmm = $inheritedProperty->objectPropertyValues){
                    foreach($objectPropertyValuesmm as $objectPropertyValuemm){
                        if(!in_array($objectPropertyValuemm, $values) and ($objectPropertyValuemm->value_class=='protected' or $objectPropertyValuemm->value_class=='public') and !in_array($objectPropertyValuemm->object_id, $check)){
                            $values[] = $objectPropertyValuemm;
                            $check[] = $objectPropertyValuemm->object_id;
                        }                                   
                    }                                
                }
                //break;
            }
        }
        return $values;
    }
}
