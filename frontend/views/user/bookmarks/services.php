<?php

/*
 * C107 - Bookmark services page.
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

/* @var $this yii\web\View */
?>
<div class="row">
    <div class="col-lg-4">
        <h2>Dashboard</h2>
        <?= Html::a(Yii::$app->user->username, Url::to(['dashboard/home', 'username'=>Yii::$app->user->username])) ?>
    </div>

    <div class="col-lg-4">
        <h2>Bookmarked services</h2>
        <?php foreach($bookmarks as $bookmark){
        		echo $bookmark->service->name; ?>

                <?php $form = kartik\widgets\ActiveForm::begin([
                    'id' => 'form-horizontal'.$bookmark->id,
                    //'action' => ['/services/view'],
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                ]); ?>
                    <?= yii\helpers\Html::activeHiddenInput($bookmark, 'service_id', ['value'=>$bookmark->service->id]) ?>
                            <?= Html::submitButton(!$bookmark->service->isActiveBookmark(Yii::$app->user->id) ? 'Bookmark' : 'Remove bookmark', ['class' => !$bookmark->service->isActiveBookmark(Yii::$app->user->id) ? 'btn btn-success' : 'btn btn-primary']) ?>
                

                <?php ActiveForm::end(); ?>
        <?php

        } ?> 
    </div>
</div>