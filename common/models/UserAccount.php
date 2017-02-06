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

use dektrium\user\Finder;
use dektrium\user\helpers\Password;
use dektrium\user\Mailer;
use dektrium\user\Module;
use dektrium\user\traits\ModuleTrait;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\Application as WebApplication;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use dektrium\user\models\User as BaseUser;
use common\models\Log;

/**
 * User ActiveRecord model.
 *
 * @property bool    $isAdmin
 * @property bool    $isBlocked
 * @property bool    $isConfirmed
 *
 * Database fields:
 * @property integer $id
 * @property string  $username
 * @property string  $email
 * @property string  $unconfirmed_email
 * @property string  $password_hash
 * @property string  $phone
 * @property integer $language_id
 * @property integer $currency_id
 * @property string  $units
 * @property integer $type
 * @property integer $status
 * @property integer $membership_type
 * @property integer $current_location
 * @property integer $invited_by
 * @property string  $auth_key
 * @property string  $phone_verification_key
 * @property string  $location_verification_key
 * @property string  $invite_key
 * @property integer $registration_ip
 * @property integer $login_ip
 * @property integer $login_count
 * @property integer $login_time
 * @property integer $last_activity_time
 * @property integer $phone_verification_time
 * @property integer $location_verification_time
 * @property integer $membership_update_time
 * @property integer $membership_expiry_time
 * @property integer $status_update_time
 * @property integer $confirmed_at
 * @property integer $blocked_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $flags
 *
 * Defined relations:
 * @property Account[] $accounts
 * @property Profile[] $profiles
 *
 * Dependencies:
 * @property-read Finder $finder
 * @property-read Module $module
 * @property-read Mailer $mailer
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class UserAccount extends BaseUser
{
    use ModuleTrait;

    const BEFORE_CREATE   = 'beforeCreate';
    const AFTER_CREATE    = 'afterCreate';
    const BEFORE_REGISTER = 'beforeRegister';
    const AFTER_REGISTER  = 'afterRegister';
    const BEFORE_CONFIRM  = 'beforeConfirm';
    const AFTER_CONFIRM   = 'afterConfirm';

    // following constants are used on secured email changing process
    const OLD_EMAIL_CONFIRMED = 0b1;
    const NEW_EMAIL_CONFIRMED = 0b10;

    /** @var string Plain password. Used for model validation. */
    public $password;

    /** @var Profile|null */
    private $_profile;

    /** @var string Default username regexp */
    public static $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/';    

    // event init
    public function init()
    {
          $this->on(self::AFTER_CREATE, [$this, 'afterCreate']);
          $this->on(self::AFTER_REGISTER, [$this, 'afterRegister']);
    }

    /**
     * @return bool Whether the user is confirmed his phone number or not.
     */
    public function getIsPhoneVerified()
    {
        return $this->phone_verification_key == null;
    }

    /**
     * @return bool Whether the user is confirmed his location address or not.
     */
    public function getIsLocationVerified()
    {
        return $this->location_verification_key == null;
    }   

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany($this->module->modelMap['Profile'], ['user_id' => 'id'])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookmarkedServices()
    {
        return $this->hasMany(UserServices::className(), ['user_id' => 'id'])->where('status=1');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Log::className(), ['user_id' => 'id'])->orderBy(['id'=>SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        foreach ($this->profiles as $key => $profile) {
            if($profile->type==1){
                return $profile;
                break;
            }
        }
        return;
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'username'          => \Yii::t('user', 'Username'),
            'email'             => \Yii::t('user', 'Email'),
            'phone'             => \Yii::t('user', 'Phone'),
            'language_id'       => \Yii::t('user', 'Language'),
            'currency_id'       => \Yii::t('user', 'Currency'),
            'units'             => \Yii::t('user', 'Units'),
            'registration_ip'   => \Yii::t('user', 'Registration ip'),
            'unconfirmed_email' => \Yii::t('user', 'New email'),
            'password'          => \Yii::t('user', 'Password'),
            'created_at'        => \Yii::t('user', 'Registration time'),
            'confirmed_at'      => \Yii::t('user', 'Confirmation time'),
        ];
    }

    /**
     * Creates new user account. It generates password if it is not provided by user.
     *
     * @return bool
     */
    public function create()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $transaction = $this->getDb()->beginTransaction();

        try {
            $this->confirmed_at = time();
            $this->password = $this->password == null ? Password::generate(8) : $this->password;

            $this->trigger(self::BEFORE_CREATE);

            if (!$this->save()) {
                $transaction->rollBack();
                return false;
            }

            $this->mailer->sendWelcomeMessage($this, null, true);
            $this->trigger(self::AFTER_CREATE);

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            \Yii::warning($e->getMessage());
            return false;        
        }
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('auth_key', \Yii::$app->security->generateRandomString());
            $this->setAttribute('phone_verification_key', \Yii::$app->security->generateRandomString(4));
            $this->setAttribute('location_verification_key', \Yii::$app->security->generateRandomString(8));
            $this->setAttribute('invite_key', \Yii::$app->security->generateRandomString(13));
            if (\Yii::$app instanceof WebApplication) {
                $this->setAttribute('registration_ip', \Yii::$app->request->userIP);
            }
        }

        if (!empty($this->password)) {
            $this->setAttribute('password_hash', Password::hash($this->password));
        }

        return parent::beforeSave($insert);
    }

    /** @inheritdoc */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            if ($this->_profile == null) {
                $this->_profile = \Yii::createObject(Profile::className());                
            }
            $this->_profile->link('user', $this);
            $profileContact = new \dektrium\user\models\ProfileContact();
            $profileContact->profile_id = $this->_profile->id;
            $profileContact->contact_type = 1;
            $profileContact->contact_value = $this->email;
            $profileContact->save();
        }
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getLocation()
    {
        return $this->hasOne(\common\models\Locations::className(), ['id' => 'current_location']);
    }

    public function afterCreate($event){        
        $log = new Log;
        $log->logEvent(1);
    }

    public function afterRegister($event){        
        $log = new Log;
        $log->logEvent(3);
    }

    // User account types
    public function accountType()
    {
        switch ($this->type) {
            case 1: $accountType = 'permanent'; break;            
            default: $accountType = 'temporary'; break;
        }
        return $accountType;
    }

    // User account statuses
    public function accountStatus()
    {
        switch ($this->status) {
            case 2: $accountStatus = 'deactivated'; break;
            case 3: $accountStatus = 'hibernated'; break;
            case 4: $accountStatus = 'suspended'; break;
            case 5: $accountStatus = 'banned'; break;
            default: $accountStatus = 'active'; break;
        }
        return $accountStatus;
    }

    public function accountMembershipType()
    {
        switch ($this->membership_type) {
            case 1: $accountMembershipType = 'basic'; break;
            case 2: $accountMembershipType = 'silver'; break;
            case 3: $accountMembershipType = 'gold'; break;
            case 4: $accountMembershipType = 'premium'; break;            
            default: $accountMembershipType = 'free'; break;
        }
        return $accountMembershipType;
    }
}
