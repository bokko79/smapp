<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property string $id
 * @property string $profile_id
 * @property string $file_id
 * @property string $parent_id
 * @property string $lang_code
 * @property string $title
 * @property string $subtitle
 * @property string $content
 * @property string $excerpt
 * @property string $type
 * @property string $status
 * @property integer $comment_status
 * @property string $next_post
 * @property string $time
 * @property string $update_time
 *
 * @property PostCategories[] $postCategories
 * @property PostComments[] $postComments
 * @property PostFiles[] $postFiles
 * @property Profile $profile
 * @property Files $file
 * @property Posts $parent
 * @property Posts[] $posts
 * @property CcLanguages $langCode
 * @property Posts $nextPost
 * @property Posts[] $posts0
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'file_id', 'title', 'content', 'type', 'time'], 'required'],
            [['profile_id', 'file_id', 'parent_id', 'comment_status', 'next_post', 'time', 'update_time'], 'integer'],
            [['content', 'type', 'status'], 'string'],
            [['lang_code'], 'string', 'max' => 2],
            [['title'], 'string', 'max' => 128],
            [['subtitle', 'excerpt'], 'string', 'max' => 256],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            /*[['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['file_id' => 'id']],*/
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['lang_code'], 'exist', 'skipOnError' => true, 'targetClass' => CcLanguages::className(), 'targetAttribute' => ['lang_code' => 'code']],
            [['next_post'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['next_post' => 'id']],
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
            'file_id' => 'File ID',
            'parent_id' => 'Parent ID',
            'lang_code' => 'Lang Code',
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'type' => 'Type',
            'status' => 'Status',
            'comment_status' => 'Comment Status',
            'next_post' => 'Next Post',
            'time' => 'Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostCategories::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostComments()
    {
        return $this->hasMany(PostComments::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostFiles()
    {
        return $this->hasMany(PostFiles::className(), ['post_id' => 'id']);
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
    public function getFile()
    {
        return $this->hasOne(Files::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Posts::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Posts::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangCode()
    {
        return $this->hasOne(CcLanguages::className(), ['code' => 'lang_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNextPost()
    {
        return $this->hasOne(Posts::className(), ['id' => 'next_post']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreviousPost()
    {
        return $this->hasMany(Posts::className(), ['next_post' => 'id']);
    }
}
