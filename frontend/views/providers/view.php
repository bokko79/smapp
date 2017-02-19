<?php

/*
 * D07 - Industry's profile (home) page.
 *
 * This file is part of the Servicemapp project.
 *
 * (c) Servicemapp project <http://github.com/bokko79/servicemapp/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\CcProviders */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Providers'];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= c(Html::encode($this->title)) ?> <small>status: <?= $model->status ?></small></h2>

<div class="container">
	<div class="row">
		<div class="col-lg-8">
			<?= DetailView::widget([
			    'model' => $model,
			    'attributes' => [
			        'id',
			        'name',
			        //'parent.name',
			        'file_id',
			        'status',
			    ],
			]) ?>
		</div>
		<div class="col-lg-4">
			<?= ListView::widget([
			    'dataProvider' => $dataProvider,
			    'itemView' => '_card',
			]) ?>
		</div>
	</div>
</div>