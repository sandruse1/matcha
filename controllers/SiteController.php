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
    /**
     * @inheritdoc
     */
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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        return $this->render('login');
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        return $this->render('contact');
    }

    /**
     * Displays signup page.
     *
     * @return string
     */
    public function actionSignup()
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
        $post = User::find()->asArray()->where(['user_name' => "sasfdfda"])->all();
        $user = new User();
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';

        var_dump($post);
        if ($user->load(Yii::$app->request->post())){

//            if ($user->save()){
//                Yii::$app->session->setFlash('success',  'ok');
//                return $this->refresh();
//            }else{
//                Yii::$app->session->setFlash('error',  'ko');
//            }

        }

        return $this->render('signup', compact('user'));
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
