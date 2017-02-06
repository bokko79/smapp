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
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\Log;

/**
 * Controller that manages user authentication process.
 *
 * @property Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class BookmarksController extends Controller
{
    const EVENT_SERVICE_BOOKMARKED = 'serviceBookmark';

    const EVENT_SERVICE_UNBOOKMARKED = 'serviceUnbookmark';

    // event init
    public function init()
    {
        $this->on(self::EVENT_SERVICE_BOOKMARKED, [$this, 'serviceBookmark']);
        $this->on(self::EVENT_SERVICE_UNBOOKMARKED, [$this, 'serviceUnbookmark']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['services'],
                'rules' => [
                    [
                        'actions' => ['services', 'objects', 'providers', 'listings'],
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
    public function actionServices($username=null)
    {
        $this->layout = '//dashboard';

        if(isset($username)) {
            $model = $this->findModelByUsername($username);

            if($model and !Yii::$app->user->isGuest and $model->id==Yii::$app->user->id) {

                if($bookmarks = $model->bookmarkedServices){
                    foreach($bookmarks as $bookmark){
                        \frontend\controllers\ServicesController::bookmarkingService($bookmark->service, $bookmark);
                    }
                } 
                return $this->render('services', [
                    'model' => $model,
                    'bookmarks' => $model->bookmarkedServices, 
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

    public function serviceBookmark($event){        
        $log = new Log;
        $log->subject_id = $event->sender;
        $log->logEvent(45);
    }

    public function serviceUnbookmark($event){        
        $log = new Log;
        $log->subject_id = $event->sender;
        $log->logEvent(46);
    }
}
