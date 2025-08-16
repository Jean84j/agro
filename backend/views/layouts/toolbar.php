<?php

use backend\widgets\TasksAdmin;
use common\models\Settings;
use yii\helpers\Html;

?>
<div class="sa-toolbar sa-toolbar--search-hidden sa-app__toolbar">
    <div class="sa-toolbar__body">
        <div class="sa-toolbar__item">
            <button class="sa-toolbar__button" type="button" aria-label="Menu" data-sa-toggle-sidebar="">
                <svg width="20px" height="20px" style="display: unset">
                    <use xlink:href="/admin/images/sprite.svg#menu"/>
                </svg>
            </button>
        </div>
        <div class="sa-toolbar__item sa-toolbar__item--search">
            <form class="sa-search sa-search--state--pending">
                <div class="sa-search__body">
                    <label class="visually-hidden" for="input-search">Search for:</label>
                    <div class="sa-search__icon">
                        <svg width="20px" height="20px" style="display: unset">
                            <use xlink:href="/admin/images/sprite.svg#search"/>
                        </svg>
                    </div>
                    <input type="text" id="input-search" class="sa-search__input"
                           placeholder="Пошук істини..." autocomplete="off"/>
                    <button class="sa-search__cancel d-sm-none" type="button" aria-label="Close search">
                        <svg width="20px" height="20px" style="display: unset">
                            <use xlink:href="/admin/images/sprite.svg#search-close"/>
                        </svg>
                    </button>
                    <div class="sa-search__field"></div>
                </div>
                <div class="sa-search__dropdown">
                    <div class="sa-search__dropdown-loader"></div>
                    <div class="sa-search__dropdown-wrapper">
                        <div class="sa-search__suggestions sa-suggestions"></div>
                        <div class="sa-search__help sa-search__help--type--no-results">
                            <div class="sa-search__help-title">
                                Нема результатів для &quot;
                                <span class="sa-search__query"></span>
                                &quot;
                            </div>
                            <div class="sa-search__help-subtitle">Переконайтеся, що всі слова написані
                                правильно.
                            </div>
                        </div>
                        <div class="sa-search__help sa-search__help--type--greeting">
                            <div class="sa-search__help-title">Почніть вводити текст для пошуку</div>
                            <div class="sa-search__help-subtitle">назва товару, категорії, Ф.І.О замовника, мобільний,
                                etc.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sa-search__backdrop"></div>
            </form>
        </div>
        <div class="mx-auto"></div>
        <div class="sa-toolbar__item d-sm-none">
            <button class="sa-toolbar__button" type="button" aria-label="Show search"
                    data-sa-action="show-search">
                <svg width="20px" height="20px" style="display: unset">
                    <use xlink:href="/admin/images/sprite.svg#search-show"/>
                </svg>
            </button>
        </div>
        <div class="sa-toolbar__item me-3">
            <i class="fas fa-euro-sign" style="color: #0c33be"></i>
            <?= Yii::$app->formatter->asDecimal(Settings::currencyRate($cc = 'EUR'), 2) ?>
        </div>
        <div class="sa-toolbar__item me-3">
            <i class="fas fa-dollar-sign" style="color: #00a629"></i>
            <?= Yii::$app->formatter->asDecimal(Settings::currencyRate(), 2) ?>
        </div>
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->id === 2): ?>
            <div class="sa-toolbar__item dropdown">
                <?php echo TasksAdmin::widget() ?>
            </div>
        <?php endif; ?>
        <div class="dropdown sa-toolbar__item">
            <button
                    class="sa-toolbar-user"
                    type="button"
                    id="dropdownMenuButton"
                    data-bs-toggle="dropdown"
                    data-bs-offset="0,1"
                    aria-expanded="false"
            >
                                <span class="sa-toolbar-user__avatar sa-symbol sa-symbol--shape--rounded">
                                    <img src="/admin/images/customers/customer-4-64x64.jpg" width="64" height="64"
                                         alt=""/>
                                </span>
                <span class="sa-toolbar-user__info">
                                <?php if (isset(Yii::$app->user->identity->username)): ?>
                                    <span class="sa-toolbar-user__title"><?= Yii::$app->user->identity->username ?></span>
                                    <span class="sa-toolbar-user__subtitle"><?= Yii::$app->user->identity->email ?></span>
                                <?php endif; ?>
                                </span>
            </button>
            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                <li>
                    <?= Html::a('Вихід', ['/site/logout'], [
                        'class' => 'dropdown-item',
                        'data' => [
                            'method' => 'post',
                        ],
                    ]) ?>
            </ul>
        </div>
    </div>
    <div class="sa-toolbar__shadow"></div>
</div>