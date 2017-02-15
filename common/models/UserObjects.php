<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_objects".
 *
 * @property string $id
 * @property string $user_id
 * @property integer $object_id
 * @property string $ime
 * @property string $loc_id
 * @property string $note
 * @property integer $is_set
 * @property string $update_time
 *
 * @property UserObjectProperties[] $userObjectProperties
 * @property CcObjects $object
 * @property User $user
 */
class UserObjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_objects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'object_id', 'parent_id', 'time'], 'required'],
            [['user_id', 'object_id', 'parent_id', 'time', 'is_set'], 'integer'],
            [['time'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['note', 'function'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'object_id' => Yii::t('app', 'Object ID'),
            'parent_id' => Yii::t('app', 'Parent'),
            'name' => Yii::t('app', 'Ime'),
            'function' => Yii::t('app', 'Function'),
            'note' => Yii::t('app', 'Note'),
            'is_set' => Yii::t('app', 'Is Set'),
            'time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserObjectProperties()
    {
        return $this->hasMany(UserObjectProperties::className(), ['user_object_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(CcObjects::className(), ['id' => 'object_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(CcObjects::className(), ['id' => 'parent_id']);
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
    public function getObjectName()
    {
        return c($this->object->name);
    }
}
