<?php

namespace backend\controllers;

use Yii;
use common\models\CcProviders;
use common\models\CcProvidersSearch;
use common\models\Translations;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

/**
 * ProvidersController implements the CRUD actions for CcIndustries model.
 */
class ProvidersController extends Controller
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
     * Lists all CcIndustries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CcProvidersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CcIndustries model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $query = \common\models\CcProviderProperties::find()->where(['provider_id' => $id]);
        $industries = \common\models\CcIndustryProviders::find()->where(['provider_id' => $id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'properties' => new ActiveDataProvider([
                'query' => $query,
            ]),
            'industries' => new ActiveDataProvider([
                'query' => $industries,
            ]),
        ]);
    }

    /**
     * Creates a new CcIndustries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CcProviders();
        $trans = new Translations();

        if ($model->load(Yii::$app->request->post()) and $trans->load(Yii::$app->request->post())) {
           
            if($model->save()){
                if ($model->imageFile) {
                    $model->upload();
                }
                $trans->entity = 'provider';
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
     * Updates an existing CcIndustries model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $trans = $model->translation ? $model->translation : new Translations();

        if ($model->load(Yii::$app->request->post()) and $trans->load(Yii::$app->request->post())) {
            
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            $model->save();

            if ($model->imageFile and $image = $model->upload()) {
                $model->file_id = $image->id;
            }
            $trans->entity = 'provider';
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
     * Deletes an existing CcIndustries model.
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
}
