<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_service_action_property_values".
 *
 * @property string $id
 * @property string $service_action_property_id
 * @property string $action_property_value_id
 */
class CcServiceActionPropertyValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_service_action_property_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_action_property_id', 'action_property_value_id'], 'required'],
            [['service_action_property_id', 'action_property_value_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'service_action_property_id' => Yii::t('app', 'Service Action Property ID'),
            'action_property_value_id' => Yii::t('app', 'Action Property Value ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceActionProperty()
    {
        return $this->hasOne(CcServiceActionProperties::className(), ['id' => 'service_action_property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActionPropertyValue()
    {
        return $this->hasOne(CcActionPropertyValues::className(), ['id' => 'action_property_value_id']);
    }
}
