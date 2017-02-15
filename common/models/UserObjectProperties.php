<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_object_properties".
 *
 * @property string $id
 * @property string $user_object_id
 * @property string $property_id
 * @property string $value
 * @property string $value_max
 * @property string $value_operator
 *
 * @property UserObjects $userObject
 */
class UserObjectProperties extends \yii\db\ActiveRecord
{
    public $objectProperty;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_object_properties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_object_id', 'property_id'], 'required'],
            [['user_object_id', 'property_id', 'value_max', 'multiple_values', 'specific_values'], 'integer'],
            [['value', ], 'string', 'max' => 256],
            [['value_operator'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_object_id' => Yii::t('app', 'User Object ID'),
            'property_id' => Yii::t('app', 'Property ID'),
            'value' => Yii::t('app', 'Value'),
            'value_max' => Yii::t('app', 'Max'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserObject()
    {
        return $this->hasOne(UserObjects::className(), ['id' => 'user_object_id']);
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
        return $this->hasOne(CcUnits::className(), ['id' => 'unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserObjectPropertyValues()
    {
        return $this->hasMany(UserObjectPropertyValues::className(), ['user_object_property_id' => 'id']);
    }
}
