<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_service_provider_properties".
 *
 * @property string $id
 * @property integer $service_id
 * @property integer $industry_property_id
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
class CcServiceProviderProperties extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_service_provider_properties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id', 'provider_property_id'], 'required'],
            [['service_id', 'provider_property_id', 'input_type', 'value_min', 'value_max', 'display_order', 'multiple_values', 'specific_values', 'read_only', 'required'], 'integer'],
            [['step'], 'number'],
            [['value_default'], 'string', 'max' => 128],
            [['pattern'], 'string', 'max' => 32],
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
            'provider_property_id' => Yii::t('app', 'Provider Property ID'),
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
    public function getProviderProperty()
    {
        return $this->hasOne(CcProviderProperties::className(), ['id' => 'provider_property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceProviderPropertyValues()
    {
        return $this->hasMany(CcServiceProviderPropertyValues::className(), ['service_provider_property_id' => 'id']);
    }
}
