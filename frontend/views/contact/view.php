<?php

use common\models\shop\ActivePages;
use frontend\assets\ContactPageAsset;
use common\models\Contact;

/** @var Contact $contacts */

ContactPageAsset::register($this);
ActivePages::setActiveUser();

$h1 = 'Зв’язок з нами';
$breadcrumbItemActive = 'Зв’язок з нами';

?>
<div class="site__body">
    <?= $this->render('/_partials/page-header',
        [
            'h1' => $h1,
            'breadcrumbItemActive' => $breadcrumbItemActive,

        ]) ?>
    <div class="block">
        <div class="container">
            <div class="card mb-0 contact-us">
                <div class="card-body">
                    <div class="contact-us__container">
                        <div class="row">
                            <div class="col-12 col-lg-6 pb-4 pb-lg-0">
                                <h4 class="contact-us__header card-title"><?= Yii::t('app', 'Наша адреса') ?></h4>
                                <div class="contact-us__address">
                                    <p>
                                        <?= $contacts->address ?><br>
                                        Email: <?= $contacts->email ?><br><br>
                                        <span style="font-weight: bold"><?= Yii::t('app', 'Телефон') ?>:</span>
                                        <span class="phone-number"><?= $contacts->tel_primary ?></span><br>
                                        <span class="phone-number"
                                              style="padding-left: 80px; margin-top: -15px;"> <?= $contacts->tel_second ?></span>
                                    </p>
                                    <p>
                                        <strong><?= Yii::t('app', 'Години роботи') ?></strong><br>
                                        <?= $contacts->hours_work ?>
                                    </p>
                                    <p>
                                        <?= $contacts->coments ?>
                                    </p>
                                </div>
                            </div>
                            <?= $this->render('message') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="spec__disclaimer">
                <?= $page_description ?>
            </div>
        </div>
    </div>
</div>
<style>
    .phone-number {
        color: #47991f;
        font-weight: bold;
        font-size: 24px;
    }
</style>