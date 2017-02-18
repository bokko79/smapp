<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "translations".
 *
 * @property string $id
 * @property string $entity
 * @property string $entity_id
 * @property string $lang_code
 * @property string $name
 * @property string $name_gen
 * @property string $name_dat
 * @property string $name_akk
 * @property string $name_inst
 * @property string $description
 * @property string $hint
 * @property string $title
 *
 * @property CcLanguages $langCode
 */
class Translations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'translations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity', 'entity_id'], 'required'],
            [['entity', 'description'], 'string'],
            [['entity_id'], 'integer'],
            [['lang_code','name_gender'], 'string', 'max' => 2],
            [['name', 'name_gen', 'name_dat', 'name_akk', 'name_inst', 'name_pl', 'name_pl_gen', 'title', 'subtitle', 'hint_order', 'hint_listing'], 'string', 'max' => 128],
            [['hint', 'subtext', 'note', 'additional_note'], 'string', 'max' => 256],
            [['lang_code'], 'exist', 'skipOnError' => true, 'targetClass' => CcLanguages::className(), 'targetAttribute' => ['lang_code' => 'code']],
            [['description'], 'default', /*'skipOnEmpty' => true,*/ 'value' => null, /*'on' => 'insert'*/],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity' => 'Entity',
            'entity_id' => 'Entity ID',
            'lang_code' => 'Lang Code',
            'name' => 'Name',
            'name_gen' => 'Name Gen',
            'name_dat' => 'Name Dat',
            'name_akk' => 'Name Akk',
            'name_inst' => 'Name Inst',
            'name_pl' => 'Name Pl',
            'name_pl_gen' => 'Name Pl Gen',
            'name_gender' => 'Name Gender',
            'description' => 'Description',
            'hint' => 'Hint',
            'hint_order' => 'Hint Order',
            'hint_listing' => 'Hint Listing',
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'subtext' => 'Subtext',
            'note' => 'Note',
            'additional_note' => 'Add Note',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangCode()
    {
        return $this->hasOne(CcLanguages::className(), ['code' => 'lang_code']);
    }
}
