<?php

namespace backend\controllers;

use Yii;
use common\models\CcObjectProperties;
use common\models\CcObjectPropertiesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * ObjectPropertiesController implements the CRUD actions for CcObjectProperties model.
 */
class ObjectPropertiesController extends Controller
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
     * Lists all CcObjectProperties models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CcObjectPropertiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CcObjectProperties model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $object = $model->object;
        $query = \common\models\CcObjectPropertyValues::find()->where(['object_property_id' => 0]);

        if($values = $model->getAllValues()){
            foreach($values as $value){
                $query->orWhere(['id' => $value->id]);
            }           
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'propertyValues' => new ActiveDataProvider([
                'query' => $query/*->orderBy('value_type')->groupBy('id')*/,
            ]),
        ]);
    }

    /**
     * Creates a new CcObjectProperties model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CcObjectProperties();
        if($objectProperties = Yii::$app->request->get('CcObjectProperties')){
            $model->object_id = !empty($objectProperties['object_id']) ? $objectProperties['object_id'] : null;
            $model->property_id = !empty($objectProperties['property_id']) ? $objectProperties['property_id'] : null;
            $model->unit_id = !empty($objectProperties['unit_id']) ? $objectProperties['unit_id'] : null;
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
     * Updates an existing CcObjectProperties model.
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
     * Deletes an existing CcObjectProperties model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($objectPropertyValues = $model->objectPropertyValues){
            foreach ($objectPropertyValues as $key => $objectPropertyValue) {
                $objectPropertyValue->delete();
            }
        }
        $model->delete();

        return $this->redirect(['/objects/view', ['id'=>$model->object_id]]);
    }

    /**
     * Finds the CcObjectProperties model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CcObjectProperties the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CcObjectProperties::findOne($id)) !== null) {
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
        if($id and $objectProperty = $this->findModel($id)){            
            return $this->renderAjax('//objects/_object_property_values', [
                'model' => $objectProperty,
                'object' => $objectProperty->object,
            ]);            
        }
        return;            
    }

    /**
     * Creates a new CcObjects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionParents($id, $parentId)
    {
        $newmodel = new CcObjectProperties();

        if($object = \common\models\CcObjects::findOne($id) and $objectProperty = $this->findModel($parentId)){
            $newmodel->attributes = $objectProperty->attributes;
            $newmodel->object_id = $object->id;
            $newmodel->save();

            if($objectProperty->objectPropertyValues){
                foreach($objectProperty->objectPropertyValues as $objectPropertyValue){
                    $newModelValue = new \common\models\CcObjectPropertyValues();
                    $newModelValue->attributes = $objectPropertyValue->attributes;
                    $newModelValue->object_property_id = $newmodel->id;
                    $newModelValue->save();
                }
            }
        }
            
        return $this->redirect(['/objects/view', 'id'=>$id]);
    }
}
