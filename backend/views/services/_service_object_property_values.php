<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">	
			<ul>
				<?php
					if($model->serviceObjectPropertyValues){
						foreach($model->serviceObjectPropertyValues as $serviceObjectPropertyValue){
							echo '<li>' . Html::a($serviceObjectPropertyValue->objectPropertyValue->object->name, Url::to(['/service-object-property-values/view', 'id'=>$serviceObjectPropertyValue->id])) /*. ($serviceObjectPropertyValue->selected_value==1 ? ' (selected)' : null) */. '</li>';
						}
					} elseif($model->objectProperty->objectPropertyValues){
						foreach($model->objectProperty->objectPropertyValues as $objectPropertyValue){
							echo '<li>' . Html::a($objectPropertyValue->propertyValue ? $objectPropertyValue->propertyValue->value : $objectPropertyValue->object->name, Url::to(['/object-property-values/view', 'id'=>$objectPropertyValue->id])) . ($objectPropertyValue->selected_value==1 ? ' (selected)' : null) . '</li>';
						}
					} ?>
			</ul>
		</div>
	</div>
</div>  