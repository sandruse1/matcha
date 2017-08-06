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
            <?php $form = ActiveForm::begin() ?>
            <form class="form-horizontal">
                <fieldset>
                    <legend>User profile form</legend>
                    <?php if (1): ?>
                        <div class="form-group">
                            <?= $form->field($profile, 'user_name')->textInput([ 'placeholder' => 'name', 'class' => 'form-control']) ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($profile, 'user_secondname')->textInput([ 'placeholder' => 'Second name', 'class' => 'form-control']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (1): ?>
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
                        <input id="Upload photo" name="Upload photo" class="input-file" type="file">
                    </div>

                    <div class="form-group">
                        <?= $form->field($profile, 'user_day_of_birth')->textInput([ 'placeholder' => '11.10.1994 (d.m.y)', 'class' => 'form-control']) ?>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="Gender">Gender</label>
                            <input type="radio" name="Gender" id="Gender-0" value="1" checked="checked">
                            Male
                            <input type="radio" name="Gender" id="Gender-1" value="2">
                            Female
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="sexual">Sexual orientation:</label>
                            <input type="radio" name="sexual" id="radios1-0" value="1" checked="checked">
                            Bisexual
                            <input type="radio" name="sexual" id="radios1-0" value="2">
                            Heterosexual
                            <input type="radio" name="sexual" id="radios1-0" value="2">
                            Homosexual
                    </div>

                    <div class="form-group">
                        <?= $form->field($profile, 'user_interest')->textInput([ 'placeholder' => '#sport #party #girls', 'class' => 'form-control']) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($profile, 'user_phone')->textInput([ 'placeholder' => 'Primary Phone number', 'class' => 'form-control']) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($profile, 'user_phone')->textInput([ 'placeholder' => 'Email Address', 'class' => 'form-control']) ?>
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
