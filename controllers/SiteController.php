<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Author;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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

    public function actionIndex()
    {
        $this->redirect(['login']);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['/book']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/book']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
    * Регистрация
    */
    public function actionRegistration()
    {
        $oUser = new User();

        if ($oUser->load(Yii::$app->request->post()) && $oUser->save()) {
            if(Yii::$app->user)
                Yii::$app->user->logout();
            $oLoginForm = new LoginForm();
            $oLoginForm->username = $oUser->login;
            $oLoginForm->password = $oUser->password;
            $oLoginForm->rememberMe = true;

            $oLoginForm->login();
            return $this->redirect(['/book']);
        } else {
            return $this->render('register', [
                'oUser' => $oUser,
            ]);
        }
    }

    public function actionTest()
    {
        $aName = [
                    'Алан',
                    'Алана',
                    'Алевтина',
                    'Александр',
                    'Александра',
                    'Алексей',
                    'Алена',
                    'Али',
                    'Алико',
                    'Алина',
                    'Алиса',
                    'Алихан',
                    'Алия',
                    'Алла',
                    'Алоиз',
                    'Алсу',
                    'Альберт',
                    'Альберта',
                    'Альбина',
                    'Альвина',
                    'Альжбета',
                    'Альфия',
                    'Альфред',
                    'Альфреда',
                    'Амадей',
                    'Амадеус',
                    'Амаль',
                    'Амаяк',
                    'Амвросий',
                    'Амелия',
                    'Амина',
                    'Анастасия',
                    'Анатолий',
                    'Анвар',
                    'Ангел',
                    'Ангелина',
                    'Андоим'
        ];
        $aSName = [
            'Авдеев',
            'Агафонов', 
            'Аксёнов',
            'Александров', 
            'Алексеев', 
            'Андреев', 
            'Анисимов', 
            'Антонов', 
            'Артемьев', 
            'Архипов', 
            'Афанасьев', 
            'Баранов', 
            'Белов', 
            'Белозёров', 
            'Белоусов', 
            'Беляев', 
            'Беляков', 
            'Беспалов', 
            'Бирюков', 
            'Блинов', 
            'Блохин', 
            'Бобров', 
            'Бобылёв', 
            'Богданов', 
            'Большаков', 
            'Борисов', 
            'Брагин', 
            'Буров', 
            'Быков', 
            'Васильев'
        ];

        for($i=0; $i<500; $i++)
        {
            $oAuthor = new Author();
            $oAuthor->firstname = $aName[rand(0,36)];
            $oAuthor->lastname = $aSName[rand(0,29)];
            $oAuthor->save();
        }
    }
}
