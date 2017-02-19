<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_reviews".
 *
 * @property string $id
 * @property string $profile_id
 * @property string $user_id
 * @property string $content
 * @property integer $status
 * @property string $time
 *
 * @property Profile $profile
 * @property User $user
 */
class ProfileReviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_reviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'user_id', 'content', 'time'], 'required'],
            [['profile_id', 'user_id', 'status', 'time'], 'integer'],
            [['content'], 'string'],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'content' => 'Content',
            'status' => 'Status',
            'time' => 'Time',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
