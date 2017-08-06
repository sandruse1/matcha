<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 06.08.17
 * Time: 08:52
 */

namespace app\controllers;

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

        return $this->render('profiledata');
    }

    public function actionSearch(){

        return $this->render('search');
    }

    public function actionSettings(){

        return $this->render('settings');
    }

}