<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\User;


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
        $user_table = Yii::$app->db->createCommand('
          CREATE TABLE IF NOT EXISTS `user` (
          `user_id` INT (11) UNSIGNED NOT NULL AUTO_INCREMENT,
          `user_name` VARCHAR (100) NOT NULL ,
          `user_secondname` VARCHAR (100) NOT NULL,
          `user_email` VARCHAR (100) NOT NULL,
          `user_login` VARCHAR (20) NOT NULL,
          `user_password` VARCHAR (1000) NOT NULL,
          `user_rep_password` VARCHAR (1000) NOT NULL,
          `user_sex` INT (1)  DEFAULT \'0\',
          `user_photo` VARCHAR (500) DEFAULT \' \',
          PRIMARY KEY (`user_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ');
        $user_table->query();
        return $this->render('index');
    }

    public function actionContact()
    {
        return $this->render('contact');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionLogin()
    {
        $user = new User();
//        if ($user->load(Yii::$app->request->post())){
//            $post = Yii::$app->request->post('User');
//            $post = $post['user_login'];
//            $my_request = User::find()->asArray()->where(['user_login' => $post])->all();
//            if ($my_request == NULL) {
//                if ($user->save()) {
//                    Yii::$app->session->setFlash('success', 'You have successfully signed up, now you can login to Matcha');
//                    return $this->refresh();
//                }else {
//                    Yii::$app->session->setFlash('error',  'Please fill in all the fields correctly');
//                }
//            }else {
//                Yii::$app->session->setFlash('error', 'Such login already registered');
//            }
//        }
        return $this->render('login', compact('user'));
    }

    public function actionSignup()
    {
        $user = new User();
        if ($user->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post('User');
            $user->user_password = Yii::$app->getSecurity()->generatePasswordHash($user->user_password);
            $user->user_rep_password = Yii::$app->getSecurity()->generatePasswordHash($user->user_rep_password);
            $post = $post['user_login'];
            $my_request = User::find()->asArray()->where(['user_login' => $post])->all();
            if ($my_request == NULL) {
                if ($user->save()) {
                    Yii::$app->session->setFlash('success', 'You have successfully signed up, now you can login to Matcha');
                    return $this->refresh();
                }else {
                    Yii::$app->session->setFlash('error',  'Please fill in all the fields correctly');
                }
            }else {
                Yii::$app->session->setFlash('error', 'Such login already registered');
            }
        }
        return $this->render('signup', compact('user'));
    }

}
