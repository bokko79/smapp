<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_courses".
 *
 * @property string $id
 * @property string $profile_id
 * @property string $title
 * @property string $company
 * @property string $start_month
 * @property integer $start_year
 * @property integer $current
 * @property string $end_month
 * @property integer $end_year
 * @property string $summary
 *
 * @property Profile $profile
 */
class ProfileCourses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_courses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'title', 'company', 'start_month', 'start_year', 'end_month', 'end_year', 'summary'], 'required'],
            [['profile_id', 'start_year', 'current', 'end_year'], 'integer'],
            [['summary'], 'string'],
            [['title'], 'string', 'max' => 64],
            [['company'], 'string', 'max' => 128],
            [['start_month', 'end_month'], 'string', 'max' => 3],
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
            'title' => 'Title',
            'company' => 'Company',
            'start_month' => 'Start Month',
            'start_year' => 'Start Year',
            'current' => 'Current',
            'end_month' => 'End Month',
            'end_year' => 'End Year',
            'summary' => 'Summary',
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
