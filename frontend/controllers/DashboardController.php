<?php

/*
 * This file is part of the Servicemapp project.
 *
 * (c) Dektrium project <http://github.com/servicemapp/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace frontend\controllers;

use Yii;
use dektrium\user\models\Account;
use dektrium\user\models\User;
use dektrium\user\Module;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use common\models\Log;
use yii\web\NotFoundHttpException;

/**
 * Controller that manages user authentication process.
 *
 * @property Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class DashboardController extends Controller
{
    const EVENT_CONTACT_US = 'afterContactUs';

    // event init
    public function init()
    {
        $this->on(self::EVENT_CONTACT_US, [$this, 'afterContactUs']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['home'],
                'rules' => [
                    [
                        'actions' => ['home'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
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
}
