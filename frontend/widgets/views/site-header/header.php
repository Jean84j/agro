<?php

/** @var $isMobile */
/** @var $categories */
/** @var $contacts */
/** @var $path */
/** @var $lang */
/** @var $compareList */
/** @var $wishList */

$checkoutUrl = str_contains(Yii::$app->request->url, 'checkout');

?>
<?php if ($isMobile): ?>
    <?= $this->render('mobile-header', ['checkoutUrl' => $checkoutUrl]) ?>
    <?= $this->render('mobile-menu',
        [
            'categories' => $categories,
            'contacts' => $contacts,
            'path' => $path,
            'lang' => $lang
        ]) ?>
<?php else: ?>
    <header class="site__header d-lg-block d-none">
        <div class="site-header">
            <?= $this->render('topbar',
                [
                    'path' => $path,
                    'lang' => $lang
                ]) ?>

            <?= $this->render('middle',
                [
                    'contacts' => $contacts,
                ]) ?>

            <?= $this->render('nav-panel',
                [
                    'contacts' => $contacts,
                    'compareList' => $compareList,
                    'wishList' => $wishList,
                    'checkoutUrl' => $checkoutUrl,
                ]) ?>
        </div>
    </header>
<?php endif; ?>