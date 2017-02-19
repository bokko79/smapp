<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="post">
    <?= Html::a($model->name, Url::to(['view', 'id'=>$model->id])) ?>    
</div>