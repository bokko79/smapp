<?php

namespace frontend\controllers;

use Yii;
use common\models\CcServices;
use common\models\CcServicesSearch;
use common\models\CcServicesTranslation;
use common\models\CcIndustries;
use common\models\CcTags;
use common\models\CcActions;
use common\models\CcObjects;
use yii\web\Request;
use yii\web\Session;

class AutocompleteController extends \yii\web\Controller
{
    public $lang_code = 'SR';

    public function actionListActServices()
    {
        return $this->render('list-act-services');
    }

    public function actionListIndActions()
    {
        return $this->render('list-ind-actions');
    }

    public function actionListServices($q = null, $id = null)
    {        
        $query = new \yii\db\Query;
         $query->select('ser.id as id, ind.name AS industry, ser.name AS name')
            ->from('cc_industries AS ind')
            ->innerJoin('cc_services AS ser', 'ser.industry_id=ind.id')
            ->where(['like', 'ser.name', $q])
            ->groupBy('ser.id')
            ->orderBy(['ser.name' => SORT_ASC]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['id' => $d['id'], 'name' => $d['name'], 'industry' => $d['industry'], 'icon' => 'cog', 'color' => '#555555'];
        }
        echo \yii\helpers\Json::encode($out);
    }

    // THE CONTROLLER
    public function actionListIndustries($q = null, $id = null) {        
        $query = new \yii\db\Query;
        $query->select('ind.id AS industry_id, ind.name AS industry')
            ->from('cc_providers AS ind')
            ->where(['like', 'ind.name', $q])
            ->groupBy('ind.id')
            ->orderBy(['ind.name' => SORT_ASC]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['industry_id' => $d['industry_id'], 'name' => $d['industry'], 'icon' => 'cog', 'color' => '#555555'];
        }
        echo \yii\helpers\Json::encode($out);
    }

    // THE CONTROLLER
    public function actionListActions($q = null, $id = null) {        
        $query = new \yii\db\Query;
        $query->select('act.id AS action_id, act.name AS action')
            ->from('cc_actions AS act')
            ->where(['like', 'act.name', $q])
            ->groupBy('act.id')
            ->orderBy(['act.name' => SORT_ASC]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['action_id' => $d['action_id'], 'name' => $d['action']];
        }
        echo \yii\helpers\Json::encode($out);
    }

    // THE CONTROLLER
    public function actionListObjects($q = null, $id = null) {        
        $query = new \yii\db\Query;
        $query->select('obj.id AS object_id, obj.name AS object, obj_p.name AS parent')
            ->from('cc_objects AS obj')
            ->innerJoin('cc_objects AS obj_p', 'obj_p.id=obj.object_id')
            ->where(['like', 'obj.name', $q])
            ->andWhere('obj.class != "abstract"')
            ->groupBy('obj.id')
            ->orderBy([ 'obj.name' => SORT_ASC]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['object_id' => $d['object_id'], 'name' => $d['object'], 'parent' => $d['parent']];
        }
        echo \yii\helpers\Json::encode($out);
    }

