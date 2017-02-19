<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\Menu;

/** @var dektrium\user\models\User $user */
$user = Yii::$app->user->identity;
$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= Html::img('@web/images/profile/'.$model->avatar->name, [
                'class' => 'img-rounded',
                'alt'   => $user->username,
            ]) ?>
            <?= $user->username ?>
        </h3>
    </div>
    <div class="panel-body">
        <?= Menu::widget([
            'options' => [
                'class' => 'nav nav-pills nav-stacked',
            ],
            'items' => [
                ['label' => Yii::t('user', 'Details'), 'url' => ['/user/profile/details', 'id'=>$model->id]],
                ['label' => Yii::t('user', 'Contact'), 'url' => ['/user/profile/create-contact', 'id'=>$model->id]],
                ['label' => Yii::t('user', 'Accounts'), 'url' => ['/user/profile/accounts', 'id'=>$model->id]],
                ['label' => Yii::t('user', 'Opening Hours'), 'url' => ['/user/profile/availability', 'id'=>$model->id]],
                ['label' => Yii::t('user', 'Properties'), 'url' => ['/user/profile/provider-properties', 'id'=>$model->id]],
                ['label' => Yii::t('user', 'Languages'), 'url' => ['/user/profile/languages', 'id'=>$model->id]],
                ['label' => Yii::t('user', 'Files'), 'url' => ['/user/profile/files', 'id'=>$model->id]],
                ['label' => Yii::t('user', 'Certificates'), 'url' => ['/user/profile/certificates', 'id'=>$model->id]],
                ['label' => Yii::t('user', 'Courses'), 'url' => ['/user/profile/courses', 'id'=>$model->id], 'visible' => $model->type!=3],
                ['label' => Yii::t('user', 'Education'), 'url' => ['/user/profile/educations', 'id'=>$model->id], 'visible' => $model->type!=3],
                ['label' => Yii::t('user', 'Experience'), 'url' => ['/user/profile/experiences', 'id'=>$model->id]],
                ['label' => Yii::t('user', 'Licences'), 'url' => ['/user/profile/licences', 'id'=>$model->id], 'visible' => $model->type==2],
                ['label' => Yii::t('user', 'Members'), 'url' => ['/user/profile/members', 'id'=>$model->id], 'visible' => $model->type==3],
                ['label' => Yii::t('user', 'Patents'), 'url' => ['/user/profile/patents', 'id'=>$model->id]],
                ['label' => Yii::t('user', 'Projects'), 'url' => ['/user/profile/projects', 'id'=>$model->id]],
                ['label' => Yii::t('user', 'Publications'), 'url' => ['/user/profile/publications', 'id'=>$model->id]],
                ['label' => Yii::t('user', 'References'), 'url' => ['/user/profile/references', 'id'=>$model->id]],
                ['label' => Yii::t('user', 'Terms'), 'url' => ['/user/profile/terms', 'id'=>$model->id]],
            ],
        ]) ?>
    </div>
</div>
