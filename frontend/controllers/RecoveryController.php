<?php

/*
 * This file is part of the Servicemapp project.
 *
 * (c) Servicemapp project <http://github.com/bokko79/servicemapp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace frontend\controllers;

use dektrium\user\Finder;
use dektrium\user\models\RecoveryForm;
use dektrium\user\models\Token;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use yii\filters\AccessControl;
use dektrium\user\controllers\RecoveryController as RecController;
use yii\web\NotFoundHttpException;
use common\models\Log;

/**
 * RecoveryController manages password recovery process.
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RecoveryController extends RecController
{
    /**
     * Event is triggered after logging user in.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_AFTER_LOGIN = 'afterLogin';

    // event init
    public function init()
    {
          $this->on(self::EVENT_AFTER_REQUEST, [$this, 'afterRequest']);
          $this->on(self::EVENT_AFTER_RESET, [$this, 'afterReset']);
          $this->on(self::EVENT_AFTER_LOGIN, ['\frontend\controllers\SecurityController', 'updateLoginData']);
          $this->on(self::EVENT_AFTER_LOGIN, ['\frontend\controllers\SecurityController', 'afterLogin']);
    }

    /**
     * Displays page where user can reset password.
     *
     * @param int    $id
     * @param string $code
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionReset($id, $code)
    {
        if (!$this->module->enablePasswordRecovery) {
            throw new NotFoundHttpException();
        }

        /** @var Token $token */
        $token = $this->finder->findToken(['user_id' => $id, 'code' => $code, 'type' => Token::TYPE_RECOVERY])->one();
        $event = $this->getResetPasswordEvent($token);

        $this->trigger(self::EVENT_BEFORE_TOKEN_VALIDATE, $event);

        if ($token === null || $token->isExpired || $token->user === null) {
            $this->trigger(self::EVENT_AFTER_TOKEN_VALIDATE, $event);
            \Yii::$app->session->setFlash(
                'danger',
                \Yii::t('user', 'Recovery link is invalid or expired. Please try requesting a new one.')
            );
            return $this->render('/message', [
                'title'  => \Yii::t('user', 'Invalid or expired link'),
                'module' => $this->module,
            ]);
        }

        /** @var RecoveryForm $model */
        $model = \Yii::createObject([
            'class'    => RecoveryForm::className(),
            'scenario' => RecoveryForm::SCENARIO_RESET,
        ]);
        $event->setForm($model);

        $this->performAjaxValidation($model);
        $this->trigger(self::EVENT_BEFORE_RESET, $event);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->resetPassword($token)) {
            $user = \dektrium\user\models\User::findOne($id);

            if ($user) {
                \Yii::$app->user->switchIdentity($user);
            }            
            $this->trigger(self::EVENT_AFTER_RESET, $event);
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);
            \Yii::$app->session->setFlash(
                'success',
                \Yii::t('user', 'Password reset successfully.')
            );
            /*return $this->render('/message', [
                'title'  => \Yii::t('user', 'Password has been changed'),
                'module' => $this->module,
            ]);*/
            \Yii::$app->response->redirect(\Yii::$app->user->returnUrl);
        }

        return $this->render('reset', [
            'model' => $model,
        ]);
    }

    public function afterRequest($event){
        $log = new Log;
        $log->logEvent(10);
    }

    public function afterReset($event){
        $log = new Log;
        $log->logEvent(182);
    }
}
