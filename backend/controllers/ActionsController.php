<?php

namespace backend\controllers;

use Yii;
use common\models\CcActions;
use common\models\CcActionsTranslation;
use common\models\CcActionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * ActionsController implements the CRUD actions for CcActions model.
 */
class ActionsController extends Controller
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
     * Lists all CcActions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CcActionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CcActions model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
            'properties' => new ActiveDataProvider([
                'query' => \common\models\CcActionProperties::find()->where(['action_id' => $model->id])->groupBy('id'),
            ]),
        ]);
    }

    /**
     * Creates a new CcActions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CcActions();
        //$model_trans = new CcActionsTranslation();

        if ($model->load(Yii::$app->request->post())/* and $model_trans->load(Yii::$app->request->post())*/) {
            if($model->save()){
                /*$model_trans->action_id = $model->id;
                $model_trans->orig_name = $model->name;
                $model_trans->save();*/
                
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                //'model_trans' => $model_trans,
            ]);
        }
    }

    /**
     * Updates an existing CcActions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$model_trans = $model->translation;

        if ($model->load(Yii::$app->request->post())/* and $model_trans->load(Yii::$app->request->post())*/) {
            
            $model->save();
            /*$model_trans->save();*/

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                //'model_trans' => $model_trans,
            ]);
        }
    }

    /**
     * Deletes an existing CcActions model.
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
     * Finds the CcActions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CcActions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CcActions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
