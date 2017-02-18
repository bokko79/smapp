<?php

namespace backend\controllers;

use Yii;
use common\models\CcProcessTasks;
use common\models\CcProcessTasksSearch;
use common\models\Translations;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * ProcessPhasesController implements the CRUD actions for CcProcessPhases model.
 */
class ProcessTasksController extends Controller
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
     * Lists all CcProcessPhases models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CcProcessTasksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CcProcessPhases model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $requirements = \common\models\CcProcessTaskRequirements::find()->where(['process_task_id' => $id]);
        $files = \common\models\CcProcessTaskFiles::find()->where(['process_task_id' => $id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'requirements' => new ActiveDataProvider([
                'query' => $requirements,
            ]),
            'files' => new ActiveDataProvider([
                'query' => $files,
            ]),
        ]);
    }

    /**
     * Creates a new CcProcessTasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CcProcessTasks();
        $trans = new Translations();

        if($tasks = Yii::$app->request->get('CcProcessTasks')){
            $model->process_id = !empty($tasks['process_id']) ? $tasks['process_id'] : null;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save() and $trans->load(Yii::$app->request->post())) {
            $trans->entity = 'task';
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
     * Updates an existing CcProcessTasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $trans = $model->translation ? $model->translation : new Translations();

        if ($model->load(Yii::$app->request->post()) && $model->save() and $trans->load(Yii::$app->request->post())) {
            $trans->entity = 'task';
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
     * Creates a new CcProcessTaskRequirements model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateRequirement()
    {
        $model = new \common\models\CcProcessTaskRequirements();

        if($task = Yii::$app->request->get('CcProcessTaskRequirements')){
            $model->process_task_id = !empty($task['process_task_id']) ? $task['process_task_id'] : null;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->process_task_id]);
        } else {
            return $this->render('createRequirement', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CcProcessTasks model.
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
     * Finds the CcProcessTasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CcProcessTasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CcProcessTasks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
