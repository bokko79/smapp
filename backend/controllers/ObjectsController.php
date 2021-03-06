<?php

namespace backend\controllers;

use Yii;
use common\models\CcObjects;
use common\models\CcObjectsSearch;
use common\models\Translations;
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
     * Lists all CcObjects models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new CcObjects();
        $searchModel = new CcObjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single CcObjects model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $query = \common\models\CcObjectProperties::find()->where(['object_id' => $id]);
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
        ]);
    }

    /**
     * Creates a new CcObjects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CcObjects();
        $trans = new Translations();

        if($objects = Yii::$app->request->get('CcObjects')){
            $model->object_id = !empty($objects['object_id']) ? $objects['object_id'] : null;
        }

        if ($model->load(Yii::$app->request->post()) and $trans->load(Yii::$app->request->post())) {
            $parent = $this->findModel($model->object_id);
            $model->level = $parent->level + 1;
            if($model->save()){
                if ($model->imageFile) {
                    $model->upload();
                }
                $trans->entity = 'object';
                $trans->entity_id = $model->id;
                $trans->lang_code = 'SR';
                $trans->save();
                return $this->redirect(['view', 'id' => $model->id]);  
            }            
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_trans' => $trans,
            ]);
        }
    }

    /**
     * Updates an existing CcObjects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $trans = $model->translation ? $model->translation : new Translations();

        if ($model->load(Yii::$app->request->post()) and $trans->load(Yii::$app->request->post())) {

            $parent = $this->findModel($model->object_id);
            $model->level = $parent->level + 1;

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->save();

            if ($model->imageFile and $image = $model->upload()) {
                $model->file_id = $image->id;
            }

            $trans->entity = 'object';
            $trans->entity_id = $model->id;
            $trans->lang_code = 'SR';
            $trans->save();
            return $this->redirect(['view', 'id' => $model->id]);  
                
        } else {
            return $this->render('update', [
                'model' => $model,
                'model_trans' => $trans,
            ]);
        }
    }

    /**
     * Deletes an existing CcObjects model.
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
