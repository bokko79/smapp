<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_service_quantities".
 *
 * @property integer $service_id
 * @property string $amount_default
 * @property string $amount_min
 * @property string $amount_max
 * @property string $amount_step
 * @property integer $consumer_default
 * @property integer $consumer_min
 * @property integer $consumer_max
 * @property string $consumer_step
 */
class CcServiceQuantities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cc_service_quantities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id'], 'required'],
            [['service_id', 'amount_default', 'amount_min', 'amount_max', 'consumer_default', 'consumer_min', 'consumer_max'], 'integer'],
            [['amount_step', 'consumer_step'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_id' => Yii::t('app', 'Service ID'),
            'amount_default' => Yii::t('app', 'Amount Default'),
            'amount_min' => Yii::t('app', 'Amount Min'),
            'amount_max' => Yii::t('app', 'Amount Max'),
            'amount_step' => Yii::t('app', 'Amount Step'),
            'consumer_default' => Yii::t('app', 'Consumer Default'),
            'consumer_min' => Yii::t('app', 'Consumer Min'),
            'consumer_max' => Yii::t('app', 'Consumer Max'),
            'consumer_step' => Yii::t('app', 'Consumer Step'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(CcServices::className(), ['id' => 'service_id']);
    }
}
