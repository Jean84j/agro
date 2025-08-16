<?php

use common\models\shop\Brand;
use common\models\shop\Category;
use common\models\shop\Label;
use common\models\shop\Product;
use common\models\shop\Status;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\search\ProductSearch $model */
/** @var yii\widgets\ActiveForm $form */

$filterParam = Yii::$app->session->get('product_search_params');

$classButton = $filterParam ? 'btn btn-sm btn-outline-danger' : 'btn btn-sm btn-outline-secondary';
$clearFilterBtn = Html::a(
    'Скинути',
    ['clear-search-params'],
    ['class' => $classButton, 'id' => 'clear-filters-btn']
);
?>
<div class="product-search">
    <?php $form = ActiveForm::begin([
        'id' => 'product-filter-form',
        'action' => ['index'],
        'method' => 'post',
    ]); ?>
    <div class="sa-layout__sidebar mt-2">
        <div class="sa-layout__sidebar-header">
            <div class="sa-layout__sidebar-title"><i class="fas fa-filter filter-icon"></i>Фільтр
            </div>
            <button type="button" class="sa-close sa-layout__sidebar-close" aria-label="Close"
                    data-sa-layout-sidebar-close=""></button>
        </div>
        <div class="sa-layout__sidebar-body sa-filters scrollable_sidebar-body">
            <ul class="sa-filters__list">
                <li class="sa-filters__item">
                    <div class="sa-filters__item-body">
                        <ul class="list-unstyled m-0 mt-n2">
                            <li>
                                <?= $clearFilterBtn ?>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sa-filters__item">
                    <div class="sa-filters__item-title label-color-filter card"
                         data-sa-collapse-filter-trigger
                         data-filter-id="filter-search"
                    >
                        <span class="filter-name"><i class="fas fa-search filter-icon"></i>Пошук</span>
                    </div>
                    <div class="sa-filters__item-body"
                         data-sa-collapse-filter-content
                         style="max-height"
                    >
                        <ul class="list-unstyled m-0 mt-n2">
                            <li>
                                <label class="d-flex align-items-center pt-2">
                                    <input
                                            type="text"
                                            class="form-control m-0 me-3 fs-exact-16"
                                            name="filter-search"
                                            value="<?= $filterParam['filter-search'] ?? '' ?>"
                                    />
                                </label>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sa-filters__item">
                    <div class="sa-filters__item-title label-color-filter card"
                         data-sa-collapse-filter-trigger
                         data-filter-id="categories"
                    >
                        <span class="filter-name"><i class="fas fa-tasks filter-icon"></i>Категорії</span>
                    </div>
                    <div class="sa-filters__item-body"
                         data-sa-collapse-filter-content
                         style="max-height"
                    >
                        <ul class="list-unstyled m-0 mt-n2">
                            <?php
                            $categories = Category::find()
                                ->alias('c')
                                ->select(['c.name', 'c.id'])
                                ->innerJoin('product p', 'p.category_id = c.id')
                                ->where(['c.visibility' => 1])
                                ->distinct()
                                ->orderBy(['c.name' => SORT_ASC])
                                ->all();
                            foreach ($categories as $category): ?>
                                <li>
                                    <label class="d-flex align-items-center pt-2">
                                        <input
                                                type="checkbox"
                                                class="form-check-input m-0 me-3 fs-exact-16"
                                                name="category[]"
                                                value="<?= Html::encode($category->id) ?>"
                                            <?= isset($filterParam['category']) && in_array($category->id, $filterParam['category']) ? 'checked' : '' ?>
                                        />
                                        <?= $category->name ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
                <li class="sa-filters__item">
                    <div class="sa-filters__item-title label-color-filter card"
                         data-sa-collapse-filter-trigger
                         data-filter-id="status"
                    >
                        <span class="filter-name"><i class="far fa-bookmark filter-icon"></i>Статус</span>
                    </div>
                    <div class="sa-filters__item-body"
                         data-sa-collapse-filter-content
                         style="max-height"
                    >
                        <ul class="list-unstyled m-0 mt-n2">
                            <?php foreach (Status::find()->all() as $stat): ?>
                                <li>
                                    <label class="d-flex align-items-center pt-2">
                                        <input
                                                type="radio"
                                                class="form-check-input m-0 me-3 fs-exact-16"
                                                name="status"
                                                value="<?= Html::encode($stat->id) ?>"
                                            <?= isset($filterParam['status']) && $filterParam['status'] == $stat->id ? 'checked' : '' ?>
                                        />
                                        <?= $stat->name ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
                <li class="sa-filters__item">
                    <div class="sa-filters__item-title label-color-filter card"
                         data-sa-collapse-filter-trigger
                         data-filter-id="date-update"
                    >
                        <span class="filter-name"><i class="far fa-calendar-alt filter-icon"></i>Дата оновлення</span>
                    </div>
                    <div class="sa-filters__item-body"
                         data-sa-collapse-filter-content
                         style="max-height"
                    >
                        <ul class="list-unstyled m-0 mt-n2">
                            <?php foreach ([11 => 'Від давніх', 22 => 'Від останніх'] as $value => $label): ?>
                                <li>
                                    <label class="d-flex align-items-center pt-2">
                                        <input
                                                type="radio"
                                                class="form-check-input m-0 me-3 fs-exact-16"
                                                name="date-update"
                                                value="<?= $value ?>"
                                            <?= isset($filterParam['date-update']) && $filterParam['date-update'] == $value ? 'checked' : '' ?>
                                        />
                                        <?= $label ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
                <li class="sa-filters__item">
                    <div class="sa-filters__item-title label-color-filter card"
                         data-sa-collapse-filter-trigger
                         data-filter-id="package"
                    >
                        <span class="filter-name"><i class="fas fa-box-open filter-icon"></i>Пакування</span>
                    </div>
                    <div class="sa-filters__item-body"
                         data-sa-collapse-filter-content
                         style="max-height"
                    >
                        <ul class="list-unstyled m-0 mt-n2">
                            <?php foreach (['BIG' => 'Фермер', 'SMALL' => 'Дрібна'] as $value => $label): ?>
                                <li>
                                    <label class="d-flex align-items-center pt-2">
                                        <input
                                                type="radio"
                                                class="form-check-input m-0 me-3 fs-exact-16"
                                                name="package"
                                                value="<?= $value ?>"
                                            <?= isset($filterParam['package']) && $filterParam['package'] == $value ? 'checked' : '' ?>
                                        />
                                        <?= $label ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
                <li class="sa-filters__item">
                    <div class="sa-filters__item-title label-color-filter card"
                         data-sa-collapse-filter-trigger
                         data-filter-id="brands"
                    >
                        <span class="filter-name"><i class="far fa-copyright filter-icon"></i>Бренди</span>
                    </div>
                    <div class="sa-filters__item-body"
                         data-sa-collapse-filter-content
                         style="max-height"
                    >
                        <ul class="list-unstyled m-0 mt-n2">
                            <?php foreach (Brand::find()->all() as $brand): ?>
                                <li>
                                    <label class="d-flex align-items-center pt-2">
                                        <input
                                                type="radio"
                                                class="form-check-input m-0 me-3 fs-exact-16"
                                                name="brand"
                                                value="<?= Html::encode($brand->id) ?>"
                                            <?= isset($filterParam['brand']) && $filterParam['brand'] == $brand->id ? 'checked' : '' ?>
                                        />
                                        <?= $brand->name ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
                <li class="sa-filters__item">
                    <div class="sa-filters__item-title label-color-filter card"
                         data-sa-collapse-filter-trigger
                         data-filter-id="labels"
                    >
                        <span class="filter-name"><i class="fas fa-tags filter-icon"></i>Мітки товару</span>
                    </div>
                    <div class="sa-filters__item-body"
                         data-sa-collapse-filter-content
                         style="max-height"
                    >
                        <ul class="list-unstyled m-0 mt-n2">
                            <?php foreach (Label::find()->all() as $label): ?>
                                <li>
                                    <label class="d-flex align-items-center pt-2">
                                        <input
                                                type="radio"
                                                class="form-check-input m-0 me-3 fs-exact-16"
                                                name="labels"
                                                value="<?= Html::encode($label->id) ?>"
                                            <?= isset($filterParam['labels']) && $filterParam['labels'] == $label->id ? 'checked' : '' ?>
                                        />
                                        <span><?= $label->name ?></span>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
                <li class="sa-filters__item">
                    <div class="sa-filters__item-title label-color-filter card"
                         data-sa-collapse-filter-trigger
                         data-filter-id="price"
                    >
                        <span class="filter-name"><i class="fas fa-dollar-sign filter-icon"></i>Ціна</span>
                    </div>
                    <div class="sa-filters__item-body"
                         data-sa-collapse-filter-content
                         style="max-height"
                    >
                        <?php
                        $minPrice = round(Product::find()->min('price'), 2);
                        $maxPrice = round(Product::find()->max('price'), 2);

                        $submittedMinPrice = $filterParam['minPrice'] ?? $minPrice;
                        $submittedMaxPrice = $filterParam['maxPrice'] ?? $maxPrice;
                        ?>
                        <div class="sa-filter-range" data-min="<?= $minPrice ?>" data-max="<?= $maxPrice ?>"
                             data-from="<?= $submittedMinPrice ?>" data-to="<?= $submittedMaxPrice ?>">
                            <div class="sa-filter-range__slider"></div>
                            <input type="hidden" name="minPrice" id="minPrice" value="<?= $submittedMinPrice ?>"
                                   class="sa-filter-range__input-from"/>
                            <input type="hidden" name="maxPrice" id="maxPrice" value="<?= $submittedMaxPrice ?>"
                                   class="sa-filter-range__input-to"/>
                        </div>
                    </div>
                </li>


                <li class="sa-filters__item">
                    <div class="sa-filters__item-title label-color-filter card"
                         data-sa-collapse-filter-trigger
                         data-filter-id="seo"
                    >
                        <span class="filter-name"><i class="far fa-copyright filter-icon"></i>SEO</span>
                    </div>
                    <div class="sa-filters__item-body"
                         data-sa-collapse-filter-content
                         style="max-height"
                    >
                        <ul class="list-unstyled m-0 mt-n2">
                            <li>
                                <label class="d-flex align-items-center pt-2">
                                    <input
                                            type="radio"
                                            class="form-check-input m-0 me-3 fs-exact-16"
                                            name="seo"
                                            value="seo-title"
                                        <?= isset($filterParam['seo']) && $filterParam['seo'] == 'seo-title' ? 'checked' : '' ?>
                                    />
                                    Сео Тайтл 50 <> 70
                                </label>
                            </li>
                            <li>
                                <label class="d-flex align-items-center pt-2">
                                    <input
                                            type="radio"
                                            class="form-check-input m-0 me-3 fs-exact-16"
                                            name="seo"
                                            value="seo-description"
                                        <?= isset($filterParam['seo']) && $filterParam['seo'] == 'seo-description' ? 'checked' : '' ?>
                                    />
                                    Сео Опис 130 <> 180
                                </label>
                            </li>
                            <li>
                                <label class="d-flex align-items-center pt-2">
                                    <input
                                            type="radio"
                                            class="form-check-input m-0 me-3 fs-exact-16"
                                            name="seo"
                                            value="non-h1"
                                        <?= isset($filterParam['seo']) && $filterParam['seo'] == 'non-h1' ? 'checked' : '' ?>
                                    />
                                    Нет Н1 заголовка
                                </label>
                            </li>
                            <li>
                                <label class="d-flex align-items-center pt-2">
                                    <input
                                            type="radio"
                                            class="form-check-input m-0 me-3 fs-exact-16"
                                            name="seo"
                                            value="non-h3"
                                        <?= isset($filterParam['seo']) && $filterParam['seo'] == 'non-h3' ? 'checked' : '' ?>
                                    />
                                    Нет Н3 заголовка
                                </label>
                            </li>
                            <li>
                                <label class="d-flex align-items-center pt-2">
                                    <input
                                            type="radio"
                                            class="form-check-input m-0 me-3 fs-exact-16"
                                            name="seo"
                                            value="product-description"
                                        <?= isset($filterParam['seo']) && $filterParam['seo'] == 'product-description' ? 'checked' : '' ?>
                                    />
                                    Дескріпшен < 1000
                                </label>
                            </li>
                            <li>
                                <label class="d-flex align-items-center pt-2">
                                    <input
                                            type="radio"
                                            class="form-check-input m-0 me-3 fs-exact-16"
                                            name="seo"
                                            value=""
                                        <?= isset($filterParam['seo']) && $filterParam['seo'] == $brand->id ? 'checked' : '' ?>
                                    />
                                    Параметри *
                                </label>
                            </li>
                            <li>
                                <label class="d-flex align-items-center pt-2">
                                    <input
                                            type="radio"
                                            class="form-check-input m-0 me-3 fs-exact-16"
                                            name="seo"
                                            value="non-brand"
                                        <?= isset($filterParam['seo']) && $filterParam['seo'] == 'non-brand' ? 'checked' : '' ?>
                                    />
                                    Нет Бренда
                                </label>
                            </li>
                            <li>
                                <label class="d-flex align-items-center pt-2">
                                    <input
                                            type="radio"
                                            class="form-check-input m-0 me-3 fs-exact-16"
                                            name="seo"
                                            value="product-short-description"
                                        <?= isset($filterParam['seo']) && $filterParam['seo'] == 'product-short-description' ? 'checked' : '' ?>
                                    />
                                    Короткий опис
                                </label>
                            </li>
                            <li>
                                <label class="d-flex align-items-center pt-2">
                                    <input
                                            type="radio"
                                            class="form-check-input m-0 me-3 fs-exact-16"
                                            name="seo"
                                            value="non-keyword"
                                        <?= isset($filterParam['seo']) && $filterParam['seo'] == 'non-keyword' ? 'checked' : '' ?>
                                    />
                                    Ключові слова
                                </label>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<style>
    .filter-name {
        font-weight: bold;
        font-size: 18px;
        color: rgba(90, 91, 90, 0.68);
    }

    .filter-icon {
        margin-right: 10px;
        color: rgba(0, 166, 41, 0.78);
    }

    .label-color-filter {
        background-color: rgba(241, 238, 219, 0.37);
        padding-left: 5px;
        border: 1px solid #f8db03;
        border-radius: 3px;
        cursor: pointer;
    }

    .scrollable_sidebar-body {
        max-height: 115vh; /* Установите ограничение по высоте */
        overflow-y: auto; /* Включите вертикальную прокрутку */
    }

    .scrollable_sidebar-body::-webkit-scrollbar {
        width: 5px; /* Ширина полосы прокрутки */
    }

    [data-sa-collapse-filter-content] {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    [data-sa-collapse-filter-content].collapsed {
        max-height: 500px; /* Можно увеличить, если контент больше */
    }

</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Автосабмит формы при изменении значений
        const form = document.getElementById("product-filter-form");
        if (form) {
            form.addEventListener("change", function (event) {
                if (event.target.matches("input, select")) {
                    form.submit();
                }
            });
        }

        // Сворачивание и разворачивание фильтров с запоминанием состояния
        document.querySelectorAll("[data-sa-collapse-filter-trigger]").forEach(trigger => {
            const content = trigger.nextElementSibling;
            const filterId = trigger.getAttribute("data-filter-id"); // Уникальный ID фильтра

            // Проверяем, есть ли сохраненное состояние
            if (localStorage.getItem(`filter-${filterId}`) === "open") {
                content.classList.add("collapsed");
            }

            trigger.addEventListener("click", function () {
                content.classList.toggle("collapsed");

                // Сохраняем состояние в localStorage
                if (content.classList.contains("collapsed")) {
                    localStorage.setItem(`filter-${filterId}`, "open");
                } else {
                    localStorage.removeItem(`filter-${filterId}`);
                }
            });
        });

        // Очистка фильтров и localStorage при нажатии на кнопку "Скинути"
        const clearBtn = document.getElementById("clear-filters-btn");
        if (clearBtn) {
            clearBtn.addEventListener("click", function () {
                localStorage.clear(); // Удаляет все сохраненные состояния фильтров
            });
        }
    });
</script>