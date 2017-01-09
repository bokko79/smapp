<?php

namespace backend\controllers;

use Yii;
use common\models\CcProperties;
use common\models\CcPropertiesTranslation;
use common\models\CcPropertiesSearch;
use common\models\CcPropertyValues;
use common\models\CcObjectProperties;
use common\models\CcActionProperties;
use common\models\CcProviderProperties;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * PropertiesController implements the CRUD actions for CcProperties model.
 */
class PropertiesController extends Controller
{
    //public $layout = '/admin';
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['moderator'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CcProperties models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CcPropertiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CcProperties model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'propertyValues' => new ActiveDataProvider([
                'query' => CcPropertyValues::find()->filterWhere(['property_id' => $id]),
            ]),
            /*'industryProperties' => new ActiveDataProvider([
                'query' => CcIndustryProperties::find()->filterWhere(['property_id' => $id]),
            ]),
            'actionProperties' => new ActiveDataProvider([
                'query' => CcActionProperties::find()->filterWhere(['property_id' => $id]),
            ]),*/
            'objectProperties' => new ActiveDataProvider([
                'query' => CcObjectProperties::find()->filterWhere(['property_id' => $id]),
            ]),
        ]);
    }

    /**
     * Creates a new CcProperties model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CcProperties();
        //$model_trans = new CcPropertiesTranslation();

        if ($model->load(Yii::$app->request->post())/* and $model_trans->load(Yii::$app->request->post())*/ and $model->save()) {
            /*$model_trans->property_id = $model->id;
            $model_trans->lang_code = 'SR';
            $model_trans->orig_name = $model->name;
            if($model_trans->save()){*/
                return $this->redirect(['view', 'id' => $model->id]);
            /*}    */        
        } else {
            return $this->render('create', [
                'model' => $model,
                //'model_trans' => $model_trans,
            ]);
        }
    }

    /**
     * Updates an existing CcProperties model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$model_trans = $model->translation;

        if ($model->load(Yii::$app->request->post())/* and $model_trans->load(Yii::$app->request->post())*/ and $model->save()/* and $model_trans->save()*/) {
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                //'model_trans' => $model_trans,
            ]);
        }
    }

    /**
     * Deletes an existing CcProperties model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CcProperties model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CcProperties the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CcProperties::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
