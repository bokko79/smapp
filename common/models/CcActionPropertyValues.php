<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_action_property_values".
 *
 * @property string $id
 * @property string $action_property_id
 * @property string $property_value_id
 * @property integer $selected_value
 */
class CcActionPropertyValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_action_property_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action_property_id', 'property_value_id'], 'required'],
            [['action_property_id', 'property_value_id', 'selected_value'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'action_property_id' => Yii::t('app', 'Action Property ID'),
            'property_value_id' => Yii::t('app', 'Property Value ID'),
            'selected_value' => Yii::t('app', 'Selected Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActionProperty()
    {
        return $this->hasOne(CcActionProperties::className(), ['id' => 'action_property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyValue()
    {
        return $this->hasOne(CcPropertiesValues::className(), ['id' => 'property_value_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceActionPropertyValues()
    {
        return $this->hasMany(CcServiceActionPropertyValues::className(), ['action_property_value_id' => 'id']);
    }
}
