<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\LoginForm;
use backend\models\SignupForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use backend\helpers\SiteHelper;
use yii\web\NotAcceptableHttpException;
use common\helpers\ThemeHelper;
use common\models\GhSite;
use common\models\CmsSite;
use yii\filters\AccessControl;
use common\helpers\InitHelper;
use yii\base\Object;
use common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'signup', 'flush-cache'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
    
            if (!ThemeHelper::setThemeByCode("adminlte")) {
                return false;
            }
    
            \Yii::$app->language = 'zh-CN';
    
            return true;
        } else {
            return false;
        }
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
    	
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } 
        $site_id = SiteHelper::getSiteId();
        $lang_id = SiteHelper::getLangId();
        $lang_arr = SiteHelper::getLangArr();
        $theme_arr = SiteHelper::getThemeArr();
        $features = explode(',', $theme_arr['features']);
        if (!is_array($features))
        {
            throw new NotAcceptableHttpException(\Yii::t('app', 'Undefined theme.'));
        }
        return $this->render('index',[
            'features'=>$features,
            'site_id'=>$site_id,
            'lang_id'=>$lang_id,
            'lang_arr'=>$lang_arr,
            'theme_arr'=>$theme_arr,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        \Yii::$app->language = 'zh-CN';
        $this->getView()->title = Yii::t('app', 'Login');
        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {       	
            SiteHelper::setSiteId(Yii::$app->user->id);          
            SiteHelper::setLangId();
            SiteHelper::setThemeId();
            \Yii::$app->params['cms.test_site_id'] = SiteHelper::getSiteId();
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionFlushCache()
    {
        $cache = \Yii::$app->cache;
        $cache->flush();
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $this->getView()->title = Yii::t('app', 'Register');
        $this->layout = 'blank';
        
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if (($user = $model->signup()) == true) {
                InitHelper::initSiteData($user->id);
                
                return $this->redirect(['site/login']);
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
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
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
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
