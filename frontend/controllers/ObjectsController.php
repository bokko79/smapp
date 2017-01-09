<?php

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

/**
 * ObjectsController implements the CRUD actions for CcObjects model.
 */
class ObjectsController extends Controller
{
    //public $layout = '/admin';
    
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
     * Displays a single CcObjects model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $query = \common\models\CcObjectProperties::find()->where(['object_id' => $model->id]);
            
        if($model->getPath($model)){
            foreach ($model->getPath($model) as $key => $objectpp) {
                if($objectPropertiespp = $objectpp->objectProperties){
                    foreach($objectPropertiespp as $objectPropertypp){
                        if($objectPropertypp->property_class!='private'){
                            $query->orWhere(['object_id' => $objectpp->id]);
                        }
                    }
                }              
            }
        }

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
            /*'methods' => new ActiveDataProvider([
                'query' => \common\models\CcServices::find()->where(['object_id' => $model->id]),
            ]),*/
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
}
