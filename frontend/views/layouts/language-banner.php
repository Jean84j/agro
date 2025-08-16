<?php
if (
    Yii::$app->request->cookies->getValue('cookies_language') !== '1' &&
    Yii::$app->language !== 'uk'
):
    $styleLang = Yii::$app->devicedetect->isMobile()
        ? 'top: 8%;left: 0;right: 0;'
        : 'top: 1%;left: 86%;right: 1%;';
    ?>
    <div id="language-banner" class="language-banner" style="<?= $styleLang ?>">
        <span><?= Yii::t('app', 'Перейти на Українську?') ?></span>
        <div>
            <button id="language_uk-cookies" class="btn btn-sm btn-success language-button">
                <?= Yii::t('app', 'Так') ?>
            </button>
            <button id="language-cookies" class="btn btn-sm btn-secondary language-button">
                <?= Yii::t('app', 'Ні') ?>
            </button>
        </div>
    </div>

    <style>
        #language-banner {
            position: fixed;
            border-radius: 8px;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 10px;
            text-align: center;
            z-index: 1000;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }

        #language-banner.hidden {
            opacity: 0;
        }

        .language-button {
            margin: 5px 0 0 15px;
        }
    </style>

    <?php
    $this->registerJs(<<<JS
function hideBanner() {
    const banner = document.getElementById('language-banner');
    banner.classList.add('hidden');
    setTimeout(() => banner.remove(), 500);
}

function sendLanguageCookie(callback) {
    fetch('/site/language-cookies', {
        method: 'POST',
        headers: {
            'X-CSRF-Token': yii.getCsrfToken()
        }
    }).then(res => res.json())
      .then(data => {
          if (data.success) {
              hideBanner();
              if (typeof callback === 'function') callback();
          }
      }).catch(err => console.error('Помилка:', err));
}

document.getElementById('language_uk-cookies').addEventListener('click', function() {
    sendLanguageCookie(() => {
        const newPath = '/uk' + window.location.pathname.replace(/^\\/(en|ru|pl)/, '');
        const currentPath = window.location.pathname;
        if (newPath !== currentPath) {
            window.location.href = newPath + window.location.search;
        } else {
            window.location.reload();
        }
    });
});

document.getElementById('language-cookies').addEventListener('click', function() {
    sendLanguageCookie();
});
JS
    );
endif;
?>
