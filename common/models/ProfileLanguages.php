<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_languages".
 *
 * @property string $id
 * @property string $profile_id
 * @property string $lang_code
 * @property string $status
 */
class ProfileLanguages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'lang_code'], 'required'],
            [['profile_id'], 'integer'],
            [['status'], 'string'],
            [['lang_code'], 'string', 'max' => 2],
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
            'lang_code' => 'Lang Code',
            'status' => 'Status',
        ];
    }
}
