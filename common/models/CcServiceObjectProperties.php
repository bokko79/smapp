<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_service_object_properties".
 *
 * @property string $id
 * @property integer $service_id
 * @property string $object_property_id
 * @property integer $unit_id
 * @property integer $unit_imperial_id
 * @property integer $property_type
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
class CcServiceObjectProperties extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_service_object_properties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id', 'object_property_id'], 'required'],
            [['service_id', 'object_property_id', 'unit_id', 'unit_imperial_id', 'input_type', 'value_min', 'value_max', 'display_order', 'multiple_values', 'specific_values', 'read_only', 'required'], 'integer'],
            [['step'], 'number'],
            [['property_type'], 'string'],
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
            'service_id' => Yii::t('app', 'Service ID'),
            'object_property_id' => Yii::t('app', 'Object Property ID'),
            'unit_id' => Yii::t('app', 'Unit ID'),
            'unit_imperial_id' => Yii::t('app', 'Unit Imperial ID'),
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
    public function getService()
    {
        return $this->hasOne(CcServices::className(), ['id' => 'service_id']);
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
    public function getServiceObjectPropertyValues()
    {
        return $this->hasMany(CcServiceObjectPropertyValues::className(), ['service_object_property_id' => 'id']);
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
}
