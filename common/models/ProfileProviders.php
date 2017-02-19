<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_providers".
 *
 * @property string $id
 * @property string $profile_id
 * @property integer $provider_id
 * @property integer $status
 *
 * @property ProfileProviderProperties[] $profileProviderProperties
 * @property Profile $profile
 * @property CcProviders $provider
 */
class ProfileProviders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_providers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'provider_id'], 'required'],
            [['profile_id', 'provider_id', 'status'], 'integer'],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
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
            'profile_id' => 'Profile ID',
            'provider_id' => 'Provider ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileProviderProperties()
    {
        return $this->hasMany(ProfileProviderProperties::className(), ['profile_provider_id' => 'id']);
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
    public function getProvider()
    {
        return $this->hasOne(CcProviders::className(), ['id' => 'provider_id']);
    }
}
