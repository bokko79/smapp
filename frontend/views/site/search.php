<?php

/*
 * D01 - Search Results page.
 *
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

$this->title = Yii::t('app', 'Index usluga');
$this->params['breadcrumbs'][] = $this->title;
$this->params['renderIndex'] = $renderIndex;
$this->params['industry'] = $industry;
$this->params['object'] = $object;
$this->params['action'] = $action;

$items = [];
/* items */
$s = ($dataProvider and $dataProvider->totalCount>0) ? [
        'label'=>'<i class="fa fa-dot-circle-o"></i> Usluge <b>('.$countServicesResults.')</b>',
        'content'=>//'<div class="grid js-masonry overflow-hidden" data-masonry-options=\'{ "itemSelector": ".grid-item", "isFitWidth": true, "gutter": 30 }\' style="margin-top:0px;">'.
        ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => Yii::$app->request->get('advanced-view')=='list' ? '_card_list' : '_card',
            'layout' => '{summary}{pager}{items}',
            'summary' => '',
        ])/* .
        '</div>'*/] : null;
$o = ($queryObjects and $queryObjects->totalCount>0) ? [
        'label'=>'<i class="fa fa-cube"></i> Predmeti usluga <b>('.$countObjectsResults.')</b>',
        //'content'=>($queryObjects) ? $this->render('//services/queryResults/_queryObjects.php', ['queryObjects'=>$queryObjects]) : null,
        'content'=>//'<div class="grid js-masonry overflow-hidden" data-masonry-options=\'{ "itemSelector": ".grid-item", "isFitWidth": true, "gutter": 30 }\' style="margin-top:0px;">'.
        ListView::widget([
            'dataProvider' => $queryObjects,
            'itemView' => Yii::$app->request->get('advanced-view')=='list' ? 'cards/_industryCard' : 'queryResults/_queryObjects',
            'layout' => '{summary}{pager}{items}',
            'summary' => '',
        ]),
        'active'=> $dataProvider->totalCount==0 and $queryIndustries->totalCount==0 and $queryActions->totalCount==0 ? true : false,
    ] : null;
$i = ($queryIndustries and $queryIndustries->totalCount>0) ? [
        'label'=>'<i class="fa fa-tag"></i> Delatnosti <b>('.$countIndustriesResults.')</b>',
        //'content'=>($queryIndustries) ? $this->render('//services/queryResults/_queryIndustries.php', ['queryIndustries'=>$queryIndustries]) : null,
        'content'=>//'<div class="grid js-masonry overflow-hidden" data-masonry-options=\'{ "itemSelector": ".grid-item", "isFitWidth": true, "gutter": 30 }\' style="margin-top:0px;">'.
        ListView::widget([
            'dataProvider' => $queryIndustries,
            'itemView' => Yii::$app->request->get('advanced-view')=='list' ? 'cards/_industryCard' : 'queryResults/_queryIndustries',
            'layout' => '{summary}{pager}{items}',
            'summary' => '',
        ]),// .
        //'</div>',
        'active'=> $dataProvider->totalCount==0 ? true : false,
    ] : null;
$a = ($queryActions and $queryActions->totalCount>0) ? [
        'label'=>'<i class="fa fa-flag"></i> Akcije <b>('.$countActionsResults.')</b>',
        //'content'=>($queryActions) ? $this->render('//services/queryResults/_queryActions.php', ['queryActions'=>$queryActions]) : null,
        'content'=>//'<div class="grid js-masonry overflow-hidden" data-masonry-options=\'{ "itemSelector": ".grid-item", "isFitWidth": true, "gutter": 30 }\' style="margin-top:0px;">'.
        ListView::widget([
            'dataProvider' => $queryActions,
            'itemView' => Yii::$app->request->get('advanced-view')=='list' ? 'cards/_industryCard' : 'queryResults/_queryActions',
            'layout' => '{summary}{pager}{items}',
            'summary' => '',
        ]),
        'active'=> $dataProvider->totalCount==0 and $queryIndustries->totalCount==0 ? true : false,
    ] : null;
//$items = [ $s, $i, $a, $o, $p ];
    if($s) $items[] = $s;
    if($o) $items[] = $o;
    if($i) $items[] = $i;
    if($a) $items[] = $a;    

if(!$industry):
    if($searchString!=null): ?>
        <?= $this->render('//site/_searchHead.php', ['searchString'=>$searchString, 'countSearchResults'=>$countSearchResults, 'countServicesResults'=>$countServicesResults, 'countIndustriesResults'=>$countIndustriesResults, 'countActionsResults'=>$countActionsResults, 'countObjectsResults'=>$countObjectsResults, 'object'=>$object, 'action'=>$action]) ?>        
        <?= TabsX::widget([
	            'items' => $items,
	            'position'=>TabsX::POS_ABOVE,
	            'encodeLabels'=>false,
	            'containerOptions' => ['class'=>'tab_track']
	        ]) ?>
    <?php endif; ?>
    <?php if($object): ?>
        <?= $this->render('//site/partial/objects.php', ['object'=>$object]) ?>
    <?php endif; ?>    
    <?php if($action): ?>
        <?= $this->render('//site/partial/actions.php', ['action'=>$action]) ?>    
    <?php endif; ?>
<?php else: ?>
<div class="grid js-masonry overflow-hidden" data-masonry-options='{ "itemSelector": ".grid-item", "isFitWidth": true, "gutter": 30 }' style="margin-top:40px;">
    <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_card',
            'summary' => '',
        ]) ?>
</div>
<?php endif; ?>

