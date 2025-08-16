<?php

use common\models\shop\ActivePages;
use frontend\assets\ContactPageAsset;
use common\models\Contact;

/** @var Contact $contacts */

ContactPageAsset::register($this);
ActivePages::setActiveUser();

?>
<div class="site__body">
    <div class="page-header">
        <div class="page-header__container container">
            <div class="page-header__breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/"> <i class="fas fa-home"></i> <?= Yii::t('app', 'Головна') ?></a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active"
                            aria-current="page"><?= Yii::t('app', 'Зв’язок з нами') ?></li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1><?= Yii::t('app', 'Зв’язок з нами') ?></h1>
            </div>
        </div>
    </div>
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