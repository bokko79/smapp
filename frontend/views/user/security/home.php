<?php

/*
 * C01 - Dashboard Home page.
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
use yii\widgets\DetailView;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */

$this->title = 'Servicemapp';
$formatter = \Yii::$app->formatter;
?>
Zdravo <?= $model->username ?>. Ovo je tvoj dashboard.
<?= Html::a('Create new profile', Url::to(), ['class'=>'btn btn-warning', 'data-toggle'=>'modal', 'data-backdrop'=>false,  'data-target'=>'#choose-profile-type']) ?>
<div class="row">
    <div class="col-lg-3">
    

        <h2>Login Data</h2>

        <b>User registration IP:</b> <?= \Yii::$app->request->userIP ?><br>
        <?php if (!Yii::$app->user->isGuest): ?>
        <b>Login IP:</b> <?= \Yii::$app->user->data->login_ip ?><br>
        <b>Login time:</b> <?= \Yii::$app->user->data->login_time ?><br>
        <b>Login count:</b> <?= \Yii::$app->user->data->login_count ?><br>
        <?php endif; ?>
    </div>
    <div class="col-lg-5">
        <h2>Keys</h2>
        <?php if (!Yii::$app->user->isGuest): ?>
        <b>Ime:</b> <?= Yii::$app->user->username . ' ' . \Yii::$app->user->id ?><br>
        <b>Auth key:</b> <?= \Yii::$app->user->data->auth_key ?><br>
        <b>Phone Verification Key:</b> <?= \Yii::$app->user->data->phone_verification_key ?><br>
        <b>Location Verification Key:</b> <?= \Yii::$app->user->data->location_verification_key ?><br>
        <b>Invite Key:</b> <?= \Yii::$app->user->data->invite_key ?><br>
        <?php endif; ?>
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
    </div>
</div>

<div class="row">
    <div class="col-lg-3">
        <h2>Profiles</h2>
        <?php foreach($profiles as $profile){
        		echo Html::a($profile->id. ($profile->type==1 ? 'private' : 'public'), Url::to(['profile/home', 'id'=>$profile->id]));

        	} ?>
    </div>
    <div class="col-lg-5">
        <h2>Links</h2>
    </div>
    <div class="col-lg-4">
        <h2>Activity</h2>
        
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <h2>Activity</h2><table>
        	<?php foreach($activities as $activity){
        		echo '<tr><td style="padding: 3px 5px;"><b>'.$activity->user->username. '</b></td><td>'.$activity->eventCode()['name'].'</td><td>'.$activity->eventText()['name'].'</td><td>on '.$formatter->asDate($activity->created_at, 'long').' at '.$formatter->asTime($activity->created_at, 'short').'</td></tr>';

        	} ?>
        </table>
    </div>
    <div class="col-lg-4">
        <h2><?= Html::a('Bookmarked services', Url::to(['bookmarks/services', 'username'=>Yii::$app->user->username])) ?></h2>
        
    </div>
</div>

<?php Modal::begin([
        'id'=>'choose-profile-type',
        'size'=>Modal::SIZE_SMALL,
        'class'=>'overlay_modal',
        'header'=> 'choose-profile-type',
    ]); ?>
        <?= Html::a('Individual profile', Url::to(['profile/create', 'type'=>'occupation']), ['class'=>'btn btn-link']) ?>
        <br>
        <?= Html::a('Company profile', Url::to(['profile/create', 'type'=>'enterprise']), ['class'=>'btn btn-link']) ?>
<?php Modal::end();
?>