<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_availability".
 *
 * @property string $id
 * @property string $profile_id
 * @property integer $day_of_week
 * @property string $open
 * @property string $closed
 * @property integer $working_time
 *
 * @property Profile $profile
 */
class ProfileAvailability extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_availability';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'day_of_week'], 'required'],
            [['profile_id', 'day_of_week', 'working_time'], 'integer'],
            [['open', 'closed'], 'safe'],
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
            'day_of_week' => 'Day Of Week',
            'open' => 'Open',
            'closed' => 'Closed',
            'working_time' => 'Working Time',
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
