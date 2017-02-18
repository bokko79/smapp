<?php

namespace backend\controllers;

use Yii;
use common\models\CcServices;
use common\models\CcServicesSearch;
use common\models\CcServiceQuantities;
use common\models\Translations;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

/**
 * ServicesController implements the CRUD actions for CcServices model.
 */
class ServicesController extends Controller
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
     * Lists all CcServices models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CcServicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CcServices model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $object = $model->object;
        $query = \common\models\CcServiceObjectProperties::find()->where(['service_id' => $id]);

        return $this->render('view', [
            'model' => $model,
            'properties' => new ActiveDataProvider([
                'query' => $query,
            ]),
        ]);
    }

    /**
     * Creates a new CcServices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CcServices();
        $modelQuantities = new CcServiceQuantities();
        $trans = new Translations();

        if($services = Yii::$app->request->get('CcServices')){
            $model->object_id = !empty($services['object_id']) ? $services['object_id'] : null;
        }

        if ($model->load(Yii::$app->request->post()) and $model->save() and $trans->load(Yii::$app->request->post())) {
           /* $modelQuantities->service_id = $model->id;
            $modelQuantities->save();*/

            $trans->entity = 'service';
            $trans->entity_id = $model->id;
            $trans->lang_code = 'SR';
            $trans->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelQuantities' => $modelQuantities,
                'trans' => $trans,
            ]);
        }
    }

    /**
     * Updates an existing CcServices model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelQuantities = $model->quantities ? $model->quantities : new CcServiceQuantities();
        $trans = $model->translation ? $model->translation : new Translations();

        if ($model->load(Yii::$app->request->post()) && $model->save() and $trans->load(Yii::$app->request->post())) {
            /*$modelQuantities->service_id = $model->id;
            $modelQuantities->save();*/

            $trans->entity = 'service';
            $trans->entity_id = $model->id;
            $trans->lang_code = 'SR';
            $trans->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelQuantities' => $modelQuantities,
                'trans' => $trans,
            ]);
        }
    }

    /**
     * Deletes an existing CcServices model.
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
}
