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
use app\models\Photo;
use app\models\Profiledata;
use app\models\Search;
use kossmoss\GoogleMaps\GoogleMaps;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\i18n\Formatter;

define('EARTH_RADIUS', 6372795);

class AccountController extends Controller
{
    public $layout = 'user';

    public function actionAccount(){



        $pictures = array();
        $session = Yii::$app->session;
        $email = $session['loged_email'];
        $settings = Accountset::findOne(['user_email' => $email]);
        $passwords = Accountpass::findOne(['user_email' => $email]);
        $photo = Photo::findOne(['user_email' => $email]);

        $session['user_avatar'] = $settings->user_avatar;
        $session['loged_user'] = $settings->user_login;
        $passwords->user_password = '';
        $passwords->user_rep_password = '';

        if ($dir = opendir("./photo/" . $settings->user_login)) {
            while (false !== ($file = readdir($dir))) {
                if ($file == "." || stristr($file, "avatar") || $file == ".." || (is_dir("./photo/" . $settings->user_login . "/" . $file))) continue;
                $pictures[] = $file;
            }
            closedir($dir);
        }

        if (array_key_exists( "Photo" , $_FILES) && $_FILES['Photo']['name']['imageUpload'] ) {

            $photo->imageUpload = UploadedFile::getInstance($photo, 'imageUpload');
            $photo->imageUpload->saveAs('photo/'.$photo->user_login."/".date("j_n_y_g_i_s").".".$photo->imageUpload->extension);
            $photo->save(false);
            return $this->refresh();
        }

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
                } else if (array_key_exists('Accountpass', $reqest)){
                    $post = Yii::$app->request->post('Accountpass');
                    if ($passwords->validate()) {
                        $passwords->user_password = Yii::$app->getSecurity()->generatePasswordHash($post['user_password']);
                        $passwords->user_rep_password = $passwords->user_password;
                        $passwords->save(false);
                        Yii::$app->session->setFlash('success', 'You have successfully changed your password');
                        return $this->refresh();
                    }
                }
            }
        return $this->render('account', compact( 'passwords', 'settings', 'pictures', 'photo'));
    }

    public function actionMessage(){

        return $this->render('message');
    }

    function getFullYears($userBirthday) { // День рождение юзера

        $birthday = strtotime($userBirthday); // Получаем unix timestamp нашего дня рождения

        $years = date('Y') - date('Y',$birthday); // Вычисляем возраст БЕЗ учета текущего месяца и дня
        $now = time(); // no comments
        $nowBirthday = mktime(0,0,0,date('m',$birthday),date('d',$birthday),date('Y')); // Получаем день рождение пользователя в этом году
        if ($nowBirthday > $now) {
            $years --; // Если дня рождения ещё не было то вычитаем один год
        }
        return $years;
    }

    public function actionProfiledata(){
        $session = Yii::$app->session;
        $session->open();

        FileHelper::createDirectory('./photo');
        if ($session['loged_email']) {
            $email = $session['loged_email'];
            $profile = Profiledata::findOne(['user_email' => $email]);
            FileHelper::createDirectory("./photo/".$profile->user_login);
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
                        $profile->user_avatar->saveAs('photo/' . $profile->user_login . "/avatar." . $profile->user_avatar->extension);
                        $profile->user_avatar = 'photo/' . $profile->user_login . "/avatar." . $profile->user_avatar->extension;
                        $session['user_avatar'] = $profile->user_avatar;
                    }

                    else{
                        if ($profile->user_facebook_id){
                            file_put_contents('photo/' . $profile->user_login . "/avatar.jpg", file_get_contents("http://graph.facebook.com/".$profile->user_facebook_id."/picture?type=large"));

                        }else{
                            file_put_contents('photo/' . $profile->user_login . "/avatar.jpg", file_get_contents(str_replace('sz=50', 'sz=750', $profile->user_avatar)));
                        }
                        $session['user_avatar'] = "photo/".$profile->user_login."/avatar.jpg";
                        $profile->user_avatar = 'photo/' . $profile->user_login . "/avatar.jpg";
                    }
                    $profile->user_day_of_birth = $post['user_day_of_birth'];

                    $profile->user_age = $this->getFullYears($post['user_day_of_birth']);

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

    function calculateTheDistance ($φA, $λA, $φB, $λB) {

        // перевести координаты в радианы
        $lat1 = $φA * M_PI / 180;
        $lat2 = $φB * M_PI / 180;
        $long1 = $λA * M_PI / 180;
        $long2 = $λB * M_PI / 180;

        // косинусы и синусы широт и разницы долгот
        $cl1 = cos($lat1);
        $cl2 = cos($lat2);
        $sl1 = sin($lat1);
        $sl2 = sin($lat2);
        $delta = $long2 - $long1;
        $cdelta = cos($delta);
        $sdelta = sin($delta);

        // вычисления длины большого круга
        $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
        $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

        //
        $ad = atan2($y, $x);
        $dist = $ad * EARTH_RADIUS;

        return $dist / 1000;
    }

    public function actionSearch(){
        $search = new Search();
        $search->user_rating = 0;
        $search->user_distance = 0;
        $session = Yii::$app->session;
        $email = $session['loged_email'];
        $loged_user = Profiledata::findOne(['user_email' => $email]);
        $reqes = Yii::$app->request->post('Search');
        $search->user_sex = ($loged_user->user_sex == 1) ? 0 : 1;

        if ($search->load(Yii::$app->request->post())) {

            $user_sex = $reqes['user_sex'];

            $user_orientation = $reqes['user_orientation'];

            $user_age = explode(",", $reqes['user_age']);
            $user_age_array = range($user_age[0], $user_age[1]);

            $user_rating = explode(",", $reqes['user_rating']);
            $user_rating_array = range($user_rating[0], $user_rating[1]);

            $user_location_param = $reqes['user_location'];

            if ($user_location_param == "1") {
                $user = \app\models\Profiledata::find()->where(['user_sex' => $user_sex, 'user_orientation' => $user_orientation,
                    'user_age' => $user_age_array, 'user_rating' => $user_rating_array, 'user_city' => $loged_user->user_city])->asArray()->all();
            } else {

                $user_distance = explode(",", $reqes['user_distance']);
                $user_distance_start = $user_distance[0];
                $user_distance_end = $user_distance[1];

                $user = \app\models\Profiledata::find()->where(['user_sex' => $user_sex, 'user_orientation' => $user_orientation,
                    'user_age' => $user_age_array, 'user_rating' => $user_rating_array])->asArray()->all();

                foreach ($user as $key => $member) {
                    $distance = $this->calculateTheDistance($member['user_latitude'], $member['user_longitude'], $loged_user->user_latitude, $loged_user->user_longitude);
                    if (!($distance >= $user_distance_start && $distance <= $user_distance_end)) {
                        unset($user[$key]);
                    }
                }
            }

            if ($reqes['user_interest'] != NULL){

                $user_interest = explode(" ", $reqes['user_interest']) ;

                foreach ($user as $key => $member) {
                    if (!(array_intersect(explode(" ", $member['user_interest']), $user_interest))){
                        unset($user[$key]);
                    }
                }
            }

            foreach ($user as $key => $member) {
                if (strcmp($member['user_login'], $loged_user->user_login) == 0){
                    unset($user[$key]);
                }
            }

        } else {

            $user_sex = ($loged_user->user_sex == 1) ? 0 : 1;
            $user_orientation = $loged_user->user_orientation;
            $user_age_array = range($loged_user->user_age - 2, $loged_user->user_age + 2);
            $user_rating_array = range(0, 100);

            $user = Profiledata::find()->where(['user_sex' => $user_sex, 'user_orientation' => $user_orientation,
                'user_age' => $user_age_array, 'user_rating' => $user_rating_array, 'user_city' => $loged_user->user_city])->asArray()->all();

        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $user,
            'pagination' => [
                'pageSize' => 12,
                'validatePage' => false,
            ],
        ]);

        return $this->render('search', compact('search', 'dataProvider'));
    }

    public function actionExit(){
        $this->redirect('http://localhost:8080/matcha/web/index');
    }

    public function actionLocationupdate(){

        $session = Yii::$app->session;
        $email = $session['loged_email'];
        $user = Profiledata::findOne(['user_email' => $email]);

        $reqest = Yii::$app->request->post();

        $user->user_latitude = $reqest['latitude']  ;
        $user->user_longitude = $reqest['longitude'];
        $user->user_country = $reqest['country'];
        $user->user_city = $reqest['city'] ;

        $user->save(false);
        Yii::$app->session->setFlash('success', 'You have successfully update your location');


    }

    public function actionLocationset(){

        $session = Yii::$app->session;
        $email = $session['loged_email'];
        $user = Profiledata::findOne(['user_email' => $email]);
        $reqest = Yii::$app->request->post();
        $user->user_latitude = $reqest['latitude']  ;
        $user->user_longitude = $reqest['longitude'];
        $user->user_country = $reqest['country'];
        $user->user_city = $reqest['city'] ;

        $user->save(false);

    }

    public function actionDeletephoto(){

        $reqes = Yii::$app->request->post();
        $src = $reqes['photo'];
        unlink(Yii::$app->basePath.'/web'.substr($src, 1));

    }

    public function actionSetasavatar(){

        $reqes = Yii::$app->request->post();

        $srctoavatar = $reqes['srctoavatar'];
        $srcfromavatar = $reqes['srcfromavatar'];
        $login = $reqes['login'];

        $type = explode('.', $srcfromavatar);
        $type = $type[1];

        $type1 = explode('.', substr($srctoavatar,1 ));
        $type1 = $type1[1];

        rename(Yii::$app->basePath.'/web/'.$srcfromavatar, Yii::$app->basePath.'/web/photo/'.$login."/".date("j_n_y_g_i_s").".".$type);
        rename(Yii::$app->basePath.'/web'.substr($srctoavatar,1 ), Yii::$app->basePath.'/web/photo/'.$login."/avatar.".$type1);
    }
}