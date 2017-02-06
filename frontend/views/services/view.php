<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CsServices */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Services'];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = kartik\widgets\ActiveForm::begin([
        'id' => 'form-horizontal',
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]); ?>
        <?= yii\helpers\Html::activeHiddenInput($bookmark, 'service_id', ['value'=>$model->id]) ?>
        <div class="row" style="margin:20px;">
            <div class="col-md-offset-3">
                <?= Html::submitButton(!$model->isActiveBookmark(Yii::$app->user->id) ? 'Bookmark' : 'Unbookmark', ['class' => !$model->isActiveBookmark(Yii::$app->user->id) ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>        
        </div>

    <?php ActiveForm::end(); ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'industry.name',
            'action.name',
            'object.name',
            'unit.sign',
            'file.name',
            'name',
            'service_type',
            'object_class',
            'object_ownership',
            'file',
            'amount',
            'consumer',
            'consumer_children',
            'location',
            'coverage',
            'shipping',
            'geospecific',
            'time:datetime',
            'duration',
            'frequency',
            'availability',
            'installation',
            'tools',
            'turn_key',
            'support',
            'ordering',
            'pricing',
            'terms',
            'labour_type',
            'process',
            'dat',
            'status',
            'hit_counter',
        ],
    ]) ?>