<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CsServicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Services';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h2><?= Html::encode($this->title) ?></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create New Service', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            'unit.sign',
            'id',
            'industry.name',
            'action.name',
            'object.name',
            'unit_id',
            // 'file_id',
            // 'name',
            // 'service_type',
            // 'object_class',
            // 'object_ownership',
            // 'file',
            // 'amount',
            // 'consumer',
            // 'consumer_children',
            // 'location',
            // 'coverage',
            // 'shipping',
            // 'geospecific',
            // 'time:datetime',
            // 'duration',
            // 'frequency',
            // 'availability',
            // 'installation',
            // 'tools',
            // 'turn_key',
            // 'support',
            // 'ordering',
            // 'pricing',
            // 'terms',
            // 'labour_type',
            // 'process',
            // 'dat',
            // 'status',
            // 'hit_counter',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>

