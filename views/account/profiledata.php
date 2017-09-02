<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\widgets\ActiveField;
use yii\widgets\MaskedInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Profile data';
 $avatar = ($profile->user_avatar) ? $profile->user_avatar : "https://cdn1.iconfinder.com/data/icons/unique-round-blue/93/user-512.png";

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


                    <?php endif; ?>

                    <div class="form-group">
                        <?php if ($profile->facebook): ?>
                            <label class="control-label">Your cover photo</label>
                            <img src="<?php echo $avatar ?>" width="250px" alt="" class="img-responsive img-thumbnail ">
                        <?php endif; ?>
                        <?php if (!($profile->facebook)): ?>
                            <?= $form->field($profile, 'user_avatar')->fileInput() ?>
                            <img src="<?php echo $avatar ?>" width="250px" alt="" class="img-responsive img-thumbnail ">
                        <?php endif; ?>

                    </div>

                    <div class="form-group">
                        <?= $form->field($profile, 'user_day_of_birth')->textInput([ 'placeholder' => '11.10.1994 (d.m.y)', 'class' => 'form-control']) ?>
                    </div>

                    <div class="form-group">
                        <?php $profile->user_sex = 1; ?>
                        <?= $form->field($profile, 'user_sex')->radioList(['1'=>'Male', '0' =>'Female']) ?>
                    </div>

                    <div class="form-group">
                        <?php $profile->user_orientation = 1; ?>
                        <?= $form->field($profile, 'user_orientation')->radioList(['1'=>'Heterosexual', '0' =>'Homosexual', '2' => 'Bisexual']) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($profile, 'user_interest')->textInput([ 'placeholder' => '#sport #party #girls', 'class' => 'form-control']) ?>
                    </div>

                    <div class="form-group">
                        <?=$form->field($profile,'user_phone')->widget(MaskedInput::className(),['mask'=>'+38 (999) 999-99-99'])->textInput(['placeholder'=>'+38 (999) 999-99-99','class'=>'form-control'])->label('Your phone number');?>
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
        <?php $form = ActiveForm::end() ?>

    </div>
</div>
