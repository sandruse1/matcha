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
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\widgets\ListView;

$session = Yii::$app->session;
$session->open();
$this->title = $session['loged_user'];

?>
<script>
    var latitude = '',
        longitude = '',
        country = '',
        city = '';

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
        });
    }
    if (latitude && longitude) {
        $.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?').done(function(location) {
            country = location.country_name;
            city = location.city;
        });
    } else {
        $.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?').done(function(location) {
            latitude = location.latitude;
            longitude = location.longitude;
            country = location.country_name;
            city = location.city;
        });
    }
<?php if($settings->user_city == NULL) :?>
    setTimeout(function(){
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/account/locationset' ?>',
            type: 'post',
            data: {latitude: latitude, longitude: longitude, country: country, city: city},
            success: function (data) {
                location.href = 'http://localhost:8080/matcha/web/account';
            }
        });
    }, 2000);
    <?php endif; ?>
</script>
<script>
    function myFunction()
    {
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/account/locationupdate' ?>',
            type: 'post',
            data: {latitude: latitude , longitude:longitude, country: country, city : city},
            success: function (data) {
                location.href = 'http://localhost:8080/matcha/web/account';
            }
        });
    }

    function deletePhoto(src)
    {
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/account/deletephoto' ?>',
            type: 'post',
            data: {photo: src},
            success: function (data) {
                location.href = 'http://localhost:8080/matcha/web/account';

            }
        });
    }

    function toAvatar(srctoavatar, srcfromavatar, login)
    {
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/account/setasavatar' ?>',
            type: 'post',
            data: {srctoavatar: srctoavatar, srcfromavatar: srcfromavatar, login: login},
            success: function (data) {
                location.href = 'http://localhost:8080/matcha/web/account';

            }
        });
    }
