<?php
/** @var yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Yii::getAlias('@web/images/favicon.png')]);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" dir="ltr">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<!-- site -->
<div class="site">

    <!-- mobile site__header -->
          <?=$this->render('mobile-site-header')?>
    <!-- mobile site__header / end -->

    <!-- desktop site__header -->
          <?= $this->render('site-header')?>
    <!--  desktop site__header / end -->

    <?= $content ?>

    <!-- site__footer -->
          <?=$this->render('site-footer')?> 
    <!-- site__footer / end -->
    
</div>
<!-- site / end -->

<!-- quickview-modal -->
<div id="quickview-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content"></div>
    </div>
</div>
<!-- quickview-modal / end -->

<!-- mobilemenu -->
       <?=$this->render('mobilemenu')?>
<!-- mobilemenu / end -->

<!-- photoswipe -->
       <?=$this->render('photoswipe')?>
<!-- photoswipe / end -->

<?php $this->endBody() ?>

<script src="/vendor/svg4everybody/svg4everybody.min.js"></script>
<script> svg4everybody(); </script>

</body>
</html>
<?php $this->endPage() ?>