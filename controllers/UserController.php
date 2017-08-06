<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 06.08.17
 * Time: 08:52
 */

namespace app\controllers;

use app\models\Profiledata;
use Yii;
use yii\web\Controller;

class UserController extends Controller
{
    public $layout = 'user';

    public function actionAccount(){

        return $this->render('account');
    }

    public function actionMessage(){

        return $this->render('message');
    }

    public function actionProfiledata(){
        $profile = new Profiledata();
//        if ($user->load(Yii::$app->request->post())){
//            $post = Yii::$app->request->post('User');
//            $post = $post['user_login'];
//            $my_request = User::find()->asArray()->where(['user_login' => $post])->all();
//            if ($my_request == NULL) {
//                if ($user->validate()) {
//                    $user->user_password = Yii::$app->getSecurity()->generatePasswordHash($user->user_password);
//                    $user->user_rep_password = $user->user_password;
//                    $user->save(false);
//                    Yii::$app->session->setFlash('success', 'You have successfully signed up, now you can login to Matcha');
//                    return $this->refresh();
//                }else {
//                    Yii::$app->session->setFlash('error',  'Please fill in all the fields correctly');
//                }
//            }else {
//                Yii::$app->session->setFlash('error', 'Such login already registered');
//            }
//        }
        return $this->render('profiledata', compact('profile'));
    }

    public function actionSearch(){

        return $this->render('search');
    }

    public function actionSettings(){

        return $this->render('settings');
    }

    public function actionExit(){
        $session = Yii::$app->session;
        $session['loged_user'] = '';
        $this->redirect('http://localhost:8080/matcha/web/index');
    }

}