<div class="col-12 col-lg-6">
    <h4 class="contact-us__header card-title"><?= Yii::t('app', 'Залиште нам повідомлення') ?></h4>
    <div class="alert alert-success" style="display: none;" id="success-message" role="alert">
        <?= Yii::t('app', 'Вітаемо Ваше повідомлення -- надіслане !!!') ?>
    </div>
    <form id="form-messages">
        <div class="form-row">
            <div class="form-group col-md-6" id="url-message"
                 data-url-review="<?= Yii::$app->urlManager->createUrl(['contact/create']) ?>">
                <label for="messages-name"><?= Yii::t('app', 'Ваше ім’я') ?></label>
                <input type="text" name="name" class="form-control"
                       oninvalid="this.setCustomValidity('<?= Yii::t('app', 'Вкажіть будь ласка Ваше ім’я') ?>')"
                       oninput="this.setCustomValidity('')"
                       placeholder="<?= Yii::t('app', 'Як до вас звертатися') ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label for="messages-email">Email</label>
                <input type="email" name="email" class="form-control"
                       placeholder="<?= Yii::t('app', 'Ваша електронна пошта') ?>"
                       oninvalid="this.setCustomValidity('<?= Yii::t('app', 'Вкажіть будь ласка Ваш email') ?>')"
                       oninput="this.setCustomValidity('')"
                       required>
            </div>
        </div>
        <div class="form-group">
            <label for="messages-subject"><?= Yii::t('app', 'Тема повідомлення') ?></label>
            <input type="text" name="subject" class="form-control"
                   placeholder="<?= Yii::t('app', 'Про що ви хочете запитати?') ?>"
                   oninvalid="this.setCustomValidity('<?= Yii::t('app', 'Вкажіть будь ласка Тему') ?>')"
                   oninput="this.setCustomValidity('')"
                   required>
        </div>
        <div class="form-group">
            <label for="messages-messages"><?= Yii::t('app', 'Ваше повідомлення') ?></label>
            <textarea name="message" class="form-control" rows="4"
                      placeholder="<?= Yii::t('app', 'Напишіть ваше повідомлення...') ?>"
                      oninvalid="this.setCustomValidity('<?= Yii::t('app', 'Напишіть ваше запитання або повідомлення...') ?>')"
                      oninput="this.setCustomValidity('')"
                      required></textarea>
        </div>
        <button type="submit" id="messages-form-submit"
                class="btn btn-primary btn-lg"><?= Yii::t('app', 'Відправити') ?></button>
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
$('#form-messages').on('submit', function(event) {
    event.preventDefault();

    const form = this;

    const subject = $('input[name="subject"]').val();
    const name = $('input[name="name"]').val();
    const email = $('input[name="email"]').val();
    const mess = $('textarea[name="message"]').val();
    const urlMessage = $('#url-message').data('url-review');

    $.ajax({
        url: urlMessage,
        type: 'POST',
        data: {
            subject: subject,
            name: name,
            email: email,
            mess: mess
        },
        success: function(data) {
            if (data.success) {
                form.reset();

                $('#success-message').fadeIn();

                setTimeout(function() {
                    $('#success-message').fadeOut();
                }, 2500);
            }
        },
        error: function(xhr) {
            console.error('Ошибка:', xhr);
        }
    });
});
JS;
$this->registerJs($js);
?>
