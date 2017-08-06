<?php

namespace app\controllers;

use app\models\Login;
use phpDocumentor\Reflection\Location;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\User;
use yii\authclient\AuthAction;
use yii\helpers\Url;

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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        $session = Yii::$app->session;
        $user = new User();
        $if_exist = $user->find()->where(['user_email' => $attributes['email']])->one();

        if ($if_exist == NULL){
            $full_name = explode(" ",$attributes['name']);
            $user->user_name = $full_name[0];
            $user->user_secondname = $full_name[1];
            $user->user_email = $attributes['email'];
            $user->user_facebook_id = $attributes['id'];
            $user->save(false);
            $session['loged_user'] = $attributes;

        }
        else{
            $session['loged_user'] = $attributes;
        }
        $this->redirect('http://localhost:8080/matcha/web/profiledata');
    }

    public function actionIndex()
    {
        $user_table = Yii::$app->db->createCommand('
          CREATE TABLE IF NOT EXISTS `user` (
          `user_id` INT (11) UNSIGNED NOT NULL AUTO_INCREMENT,
          `user_name` VARCHAR (100) NOT NULL ,
          `user_secondname` VARCHAR (100) NOT NULL,
          `user_sex` INT (2),
          `user_about` VARCHAR (1000),
          `user_interest` VARCHAR (1000),
          `user_orientation` INT (2),
          `user_email` VARCHAR (100) NOT NULL,
          `user_login` VARCHAR (20) ,
          `user_avatar` VARCHAR (255),
          `user_day_of_birth` VARCHAR (15),
          `user_phone` VARCHAR (20),
          `user_photo` VARCHAR (1000),
          `user_facebook_id` BIGINT (30) UNSIGNED,
          `user_profile_complete` INT (1) DEFAULT \'0\',
          `user_password` VARCHAR (1000) ,
          `user_rep_password` VARCHAR (1000),
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
        $login = new Login();
        if ($login->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post('Login');
            $user_login = $post['user_login'];
            $user_form_pass = $post['user_password'];
            $my_request = User::find()->asArray()->where(['user_login' => $user_login])->all();
            if ($my_request) {
                $user_base_pass = $my_request[0]['user_password'];
                if (Yii::$app->getSecurity()->validatePassword($user_form_pass, $user_base_pass)) {
                    $session = Yii::$app->session;
                    $session['loged_user'] = $my_request[0]['user_name']." ".$my_request[0]['user_secondname'];
                    $this->redirect('http://localhost:8080/matcha/web/profiledata');
                } else {
                    Yii::$app->session->setFlash('error', 'The password you entered is invalid. Please try again');
                }
            }else {
                Yii::$app->session->setFlash('error', 'No such registered login');
            }
        }
        return $this->render('login', compact('login'));
    }

    public function actionSignup()
    {
        $user = new User();
        if ($user->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post('User');
            $post = $post['user_login'];
            $my_request = User::find()->asArray()->where(['user_login' => $post])->all();
            if ($my_request == NULL) {
                if ($user->validate()) {
                    $user->user_password = Yii::$app->getSecurity()->generatePasswordHash($user->user_password);
                    $user->user_rep_password = $user->user_password;
                    $user->save(false);
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

    public function actionForgot(){
        $forgot = new Login();
        if ($forgot->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post('Login');
            $post = $post['user_email'];
            $my_request = User::find()->asArray()->where(['user_email' => $post])->all();
            if ($my_request){
                $new_pass = Login::passwordGenerate();
                $user = User::findOne(['user_email' => $post]);
                $user->user_password = Yii::$app->getSecurity()->generatePasswordHash($new_pass);
                $user->user_rep_password = $user->user_password;
                $user->save();
                Yii::$app->mailer->compose()
                    ->setFrom('andrusechko@gmail.com')
                    ->setTo($post)
                    ->setSubject('Reset Password')
                    ->setTextBody("Your new password for Matchaff is - ".$new_pass)
                    ->send();
                Yii::$app->session->setFlash('success', 'We send you an e-mail message. Please check your email for further instructions');
                return $this->refresh();
            }else {
                Yii::$app->session->setFlash('error',  'No such registered E-mail address');
            }
        }
        return $this->render('forgot', compact('forgot'));
    }
}