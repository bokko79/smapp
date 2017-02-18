<?php

namespace backend\controllers;

use Yii;
use common\models\CcProcesses;
use common\models\CcProcessesSearch;
use common\models\Translations;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * ProcessesController implements the CRUD actions for CcProcesses model.
 */
class ProcessesController extends Controller
{
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
     * Lists all CcProcesses models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CcProcessesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CcProcesses model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $tasks = \common\models\CcProcessTasks::find()->where(['process_id' => $id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'tasks' => new ActiveDataProvider([
                'query' => $tasks,
            ]),
        ]);
    }

    /**
     * Creates a new CcProcesses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CcProcesses();
        $trans = new Translations();

        if ($model->load(Yii::$app->request->post()) && $model->save() and $trans->load(Yii::$app->request->post())) {
            $trans->entity = 'process';
            $trans->entity_id = $model->id;
            $trans->lang_code = 'SR';
            $trans->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_trans' => $trans,
            ]);
        }
    }

    /**
     * Updates an existing CcProcesses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $trans = $model->translation ? $model->translation : new Translations();

        if ($model->load(Yii::$app->request->post()) && $model->save() and $trans->load(Yii::$app->request->post())) {
            $trans->entity = 'process';
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
     * Deletes an existing CcProcesses model.
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
     * Finds the CcProcesses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CcProcesses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CcProcesses::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
