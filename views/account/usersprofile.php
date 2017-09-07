<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 06.09.17
 * Time: 19:28
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 text-center well well-sm">
    <br>
    <img style="width: 300px; height: 300px" src="<?php echo $model['user_avatar']?>" alt="" class="img-responsive img-rounded" />
    <blockquote>
        <p><?php echo $model['user_name']." ".$model['user_secondname']?></p> <small><cite title="Source Title"><?php echo $model['user_country'].", ".$model['user_city']?> <i class="glyphicon glyphicon-map-marker"></i></cite></small>
    </blockquote>
    <button type="button" class="btn btn-success">Like</button>
    <button type="button" class="btn btn-danger">Dislike</button>
    <button type="button" class="btn btn-warning">Block</button>
    <button type="button" class="btn">Fake</button>

</div>




