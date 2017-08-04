<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\widgets\ActiveField;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';

?>
<div class="site-login">

    <?php $form = ActiveForm::begin() ?>
    <div class="container">


        <div class="omb_login ">
            <h3 class="omb_authTitle">Login or <a href="signup">Sign up</a></h3>
            <div class="row omb_row-sm-offset-3 omb_socialButtons mycenter">
                <div class="col-xs-4 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block omb_btn-facebook">
                        <i class="fa fa-facebook visible-xs"></i>
                        <span class="hidden-xs">Facebook</span>
                    </a>
                </div>

                <div class="col-xs-4 col-sm-2">
                    <a href="#" class="btn btn-lg btn-block omb_btn-google">
                        <i class="fa fa-google-plus visible-xs"></i>
                        <span class="hidden-xs">Google+</span>
                    </a>
                </div>
            </div>
            <div class="row omb_row-sm-offset-3 omb_loginOr">
                <div class="col-xs-12 col-sm-6">
                    <hr class="omb_hrOr">
                    <span class="omb_spanOr">or</span>
                </div>
            </div>
            <div class="row omb_row-sm-offset-3">
                <div class="col-xs-12 col-sm-6">
                    <form class="omb_loginForm" action="" autocomplete="off" method="POST">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<!--                            <input type="text" class="form-control" name="username" placeholder="Login">-->
                            <?= $form->field($user, 'user_login') ?>
                        </div>
                        <span class="help-block"></span>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input  type="password" class="form-control" name="password" placeholder="Password">
                            <?= $form->field($user, 'user_password')->passwordInput() ?>
                        </div>
                        <br>

                        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                    </form>
                </div>
            </div>
            <div class="row omb_row-sm-offset-3">
                <div class="col-xs-12 col-sm-3"></div>
                <div class="col-xs-12 col-sm-3">
                    <p class="omb_forgotPwd">
                        <a href="#">Forgot password?</a>
                    </p>
                </div>
            </div>
        </div>



    </div>
    <?php $form = ActiveForm::end() ?>

</div>
