<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace frontend\controllers;

use dektrium\user\Finder;
use dektrium\user\models\Account;
use dektrium\user\models\LoginForm;
use dektrium\user\models\User;
use dektrium\user\Module;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use dektrium\user\controllers\SecurityController as SecController;
use yii\web\Response;
use common\models\Log;

/**
 * Controller that manages user authentication process.
 *
 * @property Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class SecurityController extends SecController
{
    /**
     * Event is triggered after logging user in.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_AFTER_LOGIN = 'afterLogin';

    // event init
    public function init()
    {
          $this->on(self::EVENT_AFTER_LOGIN, [$this, 'updateLoginData']);
          $this->on(self::EVENT_AFTER_LOGIN, [$this, 'afterLogin']);
    }

    public function updateLoginData($event){
        $user = User::findOne(\Yii::$app->user->id);
        $user->login_ip = \Yii::$app->request->userIP;
        $user->login_time = time();
        $user->login_count = $user->login_count+1;
        $user->save();
    }

    public function afterLogin($event){
        $log = new Log;
        $log->logEvent(2);
    }
}