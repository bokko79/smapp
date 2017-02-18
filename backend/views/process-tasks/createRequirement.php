<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\checkbox\CheckboxX;


/* @var $this yii\web\View */
/* @var $model common\models\CcProcessTasks */

$this->title = 'Create Process Tasks';
$this->params['breadcrumbs'][] = ['label' => 'Process Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cc-process-tasks-create">

    <h1><?= Html::encode($this->title) ?></h1>

<?php $form = kartik\widgets\ActiveForm::begin([
    'id' => 'form-horizontal',
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'fullSpan' => 7,      
    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_MEDIUM],
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>


	<?= $form->field($model, 'process_task_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\CcProcessTasks::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false,           
        ]) ?> 

    <?= $form->field($model, 'required_task')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\CcProcessTasks::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Izaberite...'],
            'language' => 'sr-Latn',
            'changeOnReset' => false,           
        ]) ?> 

    <?= $form->field($model, 'priority')->widget(CheckboxX::classname(), ['pluginOptions'=>['size'=>'sm']]) ?>

    <div class="row" style="margin:20px;">
        <div class="col-md-offset-3">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>        
    </div>

<?php ActiveForm::end(); ?>

</div>