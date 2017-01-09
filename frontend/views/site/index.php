<?php

/* @var $this yii\web\View */

$this->title = 'Servicemapp';
$formatter = \Yii::$app->formatter;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Login Data</h2>

                <b>User registration IP:</b> <?= \Yii::$app->request->userIP ?><br>
                <?php if (!Yii::$app->user->isGuest): ?>
                <b>Login IP:</b> <?= \Yii::$app->user->data->login_ip ?><br>
                <b>Login time:</b> <?= \Yii::$app->user->data->login_time ?><br>
                <b>Login count:</b> <?= \Yii::$app->user->data->login_count ?><br>
                <?php endif; ?>
                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Keys</h2>
                <?php if (!Yii::$app->user->isGuest): ?>
                <b>Ime:</b> <?= $user->username . ' ' . \Yii::$app->user->id ?><br>
                <b>Auth key:</b> <?= \Yii::$app->user->data->auth_key ?><br>
                <b>Phone Verification Key:</b> <?= \Yii::$app->user->data->phone_verification_key ?><br>
                <b>Location Verification Key:</b> <?= \Yii::$app->user->data->location_verification_key ?><br>
                <b>Invite Key:</b> <?= \Yii::$app->user->data->invite_key ?><br>
                <?php endif; ?>
                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Data</h2>

                <?php if (!Yii::$app->user->isGuest): ?>
                <b>Type:</b> <?= \Yii::$app->user->data->accountType() ?><br>
                <b>Role:</b> <?php foreach(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id) as $role):
                    echo $role->name; endforeach; ?><br>
                <b>Status:</b> <?= \Yii::$app->user->data->accountStatus() ?><br>
                <b>Membership:</b> <?= \Yii::$app->user->data->accountMembershipType() ?><br>
                <b>Location:</b> <?= \Yii::$app->user->data->location->location_name ?><br>
                <b>Confirmed:</b> <?= $formatter->asBoolean(\Yii::$app->user->data->isConfirmed) ?><br>
                <b>Phone Verified:</b> <?= $formatter->asBoolean(\Yii::$app->user->data->isPhoneVerified) ?><br>
                <b>Location Verified:</b> <?= $formatter->asBoolean(\Yii::$app->user->data->isLocationVerified) ?><br>
                <?php endif; ?>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
