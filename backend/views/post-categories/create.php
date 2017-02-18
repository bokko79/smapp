<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PostCategories */

$this->title = 'Create Post Categories';
$this->params['breadcrumbs'][] = ['label' => 'Post Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-categories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
