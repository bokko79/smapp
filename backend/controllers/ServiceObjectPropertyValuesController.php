<?php

namespace backend\controllers;

use Yii;
use common\models\CcServiceObjectPropertyValues;
use common\models\CcServiceObjectPropertyValuesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * ServiceObjectPropertyValuesController implements the CRUD actions for CcServiceObjectPropertyValues model.
 */
class ServiceObjectPropertyValuesController extends Controller
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
     * Lists all CcServiceObjectPropertyValues models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CcServiceObjectPropertyValuesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CcServiceObjectPropertyValues model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CcServiceObjectPropertyValues model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CcServiceObjectPropertyValues();

        if($objectPropertyValue = Yii::$app->request->get('CcServiceObjectPropertyValues')){
            $model->service_object_property_id = !empty($objectPropertyValue['service_object_property_id']) ? $objectPropertyValue['service_object_property_id'] : null;
            $serviceObjectProperty = \common\models\CcServiceObjectProperties::findOne($model->service_object_property_id);
            $model->object_property_value_id = !empty($objectPropertyValue['object_property_value_id']) ? $objectPropertyValue['object_property_value_id'] : null;
            $objectProperty = \common\models\CcObjectProperties::find()->where(['id'=>$serviceObjectProperty->object_property_id])->one();
            $objectPropertyValues = \common\models\CcObjectPropertyValues::find()->joinWith('object')->where(['object_property_id'=>$objectProperty->id]);
            if($serviceObjectPropertyValues = $serviceObjectProperty->serviceObjectPropertyValues){
                foreach($serviceObjectPropertyValues as $serviceObjectPropertyValue){
                    $objectPropertyValues->andWhere(['<>','cc_object_property_values.id', $serviceObjectPropertyValue->object_property_value_id]);
                }
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'objectProperty' => $objectProperty,
                'objectPropertyValues' => $objectPropertyValues->all(),
            ]);
        }
    }

    /**
     * Updates an existing CcServiceObjectPropertyValues model.
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
     * Deletes an existing CcServiceObjectPropertyValues model.
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
     * Finds the CcServiceObjectPropertyValues model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CcServiceObjectPropertyValues the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CcServiceObjectPropertyValues::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
