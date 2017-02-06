<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="card_container record-full transparent no-shadow fadeInUp bottom-bordered animated" id="card_container" style="">
<?php
	//foreach ($queryIndustries as $queryIndustry): ?>
    <div class="primary-context overflow-hidden low-margin ">
    	<div class="avatar">
    		<?= Html::img('@web/images/cards/info/info_docs'.rand(0, 9).'.jpg', ['style'=>'']) ?>
    	</div>
    	<div class="title">
    		<div class="head third regular">
    			<?= Html::a(c($model->name), ['/autoindex/'], ['data'=>['method'=>'post', 'params'=>['CcServicesSearch[industry_id]'=>$model->id]]]) ?>
    			<span class="fs_12 muted"><i class="fa fa-globe"></i> <?= $model->countServices ?></span>
    			<span class="fs_12 muted"><i class="fa fa-user"></i> <?= count($model->providers) ?></span>
    		</div>	    			    		
    	</div>	    	
    </div>
    <div class="secondary-context avatar-padded col-md-7 cont">
    	<p>Neki tekst ide ovde</p>
    </div>
<?php 
	//endforeach; ?>
</div>