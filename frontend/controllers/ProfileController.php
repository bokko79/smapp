<?php

/*
 * This file is part of the Servicemapp project.
 *
 * (c) Servicemapp project <http://github.com/bokko79/servicemapp>
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
use yii\web\UploadedFile;


/**
 * SettingsController manages updating user settings (e.g. profile, email and password).
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class ProfileController extends BaseProfileController
{
    use AjaxValidationTrait;
    use EventTrait;

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

    /**
     * Event is triggered before updating user's profile.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_PROFILE_UPDATE = 'beforeProfileUpdate';

    // event init
    public function init()
    {
        $this->on(self::EVENT_AFTER_PROFILE_UPDATE, [$this, 'afterUpdate']);
        $this->on(self::EVENT_AFTER_PROFILE_CREATE, [$this, 'afterCreate']);
        $this->on(self::EVENT_BEFORE_PROFILE_UPDATE, [$this, 'beforeProfileUpdate']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'details', 'create-contact',
                            'update-contact', 'accounts', 'availability', 'certificates',
                            'courses', 'educations', 'experiences', 'files',
                            'languages', 'location', 'members', 'licences',
                            'patents', 'projects', 'provider-properties', 'references',
                            'terms', 'publications', 'home',
                        ],
                'rules' => [
                    [
                        'actions' => ['create', 'details', 'create-contact',
                            'update-contact', 'accounts', 'availability', 'certificates',
                            'courses', 'educations', 'experiences', 'files',
                            'languages', 'location', 'members', 'licences',
                            'patents', 'projects', 'provider-properties', 'references',
                            'terms', 'publications', 'home',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                   /* [
                        'actions' => ['home'],
                        'allow' => true,
                        'roles' => ['*'],
                    ],*/
                ],
            ],
        ];
    }

    /**
     * C03 - Create New Profile page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionCreate($type)
    { 
        if($services = Yii::$app->request->get('CcServices')){
            // ako je selektovana usluga
            // 1. kreiraj novi profil i prikači na account (temp ili perm), daj mu status draft
            if(Yii::$app->user->isGuest){
                // create temp account
            }
            $profile = new \common\models\Profile();  
            $profile->type = $type=='occupation' ? 2 : 3;
            $profile->trigger($profile::BEFORE_CREATE);
            if($profile->save()){
                $profile->trigger($profile::AFTER_CREATE);
                // 2. kreiraj profile_providers                
                foreach($services['id'] as $key=>$service){                    
                    $profile_service[$key] = new \common\models\ProfileServices();
                    $profile_service[$key]->profile_id = $profile->id;
                    $profile_service[$key]->service_id = $service;
                    $profile_service[$key]->save();
                }  
                // 3. kreiraj profile_services              
                foreach($services['provider'] as $key=>$provider){
                    $profile_provider[$key] = new \common\models\ProfileProviders();
                    $profile_provider[$key]->profile_id = $profile->id;
                    $profile_provider[$key]->provider_id = $provider;
                    $profile_provider[$key]->save();
                }
                return $this->redirect(['details', 'id' => $profile->id, /*'setup'=>true*/]);
            }                
        }

        $sectors = \common\models\CcIndustries::find()->where(['type'=>'sector'])->all();
        return $this->render('create', [
            'type' => $type,
            'sectors' => $sectors,
        ]);
    }

    /**
     * C04 - Profile personal/company details setup.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionDetails($id, $setup=false)
    {
        $model = $this->findProfileById($id);

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post())) {
            $model->imageAvatar = UploadedFile::getInstance($model, 'imageAvatar');
            $model->imageCover = UploadedFile::getInstance($model, 'imageCover');
            if($model->save()){
                if ($model->imageAvatar) {$model->uploadAvatar();}
                if ($model->imageCover) {$model->uploadCoverPhoto();}
                return $setup ? $this->redirect(['create-contact', 'id' => $model->id]) : $this->refresh();
            }
                
        }

        return $this->render('details', [
            'model' => $model,
        ]);
    }

    /**
     * C06 - Profile contact details setup.
     *
     * Displays a profile contact details setup.
     *
     * @return mixed
     */
    public function actionCreateContact($id, $setup=false)
    {
        $model = $this->findProfileById($id);

        $contact = new \common\models\ProfileContact();
        $this->performAjaxValidation($contact);

        if ($contact->load(\Yii::$app->request->post())) {   
            $contact->trigger($contact::BEFORE_CREATE);
            $contact->profile_id = $id;   
            if($contact->save()){
                return $setup ? $this->redirect(['location', 'id' => $id]) : $this->refresh();
            }             
        }

        return $this->render('create-contact', [
            'model' => $model,
            'contact' => $contact,
        ]);
    }

    /**
     * C114
     * @return mixed
     */
    public function actionUpdateContact($id, $setup=false)
    {
        
        return $this->render('update-contact', [

        ]);
    }    

    /**
     * C10 - Profile Setup: Provider Properties Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionProviderProperties($id, $setup=false)
    {
        
        return $this->render('provider-properties', [

        ]);
    }

    /**
     * C120 - Profile Setup: Bank Account Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionAccounts($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('accounts', [
            'model' => $model,
        ]);
    }

    /**
     * C08 - Profile Setup Details: Opening Hours (Availability) Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionAvailability($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('availability', [
            'model' => $model,
        ]);
    }
 
    /**
     * C20 - Profile Portfolio Setup: Certificates Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionCertificates($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('certificates', [
            'model' => $model,
        ]);
    }

    /**
     * C121 - Profile Portfolio Setup: Courses Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionCourses($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('courses', [
            'model' => $model,
        ]);
    }

    /**
     * C17 - Profile Portfolio Setup: Education Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionEducations($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('educations', [
            'model' => $model,
        ]);
    }

    /**
     * C16 - Profile Portfolio Setup: Experiences Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionExperiences($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('experiences', [
            'model' => $model,
        ]);
    }

    /**
     * C122 - Profile Portfolio Setup: Files Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionFiles($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('files', [
            'model' => $model,
        ]);
    }

    /**
     * C123 - Profile Portfolio Setup: Languages Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionLanguages($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('languages', [
            'model' => $model,
        ]);
    }

    /**
     * C19 - Profile Portfolio Setup: Licenecs Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionLicences($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('licences', [
            'model' => $model,
        ]);
    }

    /**
     * C07 - Profile Setup: Location Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionLocation($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('location', [
            'model' => $model,
        ]);
    }

    /**
     * C28 - Profile Organization Setup: Members Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionMembers($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('members', [
            'model' => $model,
        ]);
    }

    /**
     * C124 - Profile Portfolio Setup: Patents Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionPatents($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('patents', [
            'model' => $model,
        ]);
    }

    /**
     * C21 - Profile Portfolio Setup: Projects Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionProjects($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('projects', [
            'model' => $model,
        ]);
    }

    /**
     * C18 - Profile Portfolio Setup: Publications Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionPublications($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('publications', [
            'model' => $model,
        ]);
    }

    /**
     * C125 - Profile Portfolio Setup: References Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionReferences($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('references', [
            'model' => $model,
        ]);
    }

    /**
     * C22 - Profile Setup: Terms and Conditions Setup page.
     *
     * Displays a page for creating new account profile.
     *
     * @return mixed
     */
    public function actionTerms($id, $setup=false)
    {
        $model = $this->findProfileById($id);
        return $this->render('terms', [
            'model' => $model,
        ]);
    }

    /**
     * C03 - Profile Home Page.
     *
     * Displays a single Profile model and its home profile page.
     * @param string $id
     * @return mixed
     */
    public function actionHome($id)
    {
        $model = $this->findProfileById($id);

        return $this->render('home', [
            'model' => $model,
        ]);
    }

    /**
     * D23 - Profiles (Providers) Index Page.
     *
     * Displays a single Profile model and its home profile page.
     * @param string $id
     * @return mixed
     */
    public function actionIndex()
    {
        ///$model = $this->findProfileById($id);

        return $this->render('index', [
            //'model' => $model,
        ]);
    }

    /**
     * D24 - Profile's (Provider's) Home Page.
     *
     * Displays a single Profile model and its home profile page.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findProfileById($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProfileById($id)
    {
        if (($model = \common\models\Profile::find()->where('id=:id', [':id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
