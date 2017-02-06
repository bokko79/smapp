<?php

namespace backend\controllers;

use Yii;
use common\models\CcServiceObjectProperties;
use common\models\CcServiceObjectPropertiesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * ServiceObjectPropertiesController implements the CRUD actions for CcServiceObjectProperties model.
 */
class ServiceObjectPropertiesController extends Controller
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
     * Lists all CcServiceObjectProperties models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CcServiceObjectPropertiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CcServiceObjectProperties model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $query = \common\models\CcServiceObjectPropertyValues::find()->where(['service_object_property_id' => $id]);

        return $this->render('view', [
            'model' => $model,
            'propertyValues' => new ActiveDataProvider([
                'query' => $query,
            ]),
        ]);
    }

    /**
     * Creates a new CcServiceObjectProperties model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CcServiceObjectProperties();

        if($objectProperties = Yii::$app->request->get('CcServiceObjectProperties')){
            $model->service_id = !empty($objectProperties['service_id']) ? $objectProperties['service_id'] : null;
            $model->object_property_id = !empty($objectProperties['object_property_id']) ? $objectProperties['object_property_id'] : null;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CcServiceObjectProperties model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CcServiceObjectProperties model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CcServiceObjectProperties model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CcServiceObjectProperties the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CcServiceObjectProperties::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Lists all ProviderServices models.
     * @return mixed
     */
    public function actionModal($id=null)
    {
        if($id){
            if($serviceObjectProperty = $this->findModel($id)) {
                return $this->renderAjax('//services/_service_object_property_values', [
                    'model' => $serviceObjectProperty,
                    'object' => $serviceObjectProperty->objectProperty->object,
                ]);
            }
        }
        return;            
    }
}
