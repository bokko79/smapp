<?php

/*
 * C06 - Profile contact details setup.
 *
 * This file is part of the Servicemapp project.
 *
 * (c) Servicemapp project <http://github.com/bokko79/servicemapp>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use dektrium\user\helpers\Timezone;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\FileInput;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $model
 */

$this->title = Yii::t('user', 'Profile Contact Details settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu', ['model' => $model]) ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'profile-form',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'fullSpan' => 7,      
                    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_MEDIUM],
                    'options' => ['enctype' => 'multipart/form-data'],
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,

                ]); ?>                               

                <?= $form->field($contact, 'contact_type')->dropDownList([1 => 'E-mail address',2 => 'Phone', 3 => 'Fax', 4 => 'Home address', 5 => 'Skype IM'], ['style'=>'width:100%']) ?>

                <?= $form->field($contact, 'contact_value')->input('text') ?>

                <?= $form->field($contact, 'name')->input('text')->hint('optional') ?> 

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
                        <br>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
