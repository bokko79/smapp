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
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View              $this
 * @var dektrium\user\models\User $user
 * @var dektrium\user\Module      $module
 */

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'registration-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                ]); ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'username') ?>

                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                <?php endif ?>
121212


                <?= $form->field($model, 'location') ?>      
        <div id="my_map_register" class="col-md-91" style="height:360px; margin-bottom:20px;"></div>

<?php // HQ ?>
<?= yii\helpers\Html::activeHiddenInput($locationHQ, 'lat', ['data-geo'=>'lat', 'id'=>'hidden-geo-input']) ?>
<?= yii\helpers\Html::activeHiddenInput($locationHQ, 'lng', ['data-geo'=>'lng', 'id'=>'hidden-geo-input']) ?>
<?= yii\helpers\Html::activeHiddenInput($locationHQ, 'city', ['data-geo'=>'locality', 'id'=>'hidden-geo-input']) ?>
<?= yii\helpers\Html::activeHiddenInput($locationHQ, 'country', ['data-geo'=>'country', 'id'=>'hidden-geo-input']) ?>
<?= yii\helpers\Html::activeHiddenInput($locationHQ, 'state', ['data-geo'=>'state', 'id'=>'hidden-geo-input']) ?>
<?= yii\helpers\Html::activeHiddenInput($locationHQ, 'district', ['data-geo'=>'sublocality', 'id'=>'hidden-geo-input']) ?>
<?= yii\helpers\Html::activeHiddenInput($locationHQ, 'zip', ['data-geo'=>'postal_code', 'id'=>'hidden-geo-input']) ?>
<?= yii\helpers\Html::activeHiddenInput($locationHQ, 'mz', ['data-geo'=>'neighborhood', 'id'=>'hidden-geo-input']) ?>       
<?= yii\helpers\Html::activeHiddenInput($locationHQ, 'street', ['data-geo'=>'route', 'id'=>'hidden-geo-input']) ?>
<?= yii\helpers\Html::activeHiddenInput($locationHQ, 'location_name', ['data-geo'=>'formatted_address', 'id'=>'hidden-geo-input']) ?>

                
<?= Html::a('By clicking on "Sign up" button, I agree on Servicemapp Terms and Conditions.', Url::to(), ['data-toggle'=>'modal', 'data-backdrop'=>false,  'data-target'=>'#terms']) ?>

                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
        </p>
    </div>
</div>


<?php
\yii\bootstrap\Modal::begin([
    'header' => '<h2>Servicemapp Terms and Conditions</h2>',
    'id'=>'terms',
]);

echo 'General terms of use';

\yii\bootstrap\Modal::end();