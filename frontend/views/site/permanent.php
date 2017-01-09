<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Temporary';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Click to create temporary account:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'temporary-form']); ?>
            	<?= $form->field(
                    $user,
                    'username',
                    ['inputOptions' => ['value' => 'temp_'.\Yii::$app->security->generateRandomString(12), 'class' => 'form-control', 'tabindex' => '1']]
                ) ?>
                <?= $form->field(
                    $user,
                    'email',
                    ['inputOptions' => ['value' => 'temp_'.\Yii::$app->security->generateRandomString(12).'@example.com', 'class' => 'form-control', 'tabindex' => '1']]
                ) ?>
                <div class="form-group">
                    <?= Html::submitButton('Temporary account', ['class' => 'btn btn-primary', 'name' => 'temporary-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>