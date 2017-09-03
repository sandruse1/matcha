<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 02.09.17
 * Time: 15:12
 */

namespace app\controllers;

use app\models\Accountpass;
use app\models\Accountset;
use app\models\Profiledata;
use Yii;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\UploadedFile;

class AccountController extends Controller
{
    public $layout = 'user';

    public function actionAccount(){
        $session = Yii::$app->session;
        $email = $session['loged_email'];
        $passwords = Accountpass::findOne(['user_email' => $email]);
        $passwords->user_password = '';
        $passwords->user_rep_password = '';
        $settings = Accountset::findOne(['user_email' => $email]);
        $session['loged_user'] = $settings->user_login;
        if ($settings->load(Yii::$app->request->post()) || $passwords->load(Yii::$app->request->post())) {


            $reqest = Yii::$app->request->post();
            if (array_key_exists('Accountset', $reqest)) {
                if ($settings->validate()) {
                    $post = Yii::$app->request->post('Accountset');
                    $settings->user_name = $post['user_name'];
                    $settings->user_secondname = $post['user_secondname'];
                    $settings->user_login = $post['user_login'];
                    $settings->user_interest = $post['user_interest'];
                    $settings->user_phone = $post['user_phone'];
                    $settings->user_about = $post['user_about'];
                    $settings->user_day_of_birth = $post['user_day_of_birth'];
                    $settings->user_email = $post['user_email'];
                    $session['loged_email'] = $post['user_email'];
                    $settings->save(false);
                    Yii::$app->session->setFlash('success', 'You have successfully update your profile');
                    return $this->refresh();
                }
            } else {
                $ip = Yii::$app->geoip->ip();
                $ip = Yii::$app->geoip->ip("208.113.83.165");
                var_dump(Yii::$app->request->u);
                die();
//                $post = Yii::$app->request->post('Accountpass');
//                if ($passwords->validate()) {
//                    $passwords->user_password = Yii::$app->getSecurity()->generatePasswordHash($post['user_password']);
//                    $passwords->user_rep_password = $passwords->user_password;
//                    $passwords->save(false);
//                    Yii::$app->session->setFlash('success', 'You have successfully changed your password');
//                    return $this->refresh();
//                }
            }


        }
        return $this->render('account', compact( 'passwords', 'settings'));

    }

    public function actionMessage(){

        return $this->render('message');
    }

    public function actionProfiledata(){
        $session = Yii::$app->session;
        $session->open();
        FileHelper::createDirectory('./avatars');
        if ($session['loged_email']) {
            $email = $session['loged_email'];
            $profile = Profiledata::findOne(['user_email' => $email]);
            $profile->facebook = ($profile['user_facebook_id'] == NULL && $profile['user_google_id'] == NULL) ?  0  : 1;
            if ($profile->load(Yii::$app->request->post())) {
                $post = Yii::$app->request->post('Profiledata');
                if ($profile->validate()) {
                    $profile->user_name = $post['user_name'];
                    $profile->user_secondname = $post['user_secondname'];
                    if ($profile['user_facebook_id'] != NULL || $profile['user_google_id'] != NULL) {
                        $profile->user_login = $post['user_login'];
                        $session['loged_user'] = $post['user_login'];
                    }
                    if (array_key_exists( "Profiledata" , $_FILES) && $_FILES['Profiledata']['name']['user_avatar']) {
                        $profile->user_avatar = UploadedFile::getInstance($profile, 'user_avatar');
                        $profile->user_avatar->saveAs('avatars/' . $profile->user_id . "." . $profile->user_avatar->extension);
                        $profile->user_avatar = 'avatars/' . $profile->user_id . "." . $profile->user_avatar->extension;
                        $session['user_avatar'] = 'avatars/'.$profile->user_id;
                    }
                    else{
                        $session['user_avatar'] = $profile->user_avatar;
                    }
                    $profile->user_day_of_birth = $post['user_day_of_birth'];
                    $profile->user_sex = $post['user_sex'];
                    $profile->user_orientation = $post['user_orientation'];
                    $profile->user_interest = $post['user_interest'];
                    $profile->user_phone = $post['user_phone'];
                    $profile->user_about = $post['user_about'];
                    $profile->user_profile_complete = 1;
                    $profile->save(false);

                    $this->redirect('http://localhost:8080/matcha/web/account');

                } else {
                    Yii::$app->session->setFlash('error', 'Please fill in all the fields correctly');
                }
            }
            $session->close();
            return $this->render('profiledata', compact('profile'));
        }else {
            $this->redirect('http://localhost:8080/matcha/web/index');
            $session->close();
        }
    }

    public function actionSearch(){

        return $this->render('search');
    }

    public function actionSettings(){

        return $this->render('settings');
    }

    public function actionExit(){
        $this->redirect('http://localhost:8080/matcha/web/index');
    }
}