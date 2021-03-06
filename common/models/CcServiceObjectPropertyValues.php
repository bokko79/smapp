<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_service_object_property_models".
 *
 * @property string $id
 * @property string $service_object_property_id
 * @property string $object_property_model_id
 */
class CcServiceObjectPropertyValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_service_object_property_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_object_property_id', 'object_property_value_id'], 'required'],
            [['service_object_property_id', 'object_property_value_id', 'selected_value'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'service_object_property_id' => Yii::t('app', 'Service Object Property ID'),
            'object_property_value_id' => Yii::t('app', 'Object Property Model ID'),
            'selected_value' => Yii::t('app', 'Selected Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceObjectProperty()
    {
        return $this->hasOne(CcServiceObjectProperties::className(), ['id' => 'service_object_property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectPropertyValue()
    {
        return $this->hasOne(CcObjectPropertyValues::className(), ['id' => 'object_property_value_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->serviceObjectProperty->service;
    }
}
