<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_provider_services".
 *
 * @property string $id
 * @property integer $provider_id
 * @property integer $service_id
 *
 * @property CcServices $service
 * @property CcProviders $provider
 */
class CcProviderServices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_provider_services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider_id', 'service_id'], 'required'],
            [['provider_id', 'service_id'], 'integer'],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => CcServices::className(), 'targetAttribute' => ['service_id' => 'id']],
            [['provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => CcProviders::className(), 'targetAttribute' => ['provider_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'provider_id' => 'Provider ID',
            'service_id' => 'Service ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(CcServices::className(), ['id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(CcProviders::className(), ['id' => 'provider_id']);
    }
}
