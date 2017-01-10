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

use dektrium\user\helpers\Password;
use dektrium\user\Mailer;
use dektrium\user\Module;
use dektrium\user\traits\ModuleTrait;
use Yii;
use dektrium\user\models\SettingsForm as BaseSettingForm;
use common\models\Log;

/**
 * SettingsForm gets user's username, email and password and changes them.
 *
 * @property User $user
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class SettingsForm extends BaseSettingForm
{
    use ModuleTrait;

    /** @var string */
    public $phone_verification;

    /** @var string */
    public $location_verification;

    /** @var string */
    public $language;

    /** @var string */
    public $currency;

    /** @var string */
    public $units;

    /** @var string */
    public $status;

    /** @var User */
    private $_user;

    /** @return User */
    public function getUser()
    {
        if ($this->_user == null) {
            $this->_user = \common\models\UserAccount::findOne(\Yii::$app->user->id);
        }

        return $this->_user;
    }

    /**
     * Event is triggered after phone verification.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_PHONE_VERIFICATION = 'afterPhoneVerification';

    /**
     * Event is triggered after location verification.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_LOCATION_VERIFICATION = 'afterLocationVerification';

    /** @inheritdoc */
    public function __construct(Mailer $mailer, $config = [])
    {
        $this->mailer = $mailer;
        $this->setAttributes([
            'username' => $this->user->username,
            'email'    => $this->user->unconfirmed_email ?: $this->user->email,
            'language' => $this->user->language_id,
            'currency' => $this->user->currency_id,
            'units' => $this->user->units,
            'status' => $this->user->status,
        ], false);
        parent::__construct($mailer, $config);
    }

    // event init
    public function init()
    {
        $this->on(self::EVENT_AFTER_PHONE_VERIFICATION, [$this, 'afterPhoneVerification']);
        $this->on(self::EVENT_AFTER_LOCATION_VERIFICATION, [$this, 'afterLocationVerification']);
    }

    /** @inheritdoc */
    public function rules()
    {
        $rules = parent::rules();   
        $rules['phoneVerificationLength'] = ['phone_verification', 'string', 'min' => 4, 'max' => 4];
        $rules['locationVerificationLength'] = ['location_verification', 'string', 'min' => 8, 'max' => 8];
        $rules['language'] = ['language', 'required'];
        $rules['currency'] = ['currency', 'required'];
        $rules['units'] = ['units', 'required'];
        $rules['status'] = ['status', 'required'];
        return $rules;
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email'            => Yii::t('user', 'Email'),
            'username'         => Yii::t('user', 'Username'),
            'new_password'     => Yii::t('user', 'New password'),
            'current_password' => Yii::t('user', 'Current password'),
            'phone_verification' => Yii::t('user', 'Phone Verification Code'),
            'location_verification' => Yii::t('user', 'Location Verification Code'),
            'language' => Yii::t('user', 'Language'),
            'currency' => Yii::t('user', 'Currency'),
            'units' => Yii::t('user', 'Units'),
            'status' => Yii::t('user', 'Status'),
        ];
    }

    /**
     * Saves new account settings.
     *
     * @return bool
     */
    public function save()
    {
        if ($this->validate()) {
            $this->user->scenario = 'settings';
            $this->user->username = $this->username;
            $this->user->password = $this->new_password;
            $this->user->language_id = $this->language;
            $this->user->currency_id = $this->currency;
            $this->user->units = $this->units;
            $this->user->status = $this->status;
            $this->verifyPhone();
            $this->verifyLocation();
            if ($this->email == $this->user->email && $this->user->unconfirmed_email != null) {
                $this->user->unconfirmed_email = null;
            } elseif ($this->email != $this->user->email) {
                switch ($this->module->emailChangeStrategy) {
                    case Module::STRATEGY_INSECURE:
                        $this->insecureEmailChange();
                        break;
                    case Module::STRATEGY_DEFAULT:
                        $this->defaultEmailChange();
                        break;
                    case Module::STRATEGY_SECURE:
                        $this->secureEmailChange();
                        break;
                    default:
                        throw new \OutOfBoundsException('Invalid email changing strategy');
                }
            }

            return $this->user->save();
        }

        return false;
    }

    protected function verifyPhone()
    {
        if(!$this->user->isPhoneVerified){
            if ($this->user->phone_verification_key == $this->phone_verification){            
                $this->user->phone_verification_key = null;
                $this->user->phone_verification_time = time();
                $this->trigger(self::EVENT_AFTER_PHONE_VERIFICATION);
            } else if($this->phone_verification!=null) {
                Yii::$app->session->setFlash('danger', Yii::t('user', 'Phone Verification Code you entered is not valid.'));
            }
        } 
    }

    protected function verifyLocation()
    {
        if(!$this->user->isLocationVerified){
            if ($this->user->location_verification_key == $this->location_verification){
                $this->user->location_verification_key = null;
                $this->user->location_verification_time = time();
                $this->trigger(self::EVENT_AFTER_LOCATION_VERIFICATION);
            } else if($this->location_verification!=null) {
                Yii::$app->session->setFlash('danger', Yii::t('user', 'Location Verification Code you entered is not valid.'));
            } 
        }
                   
    }

    public function afterPhoneVerification($event){        
        $log = new Log;
        $log->logEvent(155);
    }

    public function afterLocationVerification($event){        
        $log = new Log;
        $log->logEvent(156);
    }
}
