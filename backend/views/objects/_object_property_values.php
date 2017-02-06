<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">	
			<ul>
				<?php
					if($allValues = $model->allValues){
						foreach($allValues as $objectPropertyValue){
							echo '<li>' . Html::a($objectPropertyValue->propertyValue ? $objectPropertyValue->propertyValue->value : $objectPropertyValue->object->name, Url::to(['/object-property-values/view', 'id'=>$objectPropertyValue->id])) . ($objectPropertyValue->selected_value==1 ? ' (selected)' : null) . '</li>';
						}
					} ?>
			</ul>
		</div>
	</div>
</div>  