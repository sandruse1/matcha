<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 06.08.17
 * Time: 09:10
 */
use yii\widgets\ActiveField;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;
use yii\jui\DatePicker;

$session = Yii::$app->session;
$session->open();
$this->title = $session['loged_user'];
?>
<div class="site-login">

<div class="col-md-6 col-md-offset-3">
    <div class="panel">
        <div class="panel-body">

            <div class="profile-layout">

                <div class="profile-section">

                    <div class="profile-img-section">
                        <img src="<?php echo $settings->user_avatar ?> " class="img-responsive profile-img">
                    </div>
                    <div class="text-information">
                        <h2 class="main-name"><?php echo $settings->user_name." ".$settings->user_secondname ?></h2>
                    </div>
                    <div class="tab-section">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home" ><i class="fa fa-info-circle fa-lg"></i></a></li>
                            <li><a data-toggle="tab" href="#menu1"><i class="fa fa-users fa-lg"></i></a></li>
                            <li><a data-toggle="tab" href="#menu2"><i class="fa fa-key fa-lg"></i></a></li>
                            <li><a data-toggle="tab" href="#menu3"><i class="fa fa-picture-o fa-lg"></i></a></li>
                            <li><a data-toggle="tab" href="#menu4"><i class="fa fa-map-marker fa-lg"></i></a></li>
                        </ul>
                        <?php if (Yii::$app->session->hasFlash('success')): ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo Yii::$app->session->getFlash('success'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">

                                <div class="info-section no-edit-forms">
                                    <?php $form = ActiveForm::begin() ?>
                                    <div class="form-group text-right">
                                        <a class="label label-info " id="edit-info">Edit</a>
                                        <a class="label label-info hide" id="cancel-info">Cancel</a>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($settings, 'user_name')->textInput([ 'placeholder' => 'name', 'class' => 'form-control']) ?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($settings, 'user_secondname')->textInput([ 'placeholder' => 'Second name', 'class' => 'form-control']) ?>
                                    </div>
                                    <div class="form-group">
                                            <?=$form->field($settings,'user_phone')->widget(MaskedInput::className(),['mask'=>'+38 (999) 999-99-99'])->textInput(['placeholder'=>'+38 (999) 999-99-99','class'=>'form-control']);?>
                                    </div>

                                    <div class="form-group">
                                        <?= $form->field($settings, 'user_login')->textInput([ 'placeholder' => 'Login', 'class' => 'form-control']) ?>
                                    </div>

                                    <div class="form-group">
                                            <?= $form->field($settings, 'user_email')->textInput(['placeholder'=>'Email','class'=>'form-control']) ?>
                                    </div>

                                    <div class="form-group">
                                        <?= $form->field($settings,'user_day_of_birth')->widget(yii\jui\DatePicker::className(),['clientOptions' => ['dateFormat' => 'd.m.yy', 'yearRange' => '1956:2016','changeMonth' => 'true', 'changeYear' => 'true',] ,])->textInput(['class'=>'form-control']) ?>
                                    </div>

                                    <div class="form-group">
                                        <?= $form->field($settings, 'user_interest')->textInput([ 'placeholder' => '#sport #party #girls', 'class' => 'form-control']) ?>
                                    </div>

                                    <div class="form-group">
                                        <?= $form->field($settings, 'user_about')->textInput([ 'placeholder' => 'I am ...', 'class' => 'form-control'])->textarea(['rows' => 10]) ?>
                                    </div>

                                    <div class="text-right">
                                        <?= Html::submitButton('Submit', ['class' => 'btn-primary btn btn-submit hide', 'id' => 'accountsetSubmit']) ?>
                                    </div>
                                    <?php $form = ActiveForm::end() ?>
                                </div>
                            </div>


                            <div id="menu1" class="tab-pane fade">

                                <div class="friend-list">
                                    <div class="media">
                                        <a href="#">
                                            <div class="media-left">
                                                <img src="https://media.licdn.com/mpr/mpr/shrink_100_100/AAEAAQAAAAAAAAZhAAAAJGE3YjFiNGMwLWQ1NzQtNDY0ZS04ZjI2LWNjM2IwMGExNTQxNw.jpg" class="media-object" style="width:60px">
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">Santosh Singh</h4>
                                                <p>UI  Developer</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="media">
                                        <a href="#">
                                            <div class="media-left">
                                                <img src="https://media.licdn.com/mpr/mpr/shrinknp_400_400/AAEAAQAAAAAAAAzoAAAAJGM2OWJjMGEzLTQ3ZjItNDYzMy1hMDJkLTZkODc0NDI0YWZlNQ.jpg" class="media-object" style="width:60px">
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">Sagar Saini</h4>
                                                <p>UI  Developer</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="media">
                                        <a href="#">
                                            <div class="media-left">
                                                <img src="https://lh6.googleusercontent.com/-FQt6RptkvQI/AAAAAAAAAAI/AAAAAAAAAAA/RS9O9VEXTXc/s128-c-k/photo.jpg" class="media-object" style="width:60px">
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">Prakhar Mathur</h4>
                                                <p>UI Developer</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div id="menu2" class="tab-pane fade">
                                <?php $form1 = ActiveForm::begin() ?>

                                <div class="form-group">
                                    <?= $form1->field($passwords, 'user_password')->passwordInput() ?>
                                </div>
                                <div class="form-group">
                                    <?= $form1->field($passwords, 'user_rep_password')->passwordInput() ?>
                                </div>
                                <div class="text-right">
                                    <?= Html::submitButton('Submit', ['class' => 'btn-primary btn btn-submit', 'id' => 'accountpassSubmit']) ?>
                                </div>
                                <?php $form1 = ActiveForm::end() ?>
                            </div>



                            <div id="menu3" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-6 shine_me">
                                        <img src="http://lorempixel.com/output/food-q-c-320-240-2.jpg" class="img-responsive"/>
                                        <i class="shine_effect"></i>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-6 shine_me">
                                        <img src="http://lorempixel.com/output/food-q-c-320-240-4.jpg" class="img-responsive"/>
                                        <i class="shine_effect"></i>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-6 shine_me">
                                        <img src="http://lorempixel.com/output/food-q-c-320-240-1.jpg" class="img-responsive"/>
                                        <i class="shine_effect"></i>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-6 shine_me">
                                        <img src="http://lorempixel.com/output/food-q-c-320-240-1.jpg" class="img-responsive"/>
                                        <i class="shine_effect"></i>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-6 shine_me">
                                        <img src="http://lorempixel.com/output/food-q-c-320-240-2.jpg" class="img-responsive"/>
                                        <i class="shine_effect"></i>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-6 shine_me">
                                        <img src="http://lorempixel.com/output/food-q-c-320-240-4.jpg" class="img-responsive"/>
                                        <i class="shine_effect"></i>
                                    </div>
                                </div>
                            </div>

                            <div id="menu4" class="tab-pane fade">
                                <div class="form-group text-center">
                                    <h4> <i class="fa fa-map-marker " aria-hidden="true"></i> <?php echo $settings->user_geolocation?></h4>
                                    <br>
                                    <div class="text-right">
                                        <a class="btn btn-primary btn-submit">Change location</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

