<?php

/** @var $isMobile */
/** @var $categories */
/** @var $contacts */
/** @var $path */
/** @var $lang */
/** @var $compareList */
/** @var $wishList */
/** @var $navLinks */
/** @var $topBarLinks */
/** @var $itemsMenu */
/** @var $avatar */

?>
<?php if ($isMobile): ?>
    <?= $this->render('mobile-header') ?>
    <?= $this->render('mobile-menu',
        [
            'categories' => $categories,
            'contacts' => $contacts,
            'itemsMenu' => $itemsMenu,
            'path' => $path,
            'lang' => $lang
        ]) ?>
<?php else: ?>
    <header class="site__header d-lg-block d-none">
        <div class="site-header">
            <?= $this->render('topbar',
                [
                    'path' => $path,
                    'topBarLinks' => $topBarLinks,
                    'lang' => $lang
                ]) ?>

            <?= $this->render('middle',
                [
                    'contacts' => $contacts,
                ]) ?>

            <?= $this->render('nav-panel',
                [
                    'contacts' => $contacts,
                    'navLinks' => $navLinks,
                    'compareList' => $compareList,
                    'wishList' => $wishList,
                    'avatar' => $avatar,
                ]) ?>
        </div>
    </header>
<?php endif; ?>