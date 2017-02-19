<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_accounts".
 *
 * @property string $id
 * @property string $profile_id
 * @property string $account_no
 * @property string $bank
 *
 * @property Profile $profile
 */
class ProfileAccounts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_accounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'account_no', 'bank'], 'required'],
            [['profile_id'], 'integer'],
            [['account_no'], 'string', 'max' => 32],
            [['bank'], 'string', 'max' => 40],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_id' => 'Profile ID',
            'account_no' => 'Account No',
            'bank' => 'Bank',
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
