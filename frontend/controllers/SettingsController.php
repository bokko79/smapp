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
use common\models\Profile;
use common\models\SettingsForm;
use common\models\UserAccount;
use dektrium\user\Module;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use dektrium\user\controllers\SettingsController as BaseSettingsController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use common\models\Log;


/**
 * SettingsController manages updating user settings (e.g. profile, email and password).
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class SettingsController extends BaseSettingsController
{
    /**
     * Event is triggered after updating user's account settings.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_AFTER_ACCOUNT_UPDATE = 'afterAccountUpdate';

    /**
     * Event is triggered after changing users' email address.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_CONFIRM = 'afterConfirm';

    // event init
    public function init()
    {
        $this->on(self::EVENT_AFTER_ACCOUNT_UPDATE, [$this, 'afterAccountUpdate']);
        $this->on(self::EVENT_AFTER_CONFIRM, [$this, 'afterConfirm']);
    }

    public function afterAccountUpdate($event){        
        $log = new Log;
        $log->logEvent(13);
    }

    public function afterConfirm($event){        
        $log = new Log;
        $log->logEvent(11);
    }    
}
