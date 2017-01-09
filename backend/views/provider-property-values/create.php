<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CsIndustryPropertyValues */

$this->title = Yii::t('app', 'Create New Provider Property Values');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cs Provider Property Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= Html::encode($this->title) ?></h2>
<p>
    <?= Html::a('New Provider Property', ['/provider-properties/create'], ['class' => 'btn btn-warning']) ?>
    <?= Html::a('New Property Value', ['/property-values/create'], ['class' => 'btn btn-danger']) ?>
</p>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
