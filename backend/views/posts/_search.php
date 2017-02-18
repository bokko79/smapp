<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PostsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'profile_id') ?>

    <?= $form->field($model, 'file_id') ?>

    <?= $form->field($model, 'parent_id') ?>

    <?= $form->field($model, 'lang_code') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'subtitle') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'excerpt') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'comment_status') ?>

    <?php // echo $form->field($model, 'next_post') ?>

    <?php // echo $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
