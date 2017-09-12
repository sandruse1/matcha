<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 12.09.17
 * Time: 14:30
 */
$session = Yii::$app->session;
?>

<script>
    var dupa;
    $(window).on('click', function(event){
       let modal = document.getElementById('myModal');
       let close = document.getElementById('closeDupa');

       if (event.target == modal || event.target == close) {
            clearInterval(dupa);
       }
    });

    function sendMessage(loged_user, id_chatwith)
    {

        var text = $('#message_text').val();
        $(`
            <div style="background: yellow" class="message-candidate center-block form-group">
                        <div class="row">
                            <div class="col-xs-8 col-md-6">
                                <img style="width: 100px; height: 100px" src="<?= $session['user_avatar']?>" class="img-rounded">
                                <h4 class="message-name">${loged_user}</h4>
                            </div>
                            <div class="col-xs-4 col-md-6 text-right message-date"><?= date("d.m.y G:i:s");?></div>
                            <div class=" message-text form-group">
                                <p>${text}</p>
                            </div>
                        </div>
                 </div>
        `).appendTo($('.put-all-message'));
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/account/addnewmessage' ?>',
            type: 'post',

            data: {loged_user: loged_user, id_chatwith:id_chatwith , text:text}
        });
    }
    function handelNewMessages(loged_user, id_chatwith) {
        dupa = setInterval(function(){
            $.ajax({
                url: '<?php echo Yii::$app->request->baseUrl. '/account/getmessage' ?>',
                type: 'post',
                dataType: 'json',
                data: {loged_user: loged_user, id_chatwith:id_chatwith},
                success: function (data) {
                    if (data.length > $('.message-candidate').length) {
                        for (var i = $('.message-candidate').length; i < data.length; i++){
                            let arr = data[i].split(' ');
                            let [text, date, time, nickname, avatar] = arr;

                            $(`
                            <div style="background: yellow" class="message-candidate center-block form-group">
                                <div class="row">
                                    <div class="col-xs-8 col-md-6">
                                        <img style="width: 100px; height: 100px" src=${avatar} class="img-rounded">
                                        <h4 class="message-name">${nickname}</h4>
                                    </div>
                                    <div class="col-xs-4 col-md-6 text-right message-date">${date} ${time}</div>
                                    <div class=" message-text form-group">
                                        <p>${text}</p>
                                    </div>
                                </div>
                         </div>
                        `).appendTo($('.put-all-message'));
                        }
                    }
                }
            });
        }, 1000);
    }
    function getMessage(loged_user, id_chatwith)
    {
        handelNewMessages(loged_user, id_chatwith);
        $('.message-candidate').remove();
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/account/getmessage' ?>',
            type: 'post',
            dataType: 'json',
            data: {loged_user: loged_user, id_chatwith:id_chatwith},
            success: function (data) {
                if (data) {
                    data.forEach(function (value) {
                        let arr = value.split(' ');
                        let [text, date, time, nickname, avatar] = arr;

                        $(`
                            <div style="background: yellow" class="message-candidate center-block form-group">
                                <div class="row">
                                    <div class="col-xs-8 col-md-6">
                                        <img style="width: 100px; height: 100px" src=${avatar} class="img-rounded">
                                        <h4 class="message-name">${nickname}</h4>
                                    </div>
                                    <div class="col-xs-4 col-md-6 text-right message-date">${date} ${time}</div>
                                    <div class=" message-text form-group">
                                        <p>${text}</p>
                                    </div>
                                </div>
                         </div>
                        `).appendTo($('.put-all-message'));
                    })
                }
            }
        });
    }
</script>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 text-center well well-sm">
    <br>
    <img style="width: 200px; height: 200px" src="<?php echo $model['user_avatar']?>" alt="" class="img-responsive img-rounded" />

        <h3><?php echo $model['user_name']." ".$model['user_secondname']; ?></h3>
        <?php
            $date_now =  date_create('now',new DateTimeZone('Europe/Kiev'));
            $date_online = date_create_from_format("d.m.y G:i", $model['last_online']);
            $diff = date_diff($date_now, $date_online);
            ?>
        <?php if ($diff->format('%i%d%D%M%Y') < 150000000) : ?>
            <h3><span style="background: rgb(66, 183, 42); border-radius: 50%; display: inline-block; height: 9px; margin-left: 4px; margin-bottom: 2px; width: 9px;"></span> Online</h3>
        <?php else: ?>
            <p><span style="background: rgb(255,51, 51); border-radius: 50%; display: inline-block; height: 9px; margin-left: 4px; margin-bottom: 2px; width: 9px;"></span> last seen <?php echo $model['last_online']; ?> </p>
        <?php endif;?>

    <button type="button" onclick="getMessage('<?=$session['loged_user']?>','<?=$model['user_id']?>')" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal">Chat</button>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" id="closeDupa">×</span></button>
            </div>
            <div class="modal-body form-group put-all-message">








            </div>
            <div class="messaging center-block">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input id="message_text" type="text" class="form-control">
                            <span class="input-group-btn">
                                <
                                        <button id="send_button" onclick="sendMessage('<?=$session['loged_user']?>','<?=$model['user_id']?>')" class="btn btn-default" type="button">Send</button>
                                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
