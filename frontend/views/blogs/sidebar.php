<?php

use frontend\widgets\TagCloud;

?>
<div class="col-12 col-lg-4">
    <div class="block block-sidebar block-sidebar--position--end">
        <div class="block-sidebar__item">
            <div class="widget-search">
                <form class="widget-search__body" action="/blogs/view">
                    <input class="widget-search__input" name="q"
                           placeholder="<?= Yii::t('app', 'Пошук статтів...') ?>" type="text"
                           autocomplete="off" spellcheck="false">
                    <button class="search__button widget-search__button" type="submit">
                        <svg width="20px" height="20px">
                            <use xlink:href="/images/sprite.svg#search-20"></use>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        <?php echo TagCloud::widget() ?>
    </div>
</div>