</script>

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
                        <h5 class="email-info"><?php echo $settings->user_country.", ".$settings->user_city?></h5>

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

                                            <?php Pjax::begin();
                                            echo ListView::widget([
                                                'dataProvider' => $dataProvider,
                                                'itemOptions' => ['class' => 'item'],
                                                'itemView' => 'notification',
                                                'pager' => ['class' => \kop\y2sp\ScrollPager::className()]
                                            ]);
                                            Pjax::end();?>

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

                                    <div class="form-group">

                                        <?php if (array_key_exists(0, $pictures) == false): ?>
                                            <img src="http://www.inserco.org/en/sites/all/modules/media_gallery/images/empty_gallery.png" class="img-responsive"/>
                                        <?php else: ?>
                                            <img src="<?php echo "./photo/".$settings->user_login."/".$pictures[0]?>" class="img-responsive"/>
                                        <?php endif; ?>

                                        <div class="form-group">
                                            <div class="panel-body">

                                                <?php if (array_key_exists(0, $pictures) == false): ?>
                                                    <?php $form3 = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                                                    <?= $form3->field($photo, 'imageUpload')->fileInput() ?>
                                                    <?= Html::submitButton('Add', ['class' => 'btn btn-md btn-hover btn-success', 'id' => 'profileSubmit']) ?>
                                                    <?php $form3 = ActiveForm::end() ?>
                                                <?php else: ?>

                                                    <button onclick="toAvatar('<?php echo "./photo/".$settings->user_login."/".$pictures[0]?>' , '<?php echo $settings->user_avatar ?>','<?php echo $settings->user_login?>' )" class="btn btn-md btn-hover btn-info">Avatar</button>
                                                    <button onclick="deletePhoto('<?php echo "./photo/".$settings->user_login."/".$pictures[0]?>')" class="btn btn-md btn-hover btn-danger">Delete</button>

                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?php if (array_key_exists(1, $pictures) == false): ?>
                                            <img src="http://www.inserco.org/en/sites/all/modules/media_gallery/images/empty_gallery.png" class="img-responsive"/>
                                        <?php else: ?>
                                            <img src="<?php echo "./photo/".$settings->user_login."/".$pictures[1]?>" class="img-responsive"/>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <div class="panel-body">

                                                <?php if (array_key_exists(1, $pictures) == false): ?>
                                                    <?php $form3 = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                                                    <?= $form3->field($photo, 'imageUpload')->fileInput() ?>
                                                    <?= Html::submitButton('Add', ['class' => 'btn btn-md btn-hover btn-success', 'id' => 'profileSubmit']) ?>
                                                    <?php $form3 = ActiveForm::end() ?>
                                                <?php else: ?>

                                                    <button onclick="toAvatar('<?php echo "./photo/".$settings->user_login."/".$pictures[1]?>' , '<?php echo $settings->user_avatar ?>','<?php echo $settings->user_login?>' )" class="btn btn-md btn-hover btn-info">Avatar</button>
                                                    <button onclick="deletePhoto('<?php echo "./photo/".$settings->user_login."/".$pictures[1]?>')" class="btn btn-md btn-hover btn-danger">Delete</button>


                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?php if (array_key_exists(2, $pictures) == false): ?>
                                            <img src="http://www.inserco.org/en/sites/all/modules/media_gallery/images/empty_gallery.png" class="img-responsive"/>
                                        <?php else: ?>
                                            <img src="<?php echo "./photo/".$settings->user_login."/".$pictures[2]?>" class="img-responsive"/>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <div class="panel-body">

                                                <?php if (array_key_exists(2, $pictures) == false): ?>
                                                    <?php $form3 = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                                                    <?= $form3->field($photo, 'imageUpload')->fileInput() ?>
                                                    <?= Html::submitButton('Add', ['class' => 'btn btn-md btn-hover btn-success', 'id' => 'profileSubmit']) ?>
                                                    <?php $form3 = ActiveForm::end() ?>
                                                <?php else: ?>

                                                    <button onclick="toAvatar('<?php echo "./photo/".$settings->user_login."/".$pictures[2]?>' , '<?php echo $settings->user_avatar ?>','<?php echo $settings->user_login?>' )" class="btn btn-md btn-hover btn-info">Avatar</button>
                                                    <button onclick="deletePhoto('<?php echo "./photo/".$settings->user_login."/".$pictures[2]?>')" class="btn btn-md btn-hover btn-danger">Delete</button>


                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?php if (array_key_exists(3, $pictures) == false): ?>
                                            <img src="http://www.inserco.org/en/sites/all/modules/media_gallery/images/empty_gallery.png" class="img-responsive"/>
                                        <?php else: ?>
                                            <img src="<?php echo "./photo/".$settings->user_login."/".$pictures[3]?>" class="img-responsive"/>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <div class="panel-body">

                                                <?php if (array_key_exists(3, $pictures) == false): ?>
                                                    <?php $form3 = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                                                    <?= $form3->field($photo, 'imageUpload')->fileInput() ?>
                                                    <?= Html::submitButton('Add', ['class' => 'btn btn-md btn-hover btn-success', 'id' => 'profileSubmit']) ?>
                                                    <?php $form3 = ActiveForm::end() ?>
                                                <?php else: ?>

                                                    <button onclick="toAvatar('<?php echo "./photo/".$settings->user_login."/".$pictures[3]?>' , '<?php echo $settings->user_avatar ?>','<?php echo $settings->user_login?>' )" class="btn btn-md btn-hover btn-info">Avatar</button>
                                                    <button onclick="deletePhoto('<?php echo "./photo/".$settings->user_login."/".$pictures[3]?>')" class="btn btn-md btn-hover btn-danger">Delete</button>


                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <?php if (array_key_exists(4, $pictures) == false): ?>
                                            <img src="http://www.inserco.org/en/sites/all/modules/media_gallery/images/empty_gallery.png" class="img-responsive"/>
                                        <?php else: ?>
                                            <img src="<?php echo "./photo/".$settings->user_login."/".$pictures[4]?>" class="img-responsive"/>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <div class="panel-body">

                                                <?php if (array_key_exists(4, $pictures) == false): ?>
                                                    <?php $form3 = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                                                    <?= $form3->field($photo, 'imageUpload')->fileInput() ?>
                                                    <?= Html::submitButton('Add', ['class' => 'btn btn-md btn-hover btn-success', 'id' => 'profileSubmit']) ?>
                                                    <?php $form3 = ActiveForm::end() ?>
                                                <?php else: ?>

                                                    <button onclick="toAvatar('<?php echo "./photo/".$settings->user_login."/".$pictures[4]?>' , '<?php echo $settings->user_avatar ?>','<?php echo $settings->user_login?>' )" class="btn btn-md btn-hover btn-info">Avatar</button>
                                                    <button onclick="deletePhoto('<?php echo "./photo/".$settings->user_login."/".$pictures[4]?>')" class="btn btn-md btn-hover btn-danger">Delete</button>


                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div id="menu4" class="tab-pane fade">
                                <div class="form-group text-center">
                                    <h4> <i class="fa fa-map-marker " aria-hidden="true"></i> <?php echo $settings->user_country.", ".$settings->user_city?></h4>
                                    <br>
                                    <div class="text-right">
                                        <a class="btn btn-primary btn-submit" onclick="myFunction()">Update location</a>
                                    </div>
                                </div>
                                <div id="map" style="width: 100%; height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    var coords = {
        lat: parseFloat(<?php echo $settings->user_latitude?>),
        lng: parseFloat(<?php echo $settings->user_longitude?>)
    }
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: coords
    });

    var marker = new google.maps.Marker({
        position: coords,
        map: map

    });
</script>