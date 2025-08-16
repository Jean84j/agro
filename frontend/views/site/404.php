<?php

use common\models\shop\ActivePages;
use frontend\assets\NotFoundPageAsset;

NotFoundPageAsset::register($this);
ActivePages::setActiveUser();

$error_page = Yii::$app->response->statusCode;

?>
<div class="site__body">
    <div class="block">
        <div class="container">
            <div class="not-found">
                <div class="not-found__404">
                    Oops! Error <?= $error_page ?>
                </div>
                <div class="not-found__content">
                    <h1 class="not-found__title"><?=Yii::t('app','Сторінку Не Знайдено')?></h1>
                    <p class="not-found__text">
                        <?=Yii::t('app','Здається, ми не можемо знайти сторінку, яку ви шукаєте')?>.<br>
                        <?=Yii::t('app','Спробуйте скористатися пошуком')?>.
                    </p>
                    <img src="/images/404.jpg" alt="Сторінку Не Знайдено">
                    <p class="not-found__text">
                        <?=Yii::t('app','Або перейдіть на головну сторінку, щоб почати все спочатку')?>.
                    </p>
                    <a class="btn btn-secondary btn-sm" href="/"><?=Yii::t('app','На Головну Сторінку')?></a>
                </div>
            </div>
        </div>
    </div>
</div>