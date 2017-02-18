<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CcProviderServices */

$this->title = 'Update Cc Provider Services: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cc Provider Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cc-provider-services-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
