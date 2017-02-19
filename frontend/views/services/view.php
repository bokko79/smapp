<?php

/*
 * D02 - Service's profile (home) page.
 *
 * This file is part of the Servicemapp project.
 *
 * (c) Servicemapp project <http://github.com/bokko79/servicemapp/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ListView;
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

<div class="container">
    <div class="row">
        <div class="col-lg-8">
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
        </div>
        <div class="col-lg-4">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_card',
            ]) ?>
        </div>
    </div>
</div>