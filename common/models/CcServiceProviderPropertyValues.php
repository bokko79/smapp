<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Cc_service_provider_property_values".
 *
 * @property string $id
 * @property string $service_industry_property_id
 * @property string $industry_property_value_id
 * @property integer $selected_value
 */
class CcServiceProviderPropertyValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_service_provider_property_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_provider_property_id', 'provider_property_value_id', 'selected_value'], 'required'],
            [['service_provider_property_id', 'provider_property_value_id', 'selected_value'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'service_provider_property_id' => Yii::t('app', 'Service Industry Property ID'),
            'provider_property_value_id' => Yii::t('app', 'Industry Property Value ID'),
            'selected_value' => Yii::t('app', 'Selected Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceIndustryProperty()
    {
        return $this->hasOne(CcServiceProviderProperties::className(), ['id' => 'service_provider_property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProviderPropertyValue()
    {
        return $this->hasOne(CcProviderPropertyValues::className(), ['id' => 'provider_property_value_id']);
    }
}
