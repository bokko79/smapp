<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_object_property_values".
 *
 * @property string $id
 * @property string $user_object_property_id
 * @property integer $property_value_id
 */
class UserObjectPropertyValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_object_property_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_object_property_id'], 'required'],
            [['user_object_property_id', 'property_value_id', 'object_id', 'file_id', 'location_id'], 'integer'],
            [['value', ], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_object_property_id' => Yii::t('app', 'User Object Spec ID'),
            'property_value_id' => Yii::t('app', 'Spec Model'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserObjectProperty()
    {
        return $this->hasOne(UserObjectProperties::className(), ['id' => 'user_object_property_id']);
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
    public function getLocation()
    {
        return $this->hasOne(Locations::className(), ['id' => 'location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(Files::className(), ['id' => 'file_id']);
    }
}
