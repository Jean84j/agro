<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\bootstrap5\Html;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" dir="ltr" data-scompiler-id="0">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="format-detection" content="telephone=no"/>
        <link rel="icon" type="image/png" href="/images/favicon.png"/>
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="sa-app sa-app--desktop-sidebar-shown sa-app--mobile-sidebar-hidden sa-app--toolbar-fixed">
        <div class="sa-app__sidebar">
            <div class="sa-sidebar">
                <div class="sa-sidebar__header">
                    <a class="sa-sidebar__logo" href="/" target="_blank">
                        <div class="sa-sidebar-logo">
                            <img style="display: block;margin: -1px -7px 1px -14px; width: 153px; "
                                 src="/admin/images/logoagro-admin.png" alt="">
                            <div class="sa-sidebar-logo__caption">На сайт</div>
                        </div>
                    </a>
                </div>
                <?= $this->render('menu') ?>
            </div>
            <div class="sa-app__sidebar-shadow"></div>
            <div class="sa-app__sidebar-backdrop" data-sa-close-sidebar=""></div>
        </div>
        <div class="sa-app__content">
            <?= $this->render('toolbar') ?>
            <?= $this->render('alert-block-widgets') ?>
            <?= $content ?>
            <div class="sa-app__footer d-block d-md-flex">
                AgroPro © <?= date('Y') ?>
                <div class="m-auto"></div>
                <div>
                    <!--<a href="/">AgroPro.org.ua</a>-->
                </div>
            </div>
        </div>
        <div class="sa-app__toasts toast-container bottom-0 end-0"></div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
