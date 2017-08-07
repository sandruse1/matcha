<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\widgets\ActiveField;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Profile data';

?>

<div class="container">
    <div class="row">
        <div class="col-md-10 ">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <form class="form-horizontal">
                <fieldset>
                    <legend>User profile form</legend>
                        <div class="form-group">
                            <?= $form->field($profile, 'user_name')->textInput([ 'placeholder' => 'name', 'class' => 'form-control']) ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($profile, 'user_secondname')->textInput([ 'placeholder' => 'Second name', 'class' => 'form-control']) ?>
                        </div>
                    <?php if ($profile->facebook): ?>
                        <div class="form-group">
                            <?= $form->field($profile, 'user_login')->textInput([ 'placeholder' => 'Login', 'class' => 'form-control']) ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($profile, 'user_password')->passwordInput([ 'placeholder' => 'Password', 'class' => 'form-control']) ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($profile, 'user_rep_password')->passwordInput([ 'placeholder' => 'Repeat Password', 'class' => 'form-control']) ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <?= $form->field($profile, 'user_avatar')->fileInput() ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($profile, 'user_day_of_birth')->textInput([ 'placeholder' => '11.10.1994 (d.m.y)', 'class' => 'form-control']) ?>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="Gender">Gender</label>
                        <?php $profile->user_sex = 1; ?>
                        <?= $form->field($profile, 'user_sex')->radioList(['1'=>'Male', '0' =>'Female'])->label(false); ?>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="sexual">Sexual orientation:</label>
                        <?php $profile->user_orientation = 1; ?>
                        <?= $form->field($profile, 'user_orientation')->radioList(['1'=>'Heterosexual', '0' =>'Homosexual', '2' => 'Bisexual'])->label(false); ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($profile, 'user_interest')->textInput([ 'placeholder' => '#sport #party #girls', 'class' => 'form-control']) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($profile, 'user_phone')->textInput([ 'placeholder' => 'Primary Phone number', 'class' => 'form-control']) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($profile, 'user_about')->textInput([ 'placeholder' => 'I am ...', 'class' => 'form-control'])->textarea(['rows' => 10]) ?>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'id' => 'profileSubmit']) ?>
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
        <div class="col-md-2 hidden-xs">
            <img src="http://websamplenow.com/30/userprofile/images/avatar.jpg" class="img-responsive img-thumbnail ">
        </div>
        <?php $form = ActiveForm::end() ?>

    </div>
</div>
