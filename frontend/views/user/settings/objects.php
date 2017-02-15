<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserObjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Moji predmeti');
$this->params['breadcrumbs'][] = $this->title;

$pageDescription = '<p style="font-size:12px; line-height:14px; margin:10px;">'.Yii::t('app', 'Lista mojih sačuvanih predmeta usluga i njihove karakteristike. Klikom na dugme desno "dodaj/izbaci predmet" pređite na stranicu za izbor i izaberite predmet.').'</p>';
$pageDescription .= '<p style="font-size:12px; line-height:14px; margin:10px;">'.Yii::t('app', 'Kada izaberete Vaš predmet usluge, na ovoj stranici se nalazi spisak svih izabranih predmeta. Klikom na naslov svakog njih možete ih dodatno podešavati i tako olakšati i ubrzati kupovinu ili naručivanje usluga.').'</p>';

?>
<div class="list-container">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
        'summary' => false,
    ]) ?>
</div>