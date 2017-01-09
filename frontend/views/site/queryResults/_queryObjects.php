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

    <?php
	//foreach ($queryObjects as $queryObject): ?>    		

		    <div class="primary-context overflow-hidden low-margin">
		    	<div class="avatar">
		    		<i class="fa fa-cube fa-3x"></i>
		    	</div>
		    	<div class="title">
		    		<div class="head third regular"><?= Html::a(c($model->name), ['/auto/index/'], ['data'=>['method'=>'post', 'params'=>['CcServicesSearch[object_id]'=>$model->id]]]) ?></div>
		    	</div>
		    	   
		    </div>
	
<?php 
	//endforeach; ?>

</div>