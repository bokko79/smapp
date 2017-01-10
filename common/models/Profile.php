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
use dektrium\user\models\Profile as BaseProfile;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property string  $name
 * @property string  $public_email
 * @property string  $gravatar_email
 * @property string  $gravatar_id
 * @property string  $location
 * @property string  $website
 * @property string  $bio
 * @property string  $timezone
 * @property User    $user
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class Profile extends BaseProfile
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
     * @return \yii\db\ActiveQuery
     */
    public function getProfileContact()
    {
        return $this->hasMany($this->module->modelMap['ProfileContact'], ['profile_id' => 'id'])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileFiles()
    {
        return $this->hasMany($this->module->modelMap['ProfileFiles'], ['profile_id' => 'id'])->all();
    }
}
