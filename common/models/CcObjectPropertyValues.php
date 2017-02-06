<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_object_property_values".
 *
 * @property integer $id
 * @property integer $object_property_id
 * @property integer $property_value_id
 * @property integer $object_id
 * @property integer $file_id
 * @property integer $countable_value
 * @property integer $default_part_no
 * @property integer $selected_value
 */

class CcObjectPropertyValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_object_property_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_property_id'], 'required'],
            [['object_property_id', 'property_value_id', 'object_id', 'file_id', 'selected_value', 'countable_value', 'default_part_no'], 'integer'],
            [['value_type', 'value_class'], 'string'],
            [['default_part_no'], 'default', 'value' => null,],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'object_property_id' => Yii::t('app', 'Object Property ID'),
            'property_value_id' => Yii::t('app', 'Property Value ID'),
            'object_id' => Yii::t('app', 'Object'),
            'file_id' => Yii::t('app', 'File'),
            'value_type' => Yii::t('app', 'Value Type'),
            'value_class' => Yii::t('app', 'Value Class'),
            'countable_value' => Yii::t('app', 'Parts Countable?'),
            'default_part_no' => Yii::t('app', 'Default number of parts'),
            'selected_value' => Yii::t('app', 'Selected Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectProperty()
    {
        return $this->hasOne(CcObjectProperties::className(), ['id' => 'object_property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyValue()
    {
        return $this->hasOne(CcPropertyValues::className(), ['id' => 'property_value_id']);
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
    public function getFile()
    {
        return $this->hasOne(Files::className(), ['id' => 'file_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceObjectPropertyValues()
    {
        return $this->hasMany(CcServiceObjectPropertyValues::className(), ['object_property_value_id' => 'id']);
    }   

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNameWithHint()
    {
        if($this->value_type=='part'){
            if ($this->object->tHint!=null) {
                return c($this->object->tName) . '<span data-container="body" data-toggle="popover" data-placement="top" data-content="'.$this->object->tHint.'">
                     <i class="fa fa-question-circle gray-color"></i>
                    </span>'; 
            } else {
                return c($this->object->tName);
            }
        } else {
            $property = $this->objectProperty->property;
            if ($property->hint!=null) {
                return $property->label . '<span data-container="body" data-toggle="popover" data-placement="top" data-content="'.$property->tHint.'">
                     <i class="fa fa-question-circle gray-color"></i>
                    </span>'; 
            } else {
                return $property->label;
            }
        }                           
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNameWithMedia()
    {
        $image = yii\helpers\Html::img('@web/images/cards/info/info_docs'.rand(0, 9).'.jpg', ['style'=>'width:100%; height:110px; margin: 5px 0 10px']); 

        if($this->value_type=='part'){
            if ($this->object->tHint!=null) {
                return c($this->object->tName) . '<span data-container="body" data-toggle="popover" data-placement="top" data-content="'.$this->object->tHint.'">
                     <i class="fa fa-question-circle gray-color"></i>
                    </span>' . $image; 
            } else {
                return c($this->object->tName) . $image;
            }
        } else {
            $property = $this->objectProperty->property;
            if ($property->hint!=null) {
                return $property->label . '<span data-container="body" data-toggle="popover" data-placement="top" data-content="'.$property->tHint.'">
                     <i class="fa fa-question-circle gray-color"></i>
                    </span>' . $image; 
            } else {
                return $property->label . $image;
            }
        } 
    } 
}
