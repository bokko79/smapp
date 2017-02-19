<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_provider_properties".
 *
 * @property string $id
 * @property string $profile_provider_id
 * @property integer $property_id
 * @property string $value
 * @property integer $value_max
 * @property string $value_operator
 * @property integer $multiple_values
 * @property integer $specific_values
 * @property integer $read_only
 *
 * @property ProfileProviders $profileProvider
 * @property CcProperties $property
 * @property ProfileProviderPropertyValues[] $profileProviderPropertyValues
 */
class ProfileProviderProperties extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_provider_properties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_provider_id', 'property_id'], 'required'],
            [['profile_provider_id', 'property_id', 'value_max', 'multiple_values', 'specific_values', 'read_only'], 'integer'],
            [['value_operator'], 'string'],
            [['value'], 'string', 'max' => 256],
            [['profile_provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProfileProviders::className(), 'targetAttribute' => ['profile_provider_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => CcProperties::className(), 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_provider_id' => 'Profile Provider ID',
            'property_id' => 'Property ID',
            'value' => 'Value',
            'value_max' => 'Value Max',
            'value_operator' => 'Value Operator',
            'multiple_values' => 'Multiple Values',
            'specific_values' => 'Specific Values',
            'read_only' => 'Read Only',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileProvider()
    {
        return $this->hasOne(ProfileProviders::className(), ['id' => 'profile_provider_id']);
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
    public function getProfileProviderPropertyValues()
    {
        return $this->hasMany(ProfileProviderPropertyValues::className(), ['profile_provider_property_id' => 'id']);
    }
}
