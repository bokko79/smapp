<?php

namespace frontend\controllers;

use Yii;
use common\models\CcProviders;
use common\models\CcProvidersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Log;

/**
 * ProvidersController implements the CRUD actions for CcIndustries model.
 */
class ProvidersController extends Controller
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
        $this->on(self::EVENT_AFTER_VISIT, [$this, 'afterVisit']);
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
     * Displays a single CcIndustries model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->trigger(self::EVENT_AFTER_VISIT, new yii\base\Event(['sender' => $id]));

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the CcIndustries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CcIndustries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CcProviders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function afterVisit($event){        
        $log = new Log;
        $log->subject_id = $event->sender;
        $log->logEvent(70);
    }
}
