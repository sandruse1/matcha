<?php

/* @var $this yii\web\View */

$this->title = 'Matcha';
?>

<div class="site-index">

    <div class="jumbotron">
        <h1>WELCOME TO MATCHA</h1>
    </div>

    <div class="body-content">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <div class="hero">
                        <h3>Discover new and interesting people nearby</h3>
                    </div>
                    <img src="people.jpg" alt="People">
                </div>

                <div class="item">
                    <div class="hero">
                        <h3>Evaluate another people <br>put it Like or Dislike</h3>
                    </div>
                    <img src="make_like.jpg" alt="like">
                </div>

                <div class="item">
                    <div class="hero">
                        <h3>If they also put like for you <br> "It's a Match!"</h3>
                    </div>
                    <img src="online_dating2_shut.jpg" alt="its a match">
                </div>

                <div class="item">
                    <div class="hero">
                        <h3>Only those who you match with <br> can chat with you</h3>
                    </div>
                    <img src="chating.jpg" alt="chat">
                </div>

            </div>
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </div>
</div>
