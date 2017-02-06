<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\UserAccount;
use common\models\Log;
use common\models\CcServices;
use common\models\CcServicesSearch;
use common\models\CcObjects;
use common\models\CcIndustries;
use common\models\CcProviders;
use common\models\CcActions;
use yii\data\ActiveDataProvider;
use yii\elasticsearch\Query;


/**
 * Site controller
 */
class SiteController extends Controller
{
    const EVENT_CONTACT_US = 'afterContactUs';

    // event init
    public function init()
    {
        $this->on(self::EVENT_CONTACT_US, [$this, 'afterContactUs']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'log'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['log'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $user = UserAccount::findOne(Yii::$app->user->id);
        return $this->render('index', [
                'user' => $user,
            ]);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionHome()
    {
        $queryObjects = new ActiveDataProvider([
                    'query' => CcObjects::find()->limit(4),
                ]);
        $queryIndustries = new ActiveDataProvider([
                    'query' => CcIndustries::find()->limit(4),
                ]);
        //$queryIndustries = ($q) ? $this->suggested_word($q) : null;
        $queryActions = new ActiveDataProvider([
                    'query' => CcActions::find()->limit(4),
                ]);
        
        return $this->render('home', [         
            'queryObjects' => $queryObjects,
            'queryIndustries' => $queryIndustries,
            'queryActions' => $queryActions,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionSearch()
    {
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        //$session->removeAll();
        $entity = $request->get('entity');
        $title = $request->get('title');

        if($state = $request->get('st')){            
            $session->set('state', $state);
            if($state=='gl'){
                $session->remove('state');
            }
        }
        $q = $request->get('q');
        $queryObjects = new Query();
        $queryObjects = ($q) ?  new ActiveDataProvider([
                    'query' => CcObjects::find()->where(['like', 'name', $q])->andWhere('class = "object"')->groupBy('id'),
                ]) : null;
        $queryIndustries = ($q) ? new ActiveDataProvider([
                    'query' => CcIndustries::find()->where(['like', 'name', $q])->groupBy('id'),
                ]) : null;
        //$queryIndustries = ($q) ? $this->suggested_word($q) : null;
        $queryActions = ($q) ? new ActiveDataProvider([
                    'query' => CcActions::find()->where(['like', 'name', $q])->groupBy('id'),
                ]) : null;

        $object = ($entity=='o' and $title) ? $this->findObjectByTitle($title) : null;
        $industry = ($entity=='i' and $title) ? $this->findIndustryByTitle($title) : null;
        $action = ($entity=='a' and $title) ? $this->findActionByTitle($title) : null;

        $renderIndex = $object || $industry || $action  || $q ? false : true;
        
        $searchModel = new CcServicesSearch();
        $dataProvider = $searchModel->search(['CcServicesSearch'=>['name'=>$q, 'industry_id'=>$industry ? $industry->id : null, 'action_id'=>$action ? $action->id : null, 'object_id'=>$object ? $object->id : null,]]);

        
        return $this->render('search', [
            'dataProvider' => $dataProvider,
            'renderIndex' => $renderIndex,
            'industry' => $industry,
            'action' => $action,
            'object' => $object,
            'searchString' => $request->get('q'),           
            'queryObjects' => $queryObjects,
            'queryIndustries' => $queryIndustries,
            'queryActions' => $queryActions, 
            'countSearchResults' => $this->countSearchResults($dataProvider, $queryObjects, $queryIndustries, $queryActions),
            'countServicesResults' => $this->countServicesResults($dataProvider),
            'countIndustriesResults' => $this->countIndustriesResults($queryIndustries),
            'countActionsResults' => $this->countActionsResults($queryActions),
            'countObjectsResults' => $this->countObjectsResults($queryObjects),
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->trigger(self::EVENT_CONTACT_US);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Displays log page.
     *
     * @return mixed
     */
    public function actionLog()
    {
        $log = \common\models\Log::find()->orderBy(['id'=>SORT_DESC])->limit(15)->all();
        return $this->render('log', [
                'logs' => $log,
            ]);
    }

    /**
     * Displays Permanent page.
     *
     * @return mixed
     */
    public function actionPermanent()
    {
        /** @var User $user */
        $user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
        ]);

        if ($user->load(\Yii::$app->request->post()) && $user->create()) {
            return $this->redirect(['log']);
        }

        return $this->render('permanent', ['user' => $user,]);
    }

    public function countSearchResults($dataProvider, $queryObjects, $queryIndustries, $queryActions) 
    {
        return ($dataProvider ? $dataProvider->totalCount : 0)+($queryIndustries ? $queryIndustries->totalCount : 0)+($queryActions ? $queryActions->totalCount : 0)+($queryObjects ? $queryObjects->totalCount : 0);
    }

    public function countServicesResults($dataProvider) 
    {
        return $dataProvider ? $dataProvider->totalCount : 0;
    }

    public function countIndustriesResults($queryIndustries) 
    {
        return $queryIndustries ? $queryIndustries->totalCount : 0;
    }

    public function countActionsResults($queryActions) 
    {
        return $queryActions ? $queryActions->totalCount : 0;
    }

    public function countObjectsResults($queryObjects) 
    {
        return $queryObjects ? $queryObjects->totalCount : 0;
    }

    public function afterContactUs($event){        
        $log = new Log;
        $log->logEvent(19);
    }
}
