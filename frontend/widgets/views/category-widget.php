<?php
use yii\helpers\Url;

/** @var \common\models\shop\Category[] $categories */

function renderProducts($items, $slug)
{
    if (!$items) return '';
    $output = '';
    $i = 1;
    foreach ($items as $product) {
        if ($i < 6) {
            $output .= '<li class="megamenu__item"><a href="' .
                Url::to(['product/view', 'slug' => $product->slug]) . '">' .
                $product->name . '</a></li>';
        } elseif ($i === 6) {
            $output .= '<li class="megamenu__item">
                <a href="' . Url::to(['category/catalog', 'slug' => $slug]) . '">
                    <span style="color:#30b12b;">' . Yii::t('app', 'Дивитись всі') . '...</span>
                </a>
            </li>';
        }
        $i++;
    }
    return $output;
}

$isHome = Yii::$app->request->pathInfo === '';
?>
<div class="departments <?= $isHome ? 'departments--open departments--fixed' : '' ?>"
     data-departments-fixed-by="<?= $isHome ? '.block-slideshow' : '' ?>">
    <div class="departments__body">
        <div class="departments__links-wrapper">
            <div class="departments__submenus-container"></div>
            <ul class="departments__links">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <li class="departments__item">
                            <a class="departments__item-link"
                               href="<?= Url::to(['category/' . ($category->parents ? 'children' : 'catalog'),
                                   'slug' => $category->slug]) ?>">
                                <?= $category->svg . ' ' . $category->name ?>
                                <?php if ($category->parents): ?>
                                    <svg class="departments__item-arrow" width="6" height="9">
                                        <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                <?php endif; ?>
                            </a>
                            <div class="departments__submenu departments__submenu--type--megamenu departments__submenu--size--xl">
                                <div class="megamenu megamenu--departments">
                                    <div class="megamenu__body">
                                        <div class="row">
                                            <?php if ($category->parents): ?>
                                                <?php foreach ($category->parents as $parent): ?>
                                                    <?php if ($parent->products): ?>
                                                        <div class="col-4">
                                                            <ul class="megamenu__links megamenu__links--level--0">
                                                                <li class="megamenu__item megamenu__item--with-submenu">
                                                                    <a href="<?= Url::to(['category/catalog', 'slug' => $parent->slug]) ?>">
                                                                        <?= $parent->svg . ' ' . $parent->name ?>
                                                                    </a>
                                                                    <ul class="megamenu__links megamenu__links--level--1">
                                                                        <?= renderProducts($parent->products, $parent->slug) ?>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="col-3">
                                                    <ul class="megamenu__links megamenu__links--level--0">
                                                        <li class="megamenu__item megamenu__item--with-submenu">
                                                            <a href="<?= Url::to(['category/catalog', 'slug' => $category->slug]) ?>">
                                                                <?= $category->svg . ' ' . $category->name ?>
                                                            </a>
                                                            <ul class="megamenu__links megamenu__links--level--1">
                                                                <?= renderProducts($category->products, $category->slug) ?>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <button class="departments__button">
        <svg class="departments__button-icon" width="18" height="14">
            <use xlink:href="/images/sprite.svg#menu-18x14"></use>
        </svg>
        <span style="font-weight:bold;font-size:18px">
            <?= Yii::t('app', 'Категорії товарів') ?>
        </span>
        <svg class="departments__button-arrow" width="9" height="6">
            <use xlink:href="/images/sprite.svg#arrow-rounded-down-9x6"></use>
        </svg>
    </button>
</div>