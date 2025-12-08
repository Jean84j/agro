<?php

use yii\helpers\Html;

?>
<?php foreach ($propertiesFilter as $value): ?>
    <div class="widget-filters__item">
        <div class="filter" data-collapse-item>
            <button type="button" class="filter__title"
                    data-collapse-trigger>
                <?= $value['name'] ?>
                <svg class="filter__arrow" width="12px" height="7px">
                    <use xlink:href="/images/sprite.svg#arrow-rounded-down-12x7"></use>
                </svg>
            </button>
            <div class="filter__body" data-collapse-content>
                <div class="filter__container">
                    <div class="filter-list">
                        <div class="filter-list__list">
                            <?php $properties = $category->getPropertiesFilter($value['category_id'], $value['property_id']) ?>
                            <?php foreach ($properties as $property): ?>
                                <label class="filter-list__item ">
                                                                <span class="filter-list__input input-check">
                                                                    <span class="input-check__body">
                                                                        <input class="input-check__input"
                                                                               type="checkbox"
                                                                               name="propertiesCheck[]"
                                                                               value="<?= Html::encode($property) ?>"
                                                                               <?= in_array($property, Yii::$app->request->post('propertiesCheck', [])) ? 'checked' : '' ?>
                                                                               >
                                                                        <span class="input-check__box"></span>
                                                                        <svg class="input-check__icon" width="9px"
                                                                             height="7px">
                                                                            <use xlink:href="/images/sprite.svg#check-9x7"></use>
                                                                        </svg>
                                                                    </span>
                                                                </span>
                                    <span class="filter-list__title">
                                                                  <?= $property ?>
                                                                </span>
                                    <span class="filter-list__counter">
                                                                                        <?= $category->getPropertiesCountPruductFilter
                                                                                        ($category->id, $property) ?>
                                                                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
