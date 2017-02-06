<?php

namespace backend\controllers;

use Yii;
use common\models\CcIndustries;
use common\models\CcIndustriesSearch;
use common\models\CcIndustriesTranslation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

/**
 * IndustriesController implements the CRUD actions for CcIndustries model.
 */
class IndustriesController extends Controller
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
        $searchModel = new CcIndustriesSearch();
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
        $model = $this->findModel($id);
        $query = \common\models\CcObjectProperties::find()->where(['object_id' => $id]);

        return $this->render('view', [
            'model' => $model,
            'services' => new ActiveDataProvider([
                'query' => \common\models\CcServices::find()->where(['industry_id' => $model->id]),
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
        $model = new CcIndustries();
        //$model_trans = new CcIndustriesTranslation();

        if ($model->load(Yii::$app->request->post())/* and $model_trans->load(Yii::$app->request->post())*/) {
           
            if($model->save()){
                if ($model->imageFile) {
                    $model->upload();
                }
                /*$model_trans->industry_id = $model->id;
                $model_trans->orig_name = $model->name;
                $model_trans->save();*/

                    return $this->redirect(['view', 'id' => $model->id]);
                //}
            }            
        } else {
            return $this->render('create', [
                'model' => $model,
                //'model_trans' => $model_trans,
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
        //$model_trans = $model->translation;

        if ($model->load(Yii::$app->request->post())/* and $model_trans->load(Yii::$app->request->post())*/) {
            
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            $model->save();

            if ($model->imageFile and $image = $model->upload()) {
                $model->file_id = $image->id;
            }
            //$model_trans->save();

            return $this->redirect(['view', 'id' => $model->id]);
                
        } else {
            return $this->render('update', [
                'model' => $model,
                //'model_trans' => $model_trans,
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
        if (($model = CcIndustries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
