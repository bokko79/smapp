<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_provider_property_values".
 *
 * @property string $id
 * @property string $profile_provider_property_id
 * @property string $property_value_id
 * @property string $object_id
 * @property string $file_id
 * @property string $location_id
 * @property string $value
 * @property integer $read_only
 *
 * @property ProfileProviderProperties $profileProviderProperty
 * @property CcPropertyValues $propertyValue
 * @property CcObjects $object
 * @property Files $file
 * @property Locations $location
 */
class ProfileProviderPropertyValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_provider_property_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_provider_property_id'], 'required'],
            [['profile_provider_property_id', 'property_value_id', 'object_id', 'file_id', 'location_id', 'read_only'], 'integer'],
            [['value'], 'string', 'max' => 256],
            [['profile_provider_property_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProfileProviderProperties::className(), 'targetAttribute' => ['profile_provider_property_id' => 'id']],
            [['property_value_id'], 'exist', 'skipOnError' => true, 'targetClass' => CcPropertyValues::className(), 'targetAttribute' => ['property_value_id' => 'id']],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => CcObjects::className(), 'targetAttribute' => ['object_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Locations::className(), 'targetAttribute' => ['location_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_provider_property_id' => 'Profile Provider Property ID',
            'property_value_id' => 'Property Value ID',
            'object_id' => 'Object ID',
            'file_id' => 'File ID',
            'location_id' => 'Location ID',
            'value' => 'Value',
            'read_only' => 'Read Only',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileProviderProperty()
    {
        return $this->hasOne(ProfileProviderProperties::className(), ['id' => 'profile_provider_property_id']);
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
    public function getLocation()
    {
        return $this->hasOne(Locations::className(), ['id' => 'location_id']);
    }
}
