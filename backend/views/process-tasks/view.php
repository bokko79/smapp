<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\CcProcessTasks */

$this->title = c($model->process->name).': '.$model->task_number.'. '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Process Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cc-process-tasks-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'process.name',
            'type',
            'task_id',
            'task_number',
            'name',
            'description',
        ],
    ]) ?>

<h4>Requirements</h4>
<div class="primary-context gray normal">
    <div class="subhead"><?= Html::a('New Requirement', ['/process-tasks/create-requirement', 'CcProcessTaskRequirements[process_task_id]' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?></div>
</div>
<div class="secondary-context">
    <?= GridView::widget([
        'dataProvider' => $requirements,
        'columns' => [
            'id',
            [
                'label'=>'Required Process Task to be Completed',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->requiredTask->name, ['process-tasks/view', 'id' => $data->required_task]);
                },
            ],
            'priority',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return \Yii::$app->user->can('manageCoreDatabase') ? Html::a('Update', ['/object-properties/update', 'id' => $model->id], ['class' => '']) : '';
                    },
                ],                        
            ],
        ],
    ]); ?>
</div>

</div>
