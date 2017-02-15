<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace frontend\controllers;

use Yii;
use dektrium\user\Finder;
use common\models\Profile;
use common\models\SettingsForm;
use common\models\UserAccount;
use dektrium\user\Module;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use dektrium\user\controllers\SettingsController as BaseSettingsController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use common\models\Log;


/**
 * SettingsController manages updating user settings (e.g. profile, email and password).
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class SettingsController extends BaseSettingsController
{
    /**
     * Event is triggered after updating user's account settings.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_AFTER_ACCOUNT_UPDATE = 'afterAccountUpdate';

    /**
     * Event is triggered after changing users' email address.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_CONFIRM = 'afterConfirm';

    // event init
    public function init()
    {
        $this->on(self::EVENT_AFTER_ACCOUNT_UPDATE, [$this, 'afterAccountUpdate']);
        $this->on(self::EVENT_AFTER_CONFIRM, [$this, 'afterConfirm']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['services'],
                'rules' => [
                    [
                        'actions' => ['objects', 'object-setup', 'account'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * C114
     * @return mixed
     */
    public function actionObjects($username=null)
    {
        if (isset($username)) {
            $user = \common\models\UserAccount::find()->where(['username'=>$username])->one();
        }

        if($user) {
            $searchModel = new \common\models\UserObjectsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('objects', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'user' => $user,
            ]);
        } else {
            $this->redirect(Yii::$app->request->baseUrl.'/providers');
        }
    }

    /**
     * C115
     * @return mixed
     */
    public function actionObjectSetup($username=null, $id=null, $object=null)
    {
        if (isset($username)) {
            $user = \common\models\UserAccount::find()->where(['username'=>$username])->one();
        }

        if($user) {
            if($id==null){ // create
                $model = new \common\models\UserObjects();
                $object = \common\models\CcObjects::find()->where(['id'=>$object])->one();
                $model_property_value = new \common\models\UserObjectPropertyValues();
            } else { // update
                $model = \common\models\UserObjects::find()->where(['id'=>$id])->one();
                $object = $model->object;
                $model_property_value = new \common\models\UserObjectPropertyValues();
            }
                
            return $this->render('object-setup', [
                'model' => $model,
                'user' => $user,
                'object' => $object,
                'objectProperties' => $object->getAllProperties(),
                'model_properties' => $this->loadUserObjectProperties($object),
                'model_property_value' => $model_property_value,
            ]);
        } else {
            $this->redirect(Yii::$app->request->baseUrl.'/providers');
        }
    }       

    /**
     * 
     */
    protected function loadUserObjectProperties($object)
    {
        if($objectProperties = $object->getAllProperties()){
            /*echo '<pre>';
                print_r($objectProperties); die();*/
            foreach($objectProperties as $objectProperty) {                
                if($property = $objectProperty->property) {
                    $model_object_properties[$property->id] = new \common\models\UserObjectProperties();
                    $model_object_properties[$property->id]->objectProperty = $objectProperty;
                    /*$model_object_properties[$property->id]->property = $property;
                    $model_object_properties[$property->id]->service = $service;
                    $model_object_properties[$property->id]->key = $key;
                    $model_object_properties[$property->id]->checkUserObject = ($this->checkUserObjectsExist($service, $object_models)) ? 0 : 1;
                    $model_object_properties[$property->id]->checkIfRequired = ($objectProperty->required==1) ? 1 : 0;*/
                }
            }
            return (isset($model_object_properties)) ? $model_object_properties : null;
        }
        return null;        
    } 

    public function afterAccountUpdate($event){        
        $log = new Log;
        $log->logEvent(13);
    }

    public function afterConfirm($event){        
        $log = new Log;
        $log->logEvent(11);
    } 
}
