<?php

/*
 * C03 - Create New Profile page.
 *
 * This file is part of the Servicemapp project.
 *
 * (c) Servicemapp project <http://github.com/bokko79/servicemapp>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\ActiveField;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('user', 'Create new  '. $type. ' profile');
$this->params['breadcrumbs'][] = $this->title;
?>

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
					if($providers = $sector->providers){
						foreach($providers as $provider){
							if($provider->type==$type){
								echo '<li><b>'.$provider->name.'</b></li>';
								if($services = $provider->services){
									$ser = ArrayHelper::map($services, 'id', 'name');
									$serv = new \common\models\CcServices;
									echo $form->field($serv, 'id[]')->checkboxList($ser, ['unselect'=>null, 'class'=>'column3 multiselect'])->label(false);	
									echo yii\helpers\Html::activeHiddenInput($serv, 'provider[]', ['value'=>$provider->id]);
								}
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

