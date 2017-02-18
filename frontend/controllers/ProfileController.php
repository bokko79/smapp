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
use dektrium\user\controllers\ProfileController as BaseProfileController;
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
class ProfileController extends BaseProfileController
{
    /**
     * Event is triggered after updating user's account settings.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_AFTER_PROFILE_UPDATE = 'afterUpdate';

    /**
     * Event is triggered after changing users' email address.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_PROFILE_CREATE = 'afterCreate';

    // event init
    public function init()
    {
        $this->on(self::EVENT_AFTER_PROFILE_UPDATE, [$this, 'afterUpdate']);
        $this->on(self::EVENT_AFTER_PROFILE_CREATE, [$this, 'afterCreate']);
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
                        'actions' => ['create', 'details', 'contact'],
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
    public function actionCreate($type)
    {
        if(Yii::$app->user->isGuest){
            // create temp account
        } 

        if($objects = Yii::$app->request->get('ProfileFiles')){
            // ako je selektovana usluga
            // 1. kreiraj novi profil i prikači na account (temp ili perm), daj mu status draft
            // 2. kreiraj profile_providers
            // 3. kreiraj profile_services
            $model->object_id = !empty($objects['object_id']) ? $objects['object_id'] : null;
        }

        $sectors = \common\models\CcIndustries::find()->where(['type'=>'sector'])->all();
        return $this->render('create', [
            'type' => $type,
            'sectors' => $sectors,
        ]);
    }

    /**
     * C114
     * @return mixed
     */
    public function actionDetails()
    {
        
        return $this->render('details', [

        ]);
    }

    /**
     * C114
     * @return mixed
     */
    public function actionCreateContact()
    {
        
        return $this->render('createContact', [

        ]);
    }

    /**
     * C114
     * @return mixed
     */
    public function actionUpdateContact()
    {
        
        return $this->render('updateContact', [

        ]);
    }

    /**
     * C114
     * @return mixed
     */
    public function actionAvailability()
    {
        
        return $this->render('availability', [

        ]);
    }

    /**
     * C114
     * @return mixed
     */
    public function actionProviderProperties()
    {
        
        return $this->render('providerProperties', [

        ]);
    }

    /**
     * C114
     * @return mixed
     */
    public function actionCv()
    {
        
        return $this->render('cv', [

        ]);
    }

    /**
     * C114
     * @return mixed
     */
    public function actionIndex()
    {
        
        return $this->render('index', [

        ]);
    }
}
