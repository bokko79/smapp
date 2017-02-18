<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_categories".
 *
 * @property string $id
 * @property string $post_id
 * @property string $category
 * @property string $category_id
 *
 * @property Posts $post
 */
class PostCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'category', 'category_id'], 'required'],
            [['post_id', 'category_id'], 'integer'],
            [['category'], 'string'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_id' => 'id']],
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
            'category' => 'Category',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['id' => 'post_id']);
    }
}
