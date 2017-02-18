<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CcProviderServices */

$this->title = 'Create Cc Provider Services';
$this->params['breadcrumbs'][] = ['label' => 'Cc Provider Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cc-provider-services-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
