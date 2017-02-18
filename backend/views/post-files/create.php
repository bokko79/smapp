<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PostFiles */

$this->title = 'Create Post Files';
$this->params['breadcrumbs'][] = ['label' => 'Post Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-files-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
