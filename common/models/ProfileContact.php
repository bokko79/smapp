<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace common\models;

use dektrium\user\traits\ModuleTrait;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "profile_contact".
 *
 * @property integer $id
 * @property integer $profile_id
 * @property integer $contact_type
 * @property string  $contact_value
 * @property string  $name
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class ProfileContact extends ActiveRecord
{
    use ModuleTrait;
    /** @var \dektrium\user\Module */
    protected $module;

    /** @inheritdoc */
    public function init()
    {
        $this->module = \Yii::$app->getModule('user');
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getProfile()
    {
        return $this->hasOne($this->module->modelMap['Profile'], ['id' => 'profile_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'contact_type', 'contact_value'], 'required'],
            [['contact_value'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'          => \Yii::t('user', 'Contact Name'),
            'profile_id'    => \Yii::t('user', 'Profile ID'),
            'contact_type'  => \Yii::t('user', 'Type'),
            'contact_value' => \Yii::t('user', 'Value'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profile_contact}}';
    }

    public function contactType()
    {
        switch ($this->contact_type) {
            case 1:
                $contactType = 'E-mail address';
                break;
            case 2:
                $contactType = 'Phone';
                break;
            case 3:
                $contactType = 'Fax';
                break;
            case 4:
                $contactType = 'Home address';
                break;
            case 5:
                $contactType = 'Skype IM';
                break;           
            
            default:
                $eventCode['name'] = 'Contact';
                break;
        }

        return $eventCode;
    }
}
