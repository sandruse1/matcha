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
use kartik\slider\Slider;
use Codeception\Module\AngularJS;
use \yii\web\JsExpression;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Search';
?>


<div class="search">
    <div class="container">

<!---------------SEARCH MENU---------------->

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="form-section">
                    <div class="row">
                        <?php $form = ActiveForm::begin() ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <b class="badge">Sex</b>
                                <?php $search->user_sex = 1; ?>
                                <?= $form->field($search, 'user_sex')->dropDownList(['1'=>'Male', '0' =>'Female'])->label(false) ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <b class="badge">Sexual orientation</b>
                                <?php $search->user_orientation = 1; ?>
                                <?= $form->field($search, 'user_orientation')->dropDownList(['1'=>'Heterosexual', '0' =>'Homosexual', '2' => 'Bisexual'])->label(false); ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class=" form-group">
                                <b class="badge">Age : From 18 To 80</b>
                                <?=
                                $form->field($search, 'user_age')->widget(Slider::className(), [
                                    'name'=>'age',
                                    'value'=>'18,25',
                                    'sliderColor'=>Slider::TYPE_GREY,
                                    'pluginOptions'=>[
                                        'min'=>18,
                                        'max'=>80,
                                        'step'=>1,
                                        'range'=>true
                                    ]])->label(false);
                                ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class=" form-group">
                                <b class="badge">Rating : From 0 To 100</b>
                                <?=
                                $form->field($search, 'user_rating')->widget(Slider::className(), [
                                    'name'=>'rating_3',
                                    'value'=>'0,50',
                                    'sliderColor'=>Slider::TYPE_GREY,
                                    'pluginOptions'=>[
                                        'min'=>0,
                                        'max'=>100,
                                        'step'=>5,
                                        'range'=>true
                                    ]])->label(false);
                                ?>
                            </div>
                        </div>
<!--                        ->widget(MaskedInput::className(),['mask'=>'+38 (999) 999-99-99'])-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <b class="badge">Interest and hobby</b>
                                <?= $form->field($search, 'user_interest')->textInput([ 'placeholder' => '#sport #party #girls', 'class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <b class="badge">Location</b>
                                <?php
                                $onChangeJs= <<<JS
                             if ($(this).find('input:checked').val() == 0){
                                 $("#bydistance").removeClass("hide");
                             } else {
                                 $("#bydistance").addClass("hide");
                             }
JS;
                             ?>
                                <?php $search->user_location = 1; ?>
                                <?= $form->field($search, 'user_location')->radioList(['1'=>'Near you', '0' =>'By distance '], [
                                    'onchange' => new \yii\web\JsExpression($onChangeJs)
                                ])->label(false) ?>
                            </div>

                            <div id="bydistance"  class="hide form-group">
                                <b class="badge">Distance : From 0 To 160 </b>
                                <?= $form->field($search, 'user_distance')->widget(Slider::className(), [
                                        'name'=>'distance',
                                        'value'=>'0,60',
                                        'sliderColor'=>Slider::TYPE_GREY,
                                        'pluginOptions'=>[
                                            'min'=>0,
                                            'max'=>160,
                                            'step'=>5,
                                            'range'=>true
                                        ]])->label(false);
                                ?>
                            </div>
                        </div>

                        <div class="col-md-11 text-right">
                            <?= Html::submitButton('Submit', ['class' => 'btn-primary btn btn-submit', 'id' => 'accountsetSubmit']) ?>
                        </div>

                        <?php $form = ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>

<!-----------------------USER LIST------------>

        <div class="form-group">
            <div class="col-md-10 col-md-offset-1">
            <?php Pjax::begin();
            echo ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => 'usersprofile',
                'pager' => ['class' => \kop\y2sp\ScrollPager::className()]
            ]);
            Pjax::end();?>
            </div>
        </div>

<!--------------------------------------------->
    </div>
</div>



