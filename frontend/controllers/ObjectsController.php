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
use common\models\CcObjects;
use common\models\CcObjectsSearch;
use common\models\CcObjectsTranslation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use common\models\Log;

/**
 * ObjectsController implements the CRUD actions for CcObjects model.
 */
class ObjectsController extends Controller
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
     * D03 - Object's home page.
     *
     * Displays a single CcObjects model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $query = \common\models\CcObjectProperties::find()->where(['object_id' => $model->id]);
        $services = \common\models\CcServices::find()->where(['object_id' => $model->id]);
        /*echo '<pre>';
            print_r($model->getProperties());
            die;*/
        foreach($model->getProperties() as $inheritedObjectProperty){
            $query->orWhere(['id' => $inheritedObjectProperty->id]);
        }

        foreach($model->getAllActions() as $action){
            $services->orWhere(['id' => $action->id]);
        }
        if ($molds = $model->molds){
            foreach($molds as $mold){
                foreach($mold->getAllActions() as $action){
                    $services->orWhere(['id' => $action->id]);
                }
            }
        }

        $searchModel = new CcObjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->trigger(self::EVENT_AFTER_VISIT, new yii\base\Event(['sender' => $id]));

        return $this->render('view', [
            'model' => $model,
            /*'products' => new ActiveDataProvider([
                'query' => \common\models\CcProducts::find()->where(['object_id' => $model->id]),
            ]),
            'issues' => new ActiveDataProvider([
                'query' => \common\models\CcObjectIssues::find()->where(['object_id' => $model->id]),
            ]),*/
            'properties' => new ActiveDataProvider([
                'query' => $query->orderBy('property_type')->groupBy('id'),
            ]),
            'services' => new ActiveDataProvider([
                'query' => $services,
            ]),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the CcObjects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CcObjects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CcObjects::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function afterVisit($event){        
        $log = new Log;
        $log->subject_id = $event->sender;
        $log->logEvent(54);
    }
}
