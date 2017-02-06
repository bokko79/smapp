<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_provider_properties".
 *
 * @property integer $id
 * @property integer $industry_id
 * @property integer $property_id
 * @property string $value_default
 * @property integer $value_min
 * @property string $value_max
 * @property string $step
 * @property string $pattern
 * @property integer $display_order
 * @property integer $multiple_values
 * @property integer $read_only
 * @property integer $required
 *
 * @property CcIndustries $industry
 * @property CcProperties $property
 * @property ProviderIndustrySkills[] $providerIndustrySkills
 */
class CcProviderProperties extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_provider_properties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider_id', 'property_id'], 'required'],
            [['provider_id', 'property_id', 'value_min', 'value_max', 'display_order', 'multiple_values', 'read_only', 'required'], 'integer'],
            [['step'], 'number'],
            [['value_default'], 'string', 'max' => 128],
            [['pattern'], 'string', 'max' => 32],
            [['property_class'], 'string'],
            [['value_min', 'value_max', 'value_default', 'step', 'pattern'], 'default', /*'skipOnEmpty' => true,*/ 'value' => null, /*'on' => 'insert'*/],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'provider_id' => Yii::t('app', 'Provider ID'),
            'property_id' => Yii::t('app', 'Property ID'),
            'property_class' => Yii::t('app', 'Property Class'),
            'value_default' => Yii::t('app', 'Value Default'),
            'value_min' => Yii::t('app', 'Value Min'),
            'value_max' => Yii::t('app', 'Value Max'),
            'step' => Yii::t('app', 'Step'),
            'pattern' => Yii::t('app', 'Pattern'),
            'display_order' => Yii::t('app', 'Display Order'),
            'multiple_values' => Yii::t('app', 'Multiple Values'),
            'read_only' => Yii::t('app', 'Read Only'),
            'required' => Yii::t('app', 'Required'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(CcProviders::className(), ['id' => 'provider_id']);
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
    public function getProviderPropertyValues()
    {
        return $this->hasMany(CcProviderPropertyValues::className(), ['provider_property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceProviderProperties()
    {
        return $this->hasMany(CcServiceProviderProperties::className(), ['provider_property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function serviceProviderProperty($service_id)
    {
        return CcServiceProviderProperties::find()->where('provider_property_id='.$this->id.' AND service_id='.$service_id)->one();
    }
}
