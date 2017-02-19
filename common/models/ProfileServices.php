<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_services".
 *
 * @property string $id
 * @property string $profile_id
 * @property integer $service_id
 * @property integer $status
 *
 * @property Profile $profile
 * @property CcServices $service
 */
class ProfileServices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'service_id'], 'required'],
            [['profile_id', 'service_id', 'status'], 'integer'],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => CcServices::className(), 'targetAttribute' => ['service_id' => 'id']],
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
            'service_id' => 'Service ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(CcServices::className(), ['id' => 'service_id']);
    }
}
