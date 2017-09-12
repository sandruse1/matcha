<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 06.08.17
 * Time: 09:09
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
?>
<div class="search">
    <div class="container">
    <div class="form-group">

        <div class="col-md-10 col-md-offset-1">
            <?php Pjax::begin();
                echo ListView::widget([ 'dataProvider' => $dataProvider, 'itemOptions' => ['class' => 'item'], 'itemView' => 'chatlist',  'pager' => ['class' => \kop\y2sp\ScrollPager::className()]]);
            Pjax::end();?>
        </div>

    </div>
    </div>
</div>
