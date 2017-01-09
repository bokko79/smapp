<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">	
			<ul>
				<?php
					if($model->objectPropertyValues){
						foreach($model->objectPropertyValues as $objectPropertyValue){
							echo '<li>' . Html::a($objectPropertyValue->propertyValue ? $objectPropertyValue->propertyValue->value : $objectPropertyValue->object->name, Url::to(['/object-property-values/view', 'id'=>$objectPropertyValue->id])) . '</li>';
						}
					} ?>
			</ul>
		</div>
	</div>
</div>  