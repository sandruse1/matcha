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
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\UploadedFile;

class UserController extends Controller
{
    public $layout = 'user';

    public function actionAccount(){
        $session = Yii::$app->session;
        $email = $session['loged_email'];
        $profile = Profiledata::findOne(['user_email' => $email]);
        $session['loged_user'] = $profile->user_login;
        $session['user_avatar'] = $profile->user_avatar;
        return $this->render('account', compact('profile'));

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
            $profile->facebook = ($profile['user_facebook_id'] == NULL) ?  0  : 1;
            if ($profile->load(Yii::$app->request->post())) {
                $post = Yii::$app->request->post('Profiledata');
                if ($profile->validate()) {
                    $profile->user_name = $post['user_name'];
                    $profile->user_secondname = $post['user_secondname'];
                    if ($profile['user_facebook_id'] != NULL) {
                        $profile->user_login = $post['user_login'];
                        $profile->user_password = Yii::$app->getSecurity()->generatePasswordHash($post['user_password']);
                        $profile->user_rep_password = $profile->user_password;
                    }
                    $profile->user_avatar = UploadedFile::getInstance($profile, 'user_avatar');
                    $profile->user_avatar->saveAs('avatars/'.$profile->user_id.".".$profile->user_avatar->extension);
                    $profile->user_avatar = 'avatars/'.$profile->user_id.".".$profile->user_avatar->extension;
                    $profile->user_day_of_birth = $post['user_day_of_birth'];
                    $profile->user_sex = $post['user_sex'];
                    $profile->user_orientation = $post['user_orientation'];
                    $profile->user_interest = $post['user_interest'];
                    $profile->user_phone = $post['user_phone'];
                    $profile->user_about = $post['user_about'];
                    $profile->user_profile_complete = 1;
                    $profile->save(false);
                    $session['user_avatar'] = 'avatars/'.$profile->user_id;
                    return $this->render('account');
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