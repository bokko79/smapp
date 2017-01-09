<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_provider_property_values".
 *
 * @property string $id
 * @property string $provider_property_id
 * @property string $property_value_id
 * @property integer $selected_value
 */
class CcProviderPropertyValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_provider_property_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider_property_id', 'property_value_id'], 'required'],
            [['provider_property_id', 'property_value_id', 'selected_value'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'provider_property_id' => Yii::t('app', 'Industry Property ID'),
            'property_value_id' => Yii::t('app', 'Property Value ID'),
            'selected_value' => Yii::t('app', 'Selected Value'),
        ];
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
    public function getPropertyValue()
    {
        return $this->hasOne(CcPropertyValues::className(), ['id' => 'property_value_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceProviderPropertyValues()
    {
        return $this->hasMany(CcServiceProviderPropertyValues::className(), ['provider_property_value_id' => 'id']);
    }
}
