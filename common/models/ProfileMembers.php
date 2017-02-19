<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_members".
 *
 * @property string $id
 * @property string $user_id
 * @property string $profile_id
 * @property string $status
 * @property string $role
 * @property string $request_time
 * @property string $join_time
 * @property string $leave_time
 *
 * @property User $user
 * @property Profile $profile
 */
class ProfileMembers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_members';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'profile_id', 'status', 'role', 'request_time'], 'required'],
            [['user_id', 'profile_id', 'request_time', 'join_time', 'leave_time'], 'integer'],
            [['status', 'role'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'profile_id' => 'Profile ID',
            'status' => 'Status',
            'role' => 'Role',
            'request_time' => 'Request Time',
            'join_time' => 'Join Time',
            'leave_time' => 'Leave Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
}
