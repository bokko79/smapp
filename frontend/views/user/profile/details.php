<?php

/*
 * C04 - Profile personal/company details setup.
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

$this->title = Yii::t('user', 'Profile Details settings');
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
                <?php /* $form = ActiveForm::begin([
                    'id' => 'profile-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                ]); */ ?>
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

                <?= $form->field($model, 'name')->input('text') ?>

                <?= $form->field($model, 'fullname')->input('text') ?>

                <?= $form->field($model, 'public_email')->input('text') ?>

                <?= $form->field($model, 'website')->input('text') ?>

                <?= $form->field($model, 'imageAvatar')->widget(FileInput::classname(), [
                        'options' => [/*'multiple' => true, */'accept' => 'image/*'],
                        'pluginOptions' => [
                            'previewFileType' => 'any',
                            'showCaption' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-info shadow',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' =>  Yii::t('app', 'Izaberite avatar'),
                            'removeLabel' =>  Yii::t('app', 'Izbaci sve'),
                            'resizeImage'=> true,
                            'maxImageWidth'=> 60,
                            'maxImageHeight'=> 60,
                            'resizePreference'=> 'width',
                        ],
                    ]) ?>

                    <?= $form->field($model, 'imageCover')->widget(FileInput::classname(), [
                        'options' => [/*'multiple' => true, */'accept' => 'image/*'],
                        'pluginOptions' => [
                            'previewFileType' => 'any',
                            'showCaption' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-info shadow',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' =>  Yii::t('app', 'Izaberite naslovnicu'),
                            'removeLabel' =>  Yii::t('app', 'Izbaci sve'),
                            'resizeImage'=> true,
                            'maxImageWidth'=> 1200,
                            'maxImageHeight'=> 200,
                            'resizePreference'=> 'width',
                        ],
                    ]) ?>

                <?= $form
                    ->field($model, 'timezone')
                    ->dropDownList(
                        ArrayHelper::map(
                            Timezone::getAll(),
                            'timezone',
                            'name'
                        )
                    ); ?>

                <?= $form
                    ->field($model, 'gravatar_email')
                    ->hint(Html::a(Yii::t('user', 'Change your avatar at Gravatar.com'), 'http://gravatar.com')) ?>

                <?= $form->field($model, 'about')->textarea() ?>

                <?= $form->field($model, 'date_of_birth')->input('text') ?>

                <?= $form->field($model, 'height')->input('number') ?>

                <?= $form->field($model, 'weight')->input('number') ?>

                <?= $form->field($model, 'age')->input('number') ?>

                <?= $form->field($model, 'marital_status')->dropDownList(['married' => 'married', 'single' => 'single', 'divorced' => 'divorced', 'widowed' => 'widowed'], ['style'=>'width:50%']) ?>

                <?= $form->field($model, 'gender')->dropDownList(['m' => 'muško', 'f' => 'žensko', 'trans' => 'transgender'], ['style'=>'width:50%']) ?>

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
