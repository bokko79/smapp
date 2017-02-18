<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_comments".
 *
 * @property string $id
 * @property string $post_id
 * @property string $user_id
 * @property string $content
 * @property integer $status
 * @property string $time
 *
 * @property Posts $post
 * @property User $user
 */
class PostComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'user_id', 'content', 'time'], 'required'],
            [['post_id', 'user_id', 'status', 'time'], 'integer'],
            [['content'], 'string'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_id' => 'id']],
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
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'status' => 'Status',
            'time' => 'Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
