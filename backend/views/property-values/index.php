<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Property Values';
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= Html::encode($this->title) ?></h2>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<p>
    <?= Html::a('Create New Property Value', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute'=>'property',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->property->name, ['properties/view', 'id' => $data->property->id]);
                },
            ],
            [
                'attribute'=>'value',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->value, ['view', 'id' => $data->id]);
                },
            ],
            'value',            
            'selected_value',
            'hint',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
