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
<?php
$onChangeJs= <<<JS
                             if ($(this).find('input:checked').val() == 0){
                                 $("#bydistance").removeClass("hide");
                             } else {
                                 $("#bydistance").addClass("hide");
                             }
JS;
?>
<?php
$onChangeJs_rating= <<<JS
                            if ($(this).is(':checked')){
                                 $("#user_rating").removeClass("hide");
                             } else {
                                 $("#user_rating").addClass("hide");
                             }
JS;
?>
<?php
$onChangeJs_age= <<<JS
                            if ($(this).is(':checked')){
                                 $("#user_age").removeClass("hide");
                             } else {
                                 $("#user_age").addClass("hide");
                             }
JS;
?>

<script>
    function Make_like(loged_user, licked)
    {
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/account/make_like' ?>',
            type: 'post',
            data: {loged_user: loged_user, licked: licked},
            success: function (data) {
                location.href = 'http://localhost:8080/matcha/web/search';
            }
        });
    }

    function Make_dislike(loged_user, licked)
    {
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/account/make_dislike' ?>',
            type: 'post',
            data: {loged_user: loged_user, licked: licked},
            success: function (data) {
                alert(data);
            }
        });
    }

    function Make_block(loged_user, licked)
    {
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/account/make_block' ?>',
            type: 'post',
            data: {loged_user: loged_user, licked: licked},
            success: function (data) {
                location.href = 'http://localhost:8080/matcha/web/search';
            }
        });
    }

    function Make_fake(loged_user, licked)
    {
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/account/make_fake' ?>',
            type: 'post',
            data: {loged_user: loged_user, licked: licked},
            success: function (data) {
                location.href = 'http://localhost:8080/matcha/web/search';
            }
        });
    }
</script>  <!--LIKE DISLIKE BLOCK FAKE -->

<div class="search">
    <div class="container">

<!---------------SEARCH MENU---------------->

        <div class="row">
            <div class="col-md-10 col-md-offset-1" style="width: auto">
                <div class="form-section">
                    <div class="row">
                        <?php $form = ActiveForm::begin() ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <b class="badge">Sex</b>

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
                                <b class="badge">Age : </b>
                                <?=
                                $form->field($search, 'user_age')->widget(Slider::className(), [
                                    'name'=>'age',
                                    'value'=>'18,25',
                                    'sliderColor'=>Slider::TYPE_GREY,
                                    'pluginOptions'=>[
                                        'min'=>18,
                                        'max'=>80,
                                        'step'=>1,
                                        'range'=>true,
                                        'tooltip'=>'always'
                                    ]])->label(false);
                                ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class=" form-group">
                                <b class="badge">Rating :</b>
                                <?=
                                $form->field($search, 'user_rating')->widget(Slider::className(), [
                                    'name'=>'rat',
                                    'value'=>'0,10',
                                    'sliderColor'=>Slider::TYPE_GREY,
                                    'pluginOptions'=>[
                                        'orientation' => 'horizontal',
                                        'handle' => 'round',
                                        'min'=>0,
                                        'max'=>10,
                                        'step'=>0.5,
                                        'range'=>true,
                                        'tooltip'=>'always'
                                    ]])->label(false);
                                ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <b class="badge">Interest and hobby</b>
                                <?= $form->field($search, 'user_interest')->textInput([ 'placeholder' => '#sport #party #girls', 'class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <b class="badge">Location</b>
                                <?php $search->user_location = 1; ?>
                                <?= $form->field($search, 'user_location')->radioList(['1'=>'Near you (From your city)', '0' =>'By distance '], [
                                    'onchange' => new \yii\web\JsExpression($onChangeJs)
                                ])->label(false) ?>
                            </div>

                            <div id="bydistance"  class="hide form-group">
                                <b class="badge">Distance :  </b>
                                <?= $form->field($search, 'user_distance')->widget(Slider::className(), [
                                        'name'=>'distance',
                                        'value'=>'0,160',
                                        'sliderColor'=>Slider::TYPE_GREY,
                                        'pluginOptions'=>[
                                            'min'=>0,
                                            'max'=>160,
                                            'step'=>5,
                                            'range'=>true,

                                            'tooltip'=>'always'
                                        ]])->label(false);
                                ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div id="filter-panel" class="collapse filter-panel form-group">
                                <div class="panel panel-default ">
                                    <div class=" panel-body">

                                                    <div class="form-group">

                                                        <label class="" for="startDate">Interest or hobby</label>
                                                        <?= $form->field($search, 'user_interest_filter')->textInput([ 'placeholder' => '#sport', 'class' => 'form-control'])->label(false) ?>

                                                        <div class="form-group">
                                                            <?php echo $form->field($search, 'user_rating_filter_checked')->checkbox( [
                                                                'onchange' => new \yii\web\JsExpression($onChangeJs_rating)]); ?>
                                                            <div class="hide" id="user_rating">
                                                                <label class="" for="endDate">User rating</label>
                                                                <?= $form->field($search, 'user_rating_filter')->widget(Slider::className(), [
                                                                'name'=>'rating_filter',

                                                                'sliderColor'=>Slider::TYPE_SUCCESS,
                                                                'handleColor'=>Slider::TYPE_DANGER,
                                                                'pluginOptions'=>[
                                                                    'orientation' => 'horizontal',
                                                                    'handle' => 'round',
                                                                    'min'=>0,
                                                                    'max'=>10,
                                                                    'step'=>0.2,

                                                                ]])->label(false); ?>
                                                            </div>
                                                        </div>



                                                        <div class="form-group">
                                                            <?php echo $form->field($search, 'user_age_filter_checked')->checkbox([
                                                                'onchange' => new \yii\web\JsExpression($onChangeJs_age)]); ?>
                                                            <div class="hide" id="user_age">
                                                                <label class="" for="endDate">User age</label>
                                                                <?=   $form->field($search, 'user_age_filter')->widget(Slider::className(), [
                                                                'name'=>'age_filter',

                                                                'sliderColor'=>Slider::TYPE_SUCCESS,
                                                                'handleColor'=>Slider::TYPE_DANGER,
                                                                'pluginOptions'=>[
                                                                    'orientation' => 'horizontal',
                                                                    'handle' => 'round',
                                                                    'min'=>18,
                                                                    'max'=>80,
                                                                    'step'=>1,

                                                                ]])->label(false);      ?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="" for="orderBy">Order by</label>
                                                            <?= $form->field($search, 'user_order')->dropDownList(['user_age'=>'Age', 'user_rating' =>'Rating', 'user_location' =>'Location' ])->label(false) ?>
                                                            <label class="" for="orderBy">From -> To </label>
                                                            <?= $form->field($search, 'user_order_how')->dropDownList(['SORT_ASC'=>'Min -> Max', 'SORT_DESC' =>'Max -> Min'])->label(false) ?>
                                                        </div>
                                                    </div>
                                        <?= Html::submitButton('Filter', ['class' => 'btn-primary btn btn-submit btn-for-submit', 'id' => 'accountsetSubmit', 'name' => 'Filter']) ?>

                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#filter-panel">
                                <span class="glyphicon glyphicon-cog"></span> Sort & Filter
                            </button>
                            <?= Html::submitButton('Submit', ['class' => 'btn-primary btn btn-submit btn-for-submit', 'id' => 'accountsetSubmit']) ?>
                        </div>
                        <?php $form = ActiveForm::end() ?>
                    </div>
                    <br>
                </div>
            </div>
        </div>

<!-----------------------USER LIST------------>
        <br>
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



