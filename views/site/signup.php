<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\widgets\ActiveField;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Sign up';

?>
<div class="site-login">

    <?php $form = ActiveForm::begin() ?>
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <form method="POST" action="#" role="form">
                        <div class="form-group">
                            <h1><?= Html::encode($this->title) ?></h1>
                        </div>

                        <?php if (Yii::$app->session->hasFlash('success')): ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo Yii::$app->session->getFlash('success'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <?= $form->field($user, 'user_name') ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($user, 'user_secondname') ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($user, 'user_email') ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($user, 'user_login') ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($user, 'user_password') ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($user, 'user_rep_password') ?>
                        </div>
                        <div class="form-group">
                            <?= Html::submitButton('Create your account', ['class' => 'btn btn-info btn-block', 'id' => 'signupSubmit']) ?>
                        </div>
                        <hr>
                        <p></p>Already have an account? <a href="login">Sign in</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $form = ActiveForm::end() ?>


</div>