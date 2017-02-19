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
use common\models\CcServices;
use common\models\CcServicesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Log;

/**
 * ServicesController implements the CRUD actions for CcServices model.
 */
class ServicesController extends Controller
{
    //public $layout = '/admin';

    /**
     * Event is triggered after changing users' email address.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_VISIT = 'afterVisit';

    // event init
    public function init()
    {
        //$bookmark = new BookmarksController();
        $this->on(self::EVENT_AFTER_VISIT, [$this, 'afterVisit']);
        $this->on(BookmarksController::EVENT_SERVICE_BOOKMARKED, [
            '\frontend\controllers\BookmarksController', 'serviceBookmark']);
        $this->on(BookmarksController::EVENT_SERVICE_UNBOOKMARKED, ['\frontend\controllers\BookmarksController', 'serviceUnbookmark']);
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * D02 - Service's home page.
     *
     * Displays a single CcServices model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->trigger(self::EVENT_AFTER_VISIT, new yii\base\Event(['sender' => $id]));
        $model = $this->findModel($id);
        
        if(!Yii::$app->user->isGuest and $model->isBookmarked(Yii::$app->user->id)){            
            $bookmark = \common\models\UserServices::find()->where(['service_id'=>$id, 'user_id'=>Yii::$app->user->id])->one();
        } else {
            $bookmark = new \common\models\UserServices;
        }
        $this->bookmarkingService($model, $bookmark);

        $searchModel = new CcServicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'bookmark' => $bookmark,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the CcServices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CcServices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CcServices::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public static function bookmarkingService($model, $bookmark)
    {        
        if ($bookmark->load(Yii::$app->request->post())) {
            $bookmark->user_id = Yii::$app->user->id;
            $bookmark->status = $model->isActiveBookmark(Yii::$app->user->id) ? 0 : 1;
            if($bookmark->save()){
                if(!$model->isActiveBookmark(Yii::$app->user->id)){
                    $this->trigger(BookmarksController::EVENT_SERVICE_BOOKMARKED, new yii\base\Event(['sender' => $model->id]));
                } else {
                    $this->trigger(BookmarksController::EVENT_SERVICE_UNBOOKMARKED, new yii\base\Event(['sender' => $model->id]));
                }                
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    }

    public function afterVisit($event)
    {        
        $log = new Log;
        $log->subject_id = $event->sender;
        $log->logEvent(43);
    }
}
