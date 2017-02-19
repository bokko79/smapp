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

use Yii;
use dektrium\user\Finder;
use dektrium\user\models\Account;
use common\models\LoginForm;
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

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['login', 'auth'], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['login', 'auth', 'logout', 'home'], 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays the login page.
     * B01 - Login
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            $this->goHome();
        }

        /** @var LoginForm $model */
        $model = \Yii::createObject(LoginForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);
            return $this->goBack();
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }

    /**
     * C01 - Dashboard Home Page.
     *
     * Displays a single User model and its Dashboard.
     * @param string $id
     * @return mixed
     */
    public function actionHome($username=null)
    {
        $this->layout = '//dashboard';

        if(isset($username)) {
            $model = $this->findModelByUsername($username);

            if($model and !Yii::$app->user->isGuest and $model->id==Yii::$app->user->id) {

                return $this->render('home', [
                    'model' => $model,
                    'profiles' => $model->profiles,
                    'bookmarks' => $model->bookmarkedServices, 
                    'activities' => $model->activities,
                ]);
            } else {
                return $this->redirect('site/home');
            } 
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }           
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelByUsername($username)
    {
        if (($model = \common\models\UserAccount::find()->where('username=:username', [':username'=>$username])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
