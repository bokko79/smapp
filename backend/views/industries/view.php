<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\CsIndustries */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Industries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= c(Html::encode($this->title)) ?> <small>status: <?= $model->status ?></small></h2>

<p>
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
    <?= Html::a('Create New Industry Provider', ['/industry-providers/create', 'CcIndustries[industry_id]'=>$model->id], ['class' => 'btn btn-info']) ?>
</p>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'parent.name',
        'nameGen',
        'nameDat',
        'nameAkk',
        'nameInst',
        'description',
        'type',
        'file_id',
        'status',
        'hit_counter',
    ],
]) ?>

<h4>Providers</h4>
<?php foreach($model->industryProviders as $industryProvider){
    echo Html::a($industryProvider->provider->name, ['providers/view', 'id' => $industryProvider->provider_id]) . '<br>';
} ?>

<h4>Services</h4>
<?= GridView::widget([
    'dataProvider' => $services,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],

        [
            'label'=>'ID',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data->id, ['services/view', 'id' => $data->id]);
            },
        ],
        'name',
        [
            'label'=>'Industry',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data->industry->name, ['industries/view', 'id' => $data->industry_id]);
            },
        ],
        [
            'label'=>'Action',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data->action->name, ['actions/view', 'id' => $data->action_id]);
            },
        ],
        [
            'label'=>'Object',
            'format' => 'raw',
            'value'=>function ($data) {
                return $data->object ? Html::a($data->object->name, ['objects/view', 'id' => $data->object_id]) : null;
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{delete}',                                  
        ],
    ],
]); ?>
