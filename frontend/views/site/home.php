<?php

/*
 * This file is part of the Servicemapp project.
 *
 * (c) Servicemapp project <http://github.com/bokko79/servicemapp/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CsServicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use kartik\tabs\TabsX;

$this->title = null;
$this->params['breadcrumbs'][] = $this->title;

echo ListView::widget([
    'dataProvider' => $queryActions,
    'itemView' => 'cards/_industryCard',
    'layout' => '{summary}{pager}{items}',
    'summary' => '',
]);

echo ListView::widget([
    'dataProvider' => $queryIndustries,
    'itemView' => 'cards/_industryCard',
    'layout' => '{summary}{pager}{items}',
    'summary' => '',
]);

echo ListView::widget([
    'dataProvider' => $queryObjects,
    'itemView' => 'cards/_industryCard',
    'layout' => '{summary}{pager}{items}',
    'summary' => '',
]);

