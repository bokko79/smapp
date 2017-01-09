<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string $description
 * @property string $base_encode
 * @property string $created_at
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_at'], 'required'],
            [['type', 'base_encode'], 'string'],
            [['created_at'], 'integer'],
            [['name', 'description'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'base_encode' => 'Base Encode',
            'created_at' => 'Created At',
        ];
    }
}
