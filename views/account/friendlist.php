<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 10.09.17
 * Time: 11:55
 */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$session = Yii::$app->session;
?>

<div class="media">
<div class="form-group">
        <div class="media-left">
            <img src="<?php echo $model['user_avatar']?>" class="media-object" style="width:60px">
        </div>
        <div class="media-body">
            <h4 class="media-heading"><?php echo $model['user_login'] ?> (<?php echo $model['user_name']." ".$model['user_secondname']?>)</h4>
            <p><?php echo $model['user_country'].", ".$model['user_city']?>, Age : <?php echo $model['user_age']?></p>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"> View </button>
            <button type="button" onclick="" class="btn btn-sm">Chat</button>
        </div>

</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                <div class="rela-block form-group">
                    <div class="rela-block profile-card">
                        <div class="profile-pic" style="background-image: url('./<?php echo $model['user_avatar']?>')" id="profile_pic">

                        </div>
                        <div class="rela-block profile-name-container">
                            <div class="rela-block user-name" id="user_name"><?php echo $model['user_name']." ".$model['user_secondname']?></div>
                            <div class="rela-block user-desc" id="user_description"><?php echo $model['user_country'].", ".$model['user_city']?></div>
                        </div>
                        <div class="rela-block profile-card-stats">
                            <div class="floated profile-stat works" id="num_age"><?php echo $model['user_age']?><br>
                            </div>
                            <div class="floated profile-stat followers" id="num_followers"><?php echo $model['user_rating']?><br>
                            </div>
                            <div class="floated profile-stat following" id="num_following"><?php echo $model['user_friend']?><br>
                            </div>
                            <br>
                            <div class="text-center help-div">
                                <p class="text-left"><strong>Interest: </strong><br>
                                    <?php echo $model['user_interest']?></p>
                            </div>
                            <div class="text-center help-div">
                                <p class="text-left"><strong>About: </strong><br>
                                    <?php echo $model['user_about']?></p>
                            </div>
                        </div>
                    </div>
                    <div class="rela-block content">
                        <?php if ($model['user_photo']) : ?>
                            <?php $photo_array = unserialize($model['user_photo']); ?>
                            <?php foreach($photo_array as $one_photo) { ?>
                                <div class="rela-inline image text-center">
                                    <img src="photo/<?php echo $model['user_login']?>/<?php echo $one_photo?>" alt="">
                                </div>
                            <?php } ?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="Make_dislike('<?php echo $session['loged_user']?>','<?php echo $model['user_id']?>')" class="btn btn-danger btn-sm">Dislike</button>
                <button type="button" onclick="Make_block('<?php echo $session['loged_user']?>','<?php echo $model['user_id']?>')" class="btn btn-warning btn-sm">Block</button>
                <button type="button" onclick="Make_fake('<?php echo $session['loged_user']?>','<?php echo $model['user_id']?>')" class="btn btn-sm">Fake</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>