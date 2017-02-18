<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\ActiveField;
use yii\helpers\ArrayHelper;

?>

<?= 'you are creating '. $type. ' profile'; ?><br>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">	
			<?php $form = kartik\widgets\ActiveForm::begin([
			    'id' => 'form-vertical',
			    'method' => 'get',
			    //'action' => '/add/'.slug($service->name),
			    'type' => ActiveForm::TYPE_VERTICAL,
			]); ?>
		
			<p class="hint">Možete izabrati više vrsta.</p>
			<div class="enclosedCheckboxes">
				<div class="checkbox"><label><input type="checkbox" id="ckbCheckAll"> <i>Izaberite/Poništite sve</i></label></div>
			<?php foreach($sectors as $sector){		
					echo '<h4>'.$sector->name.'</h4><ul class="disc">';
					foreach($sector->providers as $provider){
						if($provider->type==$type){
							echo '<li><b>'.$provider->name.'</b></li>';
							if($services = $provider->services){
								$ser = ArrayHelper::map($services, 'id', 'name');
								echo $form->field(new \common\models\CcServices, 'id[]')->checkboxList($ser, ['unselect'=>null, 'class'=>'column3 multiselect'])->label(false);
							}
						}		
					}
					echo '</ul>';
				} ?>				
			</div>	
			<div class="float-right">
	            <?= Html::submitButton(Yii::t('app', 'Napravi profil'), ['class' => 'btn btn-success shadow']) ?>
	        </div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>

