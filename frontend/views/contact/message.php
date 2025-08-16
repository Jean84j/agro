<div class="col-12 col-lg-6">
    <h4 class="contact-us__header card-title"><?=Yii::t('app','Залиште нам повідомлення')?></h4>
    <div class="alert alert-success" style="display: none;" id="success-message" role="alert">
        <?=Yii::t('app','Вітаемо Ваше повідомлення -- надіслане !!!')?>
    </div>
    <form id="form-messages">
        <div class="form-row">
            <div class="form-group col-md-6" id="url-message"
                 data-url-review="<?= Yii::$app->urlManager->createUrl(['contact/create']) ?>">
                <label for="messages-name"><?=Yii::t('app','Ваше ім’я')?></label>
                <input type="text" name="name" class="form-control"
                       oninvalid="this.setCustomValidity('<?=Yii::t('app','Вкажіть будь ласка Ваше ім’я')?>')"
                       oninput="this.setCustomValidity('')"
                       placeholder="<?=Yii::t('app','Ваше ім’я')?>" required>
            </div>
            <div class="form-group col-md-6">
                <label for="messages-email">Email</label>
                <input type="text" name="email" class="form-control"
                       placeholder="<?=Yii::t('app','Адреса електронної пошти')?>"
                       oninvalid="this.setCustomValidity('<?=Yii::t('app','Вкажіть будь ласка Ваш email')?>')"
                       oninput="this.setCustomValidity('')"
                       required>
            </div>
        </div>
        <div class="form-group">
            <label for="messages-subject"><?=Yii::t('app','Тема')?></label>
            <input type="text" name=subject class="form-control"
                   placeholder="<?=Yii::t('app','Тема')?>"
                   oninvalid="this.setCustomValidity('<?=Yii::t('app','Вкажіть будь ласка Тему')?>')"
                   oninput="this.setCustomValidity('')"
                   required>
        </div>
        <div class="form-group">
            <label for="messages-messages"><?=Yii::t('app','Повідомлення')?></label>
            <textarea name=message class="form-control" rows="4"
                      oninvalid="this.setCustomValidity('<?=Yii::t('app','Напишіть будь ласка Ваше повідомлення')?>')"
                      oninput="this.setCustomValidity('')"
                      required></textarea>
        </div>
        <button type="submit" id="messages-form-submit" class="btn btn-primary btn-lg"><?=Yii::t('app','Відправити')?></button>
    </form>
</div>

<style>
    #success-message {
        position: absolute;
        top: -13%;
        left: 0;
        width: 100%;
    }

    #form-messages {
        position: relative;
    }
</style>

<?php
$js = <<<JS
    $('#form-messages').submit(function(event) {
    event.preventDefault();
    var subject = $('input[name=subject]').val();
    var name = $('input[name=name]').val();
    var email = $('input[name=email]').val();
    var mess = $('textarea[name=message]').val();
    var urlMessage = $('#url-message').data('url-review');
    if (name !== '') {
        $.ajax({
            url: urlMessage,
            type: 'post',
            data: {
                subject: subject,
                name: name,
                email: email,
                mess: mess
            },
            success: function(data) {
                $('#form-messages')[0].reset();
                 $('#success-message').fadeIn(); // Показать сообщение

    setTimeout(function() {
        $('#success-message').fadeOut(); // Скрыть сообщение после 2 секунд
    }, 2500);
            },
            error: function(data) {
                console.log("Ошибка", data);
            }
        });
    }
    return false;
});


JS;
$this->registerJs($js);

?>