<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\Session;
$session = Yii::$app->session;
?>
<div class="card_container record-full transparent no-shadow fadeInUp animated" id="card_container" style="">
<?php //foreach ($queryActions as $queryAction): ?>
    <div class="primary-context overflow-hidden low-margin">
    	<div class="avatar center">
    		<i class="fa fa-flag fa-2x"></i>
    	</div>
    	<div class="title">
    		<div class="head third regular"><?= Html::a(c($model->name), ['/autoindex/'], ['data'=>['method'=>'post', 'params'=>['CcServicesSearch[action_id]'=>$model->id]]]) ?></div>
    		<div class="subhead"></div>
    	</div>	    	   
    </div>	
<?php //endforeach; ?>
</div>