<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_terms".
 *
 * @property string $profile_id
 * @property string $ip_warranty
 * @property string $performance_warranty
 * @property string $invoicing
 * @property string $payment_methods
 * @property string $payment
 * @property integer $payment_advance_percentage
 * @property string $payment_at_once_time
 * @property integer $payment_installment_no_rates
 * @property integer $payment_installment_rate
 * @property integer $payment_installment_frequency
 * @property string $payment_installment_frequency_unit
 * @property string $liability
 * @property string $agreement_effective_until
 * @property string $cancellation_policy
 * @property string $update_time
 *
 * @property Profile $profile
 */
class ProfileTerms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_terms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'update_time'], 'required'],
            [['profile_id', 'payment_advance_percentage', 'payment_installment_no_rates', 'payment_installment_rate', 'payment_installment_frequency', 'update_time'], 'integer'],
            [['ip_warranty', 'performance_warranty', 'invoicing', 'payment_methods', 'payment', 'payment_at_once_time', 'payment_installment_frequency_unit', 'liability', 'agreement_effective_until', 'cancellation_policy'], 'string'],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'profile_id' => 'Profile ID',
            'ip_warranty' => 'Ip Warranty',
            'performance_warranty' => 'Performance Warranty',
            'invoicing' => 'Invoicing',
            'payment_methods' => 'Payment Methods',
            'payment' => 'Payment',
            'payment_advance_percentage' => 'Payment Advance Percentage',
            'payment_at_once_time' => 'Payment At Once Time',
            'payment_installment_no_rates' => 'Payment Installment No Rates',
            'payment_installment_rate' => 'Payment Installment Rate',
            'payment_installment_frequency' => 'Payment Installment Frequency',
            'payment_installment_frequency_unit' => 'Payment Installment Frequency Unit',
            'liability' => 'Liability',
            'agreement_effective_until' => 'Agreement Effective Until',
            'cancellation_policy' => 'Cancellation Policy',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
}