    // THE CONTROLLER
    /*public function actionListActionsTags($q = null, $id = null) {        
        $query = new \yii\db\Query;
        $query->select('tag.id AS tag_id, tag.tag AS name, act.name AS action')
            ->from('cc_tags AS tag')
            ->innerJoin('cc_actions AS act', 'tag.entity_id=act.id')
            ->where(['like', 'tag.tag', $q])
            ->andWhere(['tag.entity'=>'action'])
            ->groupBy('tag.id')
            ->orderBy(['tag.tag' => SORT_ASC]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['tag_id' => $d['tag_id'], 'name' => $d['name'], 'action' => $d['action']];
        }
        echo \yii\helpers\Json::encode($out);
    }

    // THE CONTROLLER
    public function actionListIndustriesTags($q = null, $id = null) {        
        $query = new \yii\db\Query;
        $query->select('tag.id AS tag_id, tag.tag AS name, ind.name AS industry')
            ->from('cc_tags AS tag')
            ->innerJoin('cc_industries AS ind', 'tag.entity_id=ind.id')
            ->where(['like', 'tag.tag', $q])
            ->andWhere(['tag.entity'=>'industry'])
            ->groupBy('tag.id')
            ->orderBy(['tag.tag' => SORT_ASC]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['tag_id' => $d['tag_id'], 'name' => $d['name'], 'industry' => $d['industry']];
        }
        echo \yii\helpers\Json::encode($out);
    }

    // THE CONTROLLER
    public function actionListObjectsTags($q = null, $id = null) {        
        $query = new \yii\db\Query;
        $query->select('tag.id AS tag_id, tag.tag AS name, obj.name AS object')
            ->from('cc_tags AS tag')
            ->innerJoin('cc_objects AS obj', 'tag.entity_id=obj.id')
            ->where(['like', 'tag.tag', $q])
            ->andWhere(['tag.entity'=>'object'])
            ->groupBy('tag.id')
            ->orderBy(['tag.tag' => SORT_ASC]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['tag_id' => $d['tag_id'], 'name' => $d['name'], 'object' => $d['object']];
        }
        echo \yii\helpers\Json::encode($out);
    }

    // THE CONTROLLER
    public function actionListServicesTags($q = null, $id = null) {        
        $query = new \yii\db\Query;
        $query->select('tag.id AS tag_id, tag.tag AS name, ser.name AS service')
            ->from('cc_tags AS tag')
            ->innerJoin('cc_services AS ser', 'tag.entity_id=ser.id')
            ->where(['like', 'tag.tag', $q])
            ->andWhere(['tag.entity'=>'service'])
            ->groupBy('tag.id')
            ->orderBy(['tag.tag' => SORT_ASC]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['tag_id' => $d['tag_id'], 'name' => $d['name'], 'serivce' => $d['service']];
        }
        echo \yii\helpers\Json::encode($out);
    }*/

    /**
     * Lists all ccServices models.
     * @return mixed
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;

        $post = $request->post('CcServicesSearch'); 

        // industry
        if(isset($post['industry_id']) && $post['industry_id']!=null && $post['industry_id']!=''){
            //$industry = CcIndustries::findOne($post['industry_id']);
            return $this->redirect(['/provider/view/'.$post['industry_id']]);
        }
        // object
        if(isset($post['object_id']) && $post['object_id']!=null && $post['object_id']!=''){
            //$object = CcObjects::findOne($post['object_id']);
            return $this->redirect(['/objects/view/'.$post['object_id']]);
        }
        // action
        if(isset($post['action_id']) && $post['action_id']!=null && $post['action_id']!=''){
            //$action = CcActions::findOne($post['action_id']);
            //return $this->redirect(['/services/view/'.$post['action_id']);
        }
        // service
        if(isset($post['id']) && $post['id']!=null && $post['id']!=''){
            //$service = CcServices::findOne($post['id']);
            return $this->redirect(['/services/view/'.$post['id']]);
        }
        // tags
        /*if(isset($post['tag_id']) && $post['tag_id']!=null && $post['tag_id']!=''){
            $tag = CcTags::findOne($post['tag_id']);
            switch ($tag->entity) {
                case 'action':
                    return $this->redirect(['/services', 'a'=>$tag->entity_id]);
                    break;
                case 'object':
                    return $this->redirect(['/services', 'o'=>$tag->entity_id]);
                    break;
                case 'industry':
                    return $this->redirect(['/services', 'i'=>$tag->entity_id]);
                    break;
                case 'service':
                    $service = CcServices::findOne($tag->entity_id);
                    return $this->redirect(['/s/'.slug($service->tName)]);
                    break;                
                default:
                    return $this->redirect(['/services']);
                    break;
            }            
        }
        if(isset($post['name']) && $post['name']!=null && $post['name']!=''){
            return $this->redirect(['/services', 'q'=>$post['name']]);
        }*/

        return $this->redirect(['/site/search']); 
    }

}
