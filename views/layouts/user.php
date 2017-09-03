<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 06.08.17
 * Time: 08:52
 */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AccountAsset;

AccountAsset::register($this);

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Cinzel" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
        <link href=" https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-3dkvEK0WLHRJ7/Csr0BZjAWxERc5WH7bdeUya2aXxdU= sha512-+L4yy6FRcDGbXJ9mPG8MT/3UCDzwR9gPeyFNMCtInsol++5m3bk2bXWKdZjvybmohrAsn3Ua5x8gfLnbE1YkOg==" crossorigin="anonymous">
        <!-- Bootstrap Core CSS -->
        <!--     <link href="css/bootstrap.min.css" rel="stylesheet"> -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="wrap">
    <?php $session = Yii::$app->session; ?>
    <?php $session->open();?>
    <?php $loged_user = $session['loged_user'] ?>
    <?php $user_avatar = $session['user_avatar'] ?>
    <div class="wrap">
<?php if ($this->title != 'Profile data'): ?>
        <?php
        NavBar::begin([
            'brandLabel' => 'Matcha',
            'brandUrl' => 'http://localhost:8080/matcha/web/account',
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]); ?>
<?php endif; ?>
        <?php if ($this->title == 'Profile data'): ?>
            <?php
            NavBar::begin([
                'brandLabel' => 'Matcha',
                'brandUrl' => 'http://localhost:8080/matcha/web/account/exit',
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]); ?>
        <?php endif; ?>
    <?php if ($this->title != 'Profile data'): ?>
       <?php echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => Html::img("$user_avatar", ['width' => '20px']) ." ". "$loged_user", 'url' => ['/account/account']],
                ['label' => 'Search', 'url' => ['/account/search']],
                ['label' => 'Message', 'url' => ['/account/message']],
                ['label' => 'Exit', 'url' => ['/account/exit']],
            ],
            'encodeLabels' => false,
        ]); ?>
    <?php endif; ?>
        <?php NavBar::end(); ?>
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Matcha <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
    <?php $this->endBody() ?>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.js"></script>
    </html>
<?php $session->close();?>
<?php $this->endPage() ?>