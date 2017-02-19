<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_licences".
 *
 * @property string $id
 * @property string $profile_id
 * @property string $licence_no
 * @property integer $verification_code
 * @property integer $verified
 * @property string $verification_time
 *
 * @property Profile $profile
 */
class ProfileLicences extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_licences';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'licence_no'], 'required'],
            [['profile_id', 'verification_code', 'verified', 'verification_time'], 'integer'],
            [['licence_no'], 'string', 'max' => 32],
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
            'licence_no' => 'Licence No',
            'verification_code' => 'Verification Code',
            'verified' => 'Verified',
            'verification_time' => 'Verification Time',
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
