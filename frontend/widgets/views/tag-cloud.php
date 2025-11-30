<?php

use yii\helpers\Url;

/** @var \common\models\shop\Tag $tags */

$symbol = '<span style="color: #de820b; font-size: 18px"># </span>';

?>
<div class="block-sidebar__item">
    <div class="widget-tags widget">
        <h4 class="widget__title"><?= Yii::t('app', 'Хмара тегів') ?></h4>
        <div class="tags tags--lg">
            <div class="tags__list">
                <?php foreach ($tags as $tag): ?>
                    <a href="<?= Url::to(['tag/view', 'slug' => $tag->slug]) ?>"><?= $symbol . $tag->name ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
