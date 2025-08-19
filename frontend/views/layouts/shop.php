<?php

/** @var yii\web\View $this */

/** @var string $content */

use frontend\widgets\SiteHeader;
use frontend\widgets\SiteFooter;
use frontend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" dir="ltr">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="color-scheme" content="light only"/>
<meta name="theme-color" content="#47991f"/>
<link rel="manifest" href="/manifest.json">
<?php $this->registerCsrfMetaTags() ?>
<title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>
<?php
$page = Yii::$app->request->get('page');
$hasNoIndex = false;
foreach ($this->metaTags as $tag) {
if (str_contains($tag, 'name="robots"')) {
$hasNoIndex = true;
break;
}
}
if (!$hasNoIndex) {
if ($page !== null && intval($page) > 1) {
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, follow']);
} elseif (Yii::$app->language == 'en') {
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, follow']);
}
}
if ($hasNoIndex || ($page !== null && intval($page) > 1) || Yii::$app->language == 'en') {
foreach ($this->linkTags as $key => $tag) {
if (str_contains($tag, 'rel="canonical"')) {
unset($this->linkTags[$key]);
}
}
}
?>

<?php if (isset(Yii::$app->params['alternateUrls'])): ?>
<link rel="alternate" hreflang="uk" href="<?= Yii::$app->params['alternateUrls']['ukUrl'] ?? '' ?>"/>
<link rel="alternate" hreflang="ru" href="<?= Yii::$app->params['alternateUrls']['ruUrl'] ?? '' ?>"/>
<?php endif; ?>
<?= Yii::$app->params['schema'] ?? '' ?>
<?= Yii::$app->params['product'] ?? '' ?>
<?= Yii::$app->params['organization'] ?? '' ?>
<?= Yii::$app->params['webPage'] ?? '' ?>
<?= Yii::$app->params['blog'] ?? '' ?>
<?= Yii::$app->params['post'] ?? '' ?>
<?= Yii::$app->params['breadcrumb'] ?? '' ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="site">
        <?php echo SiteHeader::widget() ?>
        <?= $content ?>
        <?php echo SiteFooter::widget() ?>
    </div>
    <?= $this->render('quickview-modal') ?>
    <?= $this->render('cart-view-modal') ?>
    <?= $this->render('success-compare') ?>
    <?= $this->render('success-wish') ?>
    <?= $this->render('cookie-banner') ?>
    <?= $this->render('language-banner') ?>
    <?php $this->endBody() ?>
    <?php if (!YII_ENV_DEV) {
    $this->registerJsFile(
    '/js/google-tag-manager.js?v=' . PROJECT_VERSION,
    );
    } ?>
    </body>
    </html>
<?php $this->endPage() ?>