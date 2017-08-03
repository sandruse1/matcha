<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">
        <div class="row-fluid">

            <div class="span4">

                <address>
                    <p><strong>PHP Developer</strong></p>
                    <p>GitHub - <a href="https://github.com/sandruse1">github.com/sandruse1</a></p>
                    <p>E-mail - <a href="mailto:andrusechko@gmail.com" rel="nofollow">andrusechko@gmail.com</a></p>
                    <abbr title="Phone">P:</abbr> +38 095 055 53 89
                </address>
            </div>

            <div class="span8">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2539.5114631123815!2d30.46003195190407!3d50.468821393820384!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4cdd028feef55%3A0x56a851fd5d74eb7!2sUNIT+Factory!5e0!3m2!1suk!2sua!4v1501742762987" width="100%" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>

        </div>
    </div>

</div>
