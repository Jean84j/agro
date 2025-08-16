<?php

use common\models\shop\Brand;
use common\models\shop\Category;
use common\models\shop\Grup;
use common\models\shop\Label;
use common\models\shop\Product;
use common\models\shop\Status;
use common\models\shop\Tag;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use yii\bootstrap5\Modal;

/** @var yii\web\View $this */
/** @var common\models\shop\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="sa-entity-layout__sidebar">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button
                    class="nav-link active"
                    id="home-tab-1"
                    data-bs-toggle="tab"
                    data-bs-target="#home-tab-content-1"
                    type="button"
                    role="tab"
                    aria-controls="home-tab-content-1"
                    aria-selected="true"
            >
                Основні<span class="nav-link-sa-indicator"></span>
            </button>
        </li>
        <?php if (!$model->isNewRecord): ?>
            <li class="nav-item" role="presentation">
                <button
                        class="nav-link"
                        id="profile-tab-1"
                        data-bs-toggle="tab"
                        data-bs-target="#profile-tab-content-1"
                        type="button"
                        role="tab"
                        aria-controls="profile-tab-content-1"
                        aria-selected="true"
                >
                    Допоміжні<span class="nav-link-sa-indicator"></span>
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button
                        class="nav-link"
                        id="image-tab-1"
                        data-bs-toggle="tab"
                        data-bs-target="#image-tab-content-1"
                        type="button"
                        role="tab"
                        aria-controls="image-tab-content-1"
                        aria-selected="true"
                >
                    Зображення<span class="nav-link-sa-indicator"></span>
                </button>
            </li>
        <?php endif; ?>
    </ul>
    <div class="tab-content mt-4">
        <div
                class="tab-pane fade show active"
                id="home-tab-content-1"
                role="tabpanel"
                aria-labelledby="home-tab-1"
        >
            <div class="card">
                <div class="card-body p-5">
                    <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Category') ?></h2></span>
                    </div>
                    <div class="card card-body">
                        <?php
                        Pjax::begin(['id' => "category"]);
                        $data = ArrayHelper::map(Category::find()
                            ->where(['visibility' => true])
                            ->orderBy('name')
                            ->asArray()
                            ->all(), 'id', 'name');
                        echo $form->field($model, 'category_id')->widget(Select2::class, [
                            'data' => $data,
                            'theme' => Select2::THEME_DEFAULT,
                            'maintainOrder' => true,
                            'pluginLoading' => false,
                            'options' => [
                                'placeholder' => 'Виберіть категорію ...',
                                'class' => 'sa-select2 form-select',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'width' => '273px',
                            ],
                        ])->label(false);
                        Pjax::end();
                        ?>
                    </div>
                </div>
            </div>
            <div class="card w-100 mt-5">
                <div class="card-body p-5">
                    <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Status') ?></h2></span>
                    </div>
                    <div class="card card-body mb-4">
                        <?= $form->field($model, 'status_id')
                            ->radioList(
                                ArrayHelper::map(Status::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
                                [
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        $return = '<label class="form-check">';
                                        $return .= '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '" ' . ($checked ? "checked" : "") . '>';
                                        $return .= ucwords($label);
                                        $return .= '</label>';
                                        return $return;
                                    },

                                ],
                            )->label(false); ?>
                    </div>
                </div>
            </div>
            <div class="card w-100 mt-5">
                <div class="card-body p-5">
                    <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Package') ?></h2></span>
                    </div>
                    <div class="card card-body mb-4">
                        <?= $form->field($model, 'package')
                            ->radioList(
                                [
                                    'BIG' => 'Фермер',
                                    'SMALL' => 'Дачник',
                                ],
                                [
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        $return = '<label class="form-check">';
                                        $return .= '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '" ' . ($checked ? "checked" : "") . '>';
                                        $return .= ucwords($label);
                                        $return .= '</label>';
                                        return $return;
                                    },

                                ],
                            )->label(false); ?>
                    </div>
                </div>
            </div>
            <div class="card w-100 mt-5">
                <div class="card-body p-5">
                    <div class="mb-5">
                        <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                                    class="mb-0 fs-exact-18"><?= Yii::t('app', 'Prices') ?></h2></span>
                    </div>
                    <div class="card card-body g-4">
                        <div>
                            <?= $form->field($model, 'price')->textInput([
                                'class' => "form-control"
                            ]) ?>
                        </div>
                        <div>
                            <?= $form->field($model, 'old_price')->textInput([
                                'class' => "form-control"
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card w-100 mt-5">
                <div class="card-body p-5">
                    <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Currency') ?></h2></span>
                    </div>
                    <div class="card card-body mb-4">
                        <?= $form->field($model, 'currency')
                            ->radioList(
                                [
                                    'UAH' => 'Гривня',
                                    'USD' => 'Долар',
                                ],
                                [
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        $return = '<label class="form-check">';
                                        $return .= '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '" ' . ($checked ? "checked" : "") . '>';
                                        $return .= ucwords($label);
                                        $return .= '</label>';
                                        return $return;
                                    },

                                ],
                            )->label(false); ?>
                    </div>
                </div>
            </div>
            <div class="card w-100 mt-5">
                <div class="card-body p-5">
                    <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Brand') ?></h2></span>
                    </div>
                    <div class="card card-body ">
                        <?php
                        $data = ArrayHelper::map(Brand::find()->orderBy('name')->asArray()->all(), 'id', 'name');
                        echo $form->field($model, 'brand_id')->widget(Select2::class, [
                            'data' => $data,
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginLoading' => false,
                            'options' => [
                                'placeholder' => 'Виберіть Бренд ...',
                                'class' => 'sa-select2 form-select',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'width' => '273px',
                            ],
                        ])->label(false);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!$model->isNewRecord): ?>
            <div
                    class="tab-pane fade"
                    id="profile-tab-content-1"
                    role="tabpanel"
                    aria-labelledby="profile-tab-1"
            >


                <div class="card w-100 mt-5">
                    <div class="card-body p-5">
                        <div class="mb-3">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Variants') ?></h2></span>
                            <a href="#" data-bs-toggle="modal"
                               data-bs-target="#addVariantModal">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="mt-n5">
                        <div class="sa-divider"></div>

                        <div class="table-responsive">
                            <table class="sa-table">
                                <thead>
                                <tr>
                                    <th class="min-w-5x">Назва</th>
                                    <th class="w-min">Значення</th>
                                    <th class="w-min"></th>
                                </tr>
                                </thead>
                                <?= $this->render('modal-add-variant', ['model' => $model]) ?>
                                <tbody id="variant-table">
                                <?php if (!empty($variants)) : ?>
                                    <?php $productId = $model->id;
                                    $i = 0; ?>
                                    <?php foreach ($variants as $variant) : ?>
                                        <tr>
                                            <td>
                                                <input type="text" name="variant[<?= $variant['id'] ?>]"
                                                       class="form-control form-control-sm"
                                                       value="<?= $variant['name'] ?>" readonly/>
                                            </td>
                                            <td>
                                                <input type="text" name="volume[<?= $variant['id'] ?>]"
                                                       class="form-control form-control-sm wx-4x"
                                                       value="<?= $variant['volume'] ?>" readonly/>
                                            </td>
                                            <td>
                                                <a href="#"
                                                   id="<?= $variant['id'] ?>"
                                                   data-productId="<?= $productId ?>"
                                                   data-variantId="<?= $variant['product_variant_id'] ?>"

                                                   class="text-danger del-variant"
                                                   onclick="return confirm('Вы уверены, что хотите удалить этот товар из заказа?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                         height="12" viewBox="0 0 12 12" fill="currentColor">
                                                        <path d="M10.8,10.8L10.8,10.8c-0.4,0.4-1,0.4-1.4,0L6,7.4l-3.4,3.4c-0.4,0.4-1,0.4-1.4,0l0,0c-0.4-0.4-0.4-1,0-1.4L4.6,6L1.2,2.6 c-0.4-0.4-0.4-1,0-1.4l0,0c0.4-0.4,1-0.4,1.4,0L6,4.6l3.4-3.4c0.4-0.4,1-0.4,1.4,0l0,0c0.4,0.4,0.4,1,0,1.4L7.4,6l3.4,3.4 C11.2,9.8,11.2,10.4,10.8,10.8z"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $i++; endforeach; ?>
                                <?php endif; ?>
                                </tbody>

                            </table>
                        </div>

                        <div class="sa-divider"></div>
                    </div>
                </div>


                <div class="card w-100 mt-5">
                    <div class="card-body p-5">
                        <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Tag') ?></h2></span>
                        </div>
                        <div class="card card-body">
                            <?php
                            $data = ArrayHelper::map(Tag::find()->orderBy('id')->asArray()->all(), 'id', 'name');
                            echo $form->field($model, 'tags')->widget(Select2::class, [
                                'data' => $data,
                                'theme' => Select2::THEME_DEFAULT,
                                'maintainOrder' => true,
                                'pluginLoading' => false,
                                'toggleAllSettings' => [
                                    'selectLabel' => '<i class="fas fa-check-circle"></i> Выбрать все',
                                    'unselectLabel' => '<i class="fas fa-times-circle"></i> Удалить все',
                                    'selectOptions' => ['class' => 'text-success'],
                                    'unselectOptions' => ['class' => 'text-danger'],
                                ],
                                'options' => [
                                    'placeholder' => 'Виберіть тег ...',
                                    'class' => 'sa-select2 form-select',
                                    // 'data-tags'=>'true',
                                    'multiple' => true
                                ],
                                'pluginOptions' => [
                                    'closeOnSelect' => false,
                                    'tags' => true,
                                    'tokenSeparators' => [', ', ' '],
                                    'maximumInputLength' => 10,
                                    'width' => '273px',
                                ],
                            ])->label(false);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card w-100 mt-5">
                    <div class="card-body p-5">
                        <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Group') ?></h2></span>
                        </div>
                        <div class="card card-body">
                            <?php
                            $data = ArrayHelper::map(Grup::find()->orderBy('id')->asArray()->all(), 'id', 'name');
                            echo $form->field($model, 'grups')->widget(Select2::class, [
                                'data' => $data,
                                'theme' => Select2::THEME_DEFAULT,
                                'maintainOrder' => true,
                                'pluginLoading' => false,
                                'toggleAllSettings' => [
                                    'selectLabel' => '<i class="fas fa-check-circle"></i> Выбрать все',
                                    'unselectLabel' => '<i class="fas fa-times-circle"></i> Удалить все',
                                    'selectOptions' => ['class' => 'text-success'],
                                    'unselectOptions' => ['class' => 'text-danger'],
                                ],
                                'options' => [
                                    'placeholder' => 'Виберіть групу ...',
                                    'class' => 'sa-select2 form-select',
                                    // 'data-tags'=>'true',
                                    'multiple' => true
                                ],
                                'pluginOptions' => [
                                    'closeOnSelect' => false,
                                    'grups' => true,
                                    'tokenSeparators' => [', ', ' '],
                                    'maximumInputLength' => 10,
                                    'width' => '273px',
                                ],
                            ])->label(false);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card w-100 mt-5">
                    <div class="card-body p-5">
                        <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Label') ?></h2></span>
                        </div>
                        <div class="card card-body ">
                            <?php
                            $data = ArrayHelper::map(Label::find()
                                ->orderBy('name')->asArray()->all(), 'id', 'name');
                            echo $form->field($model, 'label_id')->widget(Select2::class, [
                                'data' => $data,
                                'theme' => Select2::THEME_DEFAULT,
                                'pluginLoading' => false,
                                'options' => [
                                    'placeholder' => 'Виберіть мітку ...',
                                    'class' => 'sa-select2 form-select',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'width' => '273px',
                                ],
                            ])->label(false); ?>
                        </div>
                    </div>
                </div>
                <div class="card w-100 mt-5">
                    <div class="card-body p-5">
                        <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Analog') ?></h2></span>
                        </div>
                        <div class="card card-body ">
                            <?php
                            $data = ArrayHelper::map(Product::find()->orderBy('id')->asArray()->all(), 'id', 'name');
                            echo $form->field($model, 'analogs')->widget(Select2::class, [
                                'data' => $data,
                                'theme' => Select2::THEME_DEFAULT,
                                'maintainOrder' => true,
                                'pluginLoading' => false,
                                'toggleAllSettings' => [
                                    'selectLabel' => '<i class="fas fa-check-circle"></i> Выбрать все',
                                    'unselectLabel' => '<i class="fas fa-times-circle"></i> Удалить все',
                                    'selectOptions' => ['class' => 'text-success'],
                                    'unselectOptions' => ['class' => 'text-danger'],
                                ],
                                'options' => [
                                    'placeholder' => 'Виберіть аналог ...',
                                    'class' => 'sa-select2 form-select',
                                    // 'data-tags'=>'true',
                                    'multiple' => true
                                ],
                                'pluginOptions' => [
                                    'closeOnSelect' => false,
                                    'tags' => true,
                                    'tokenSeparators' => [', ', ' '],
                                    'maximumInputLength' => 10,
                                    'width' => '273px',
                                ],
                            ])->label(false);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div
                class="tab-pane fade"
                id="image-tab-content-1"
                role="tabpanel"
                aria-labelledby="image-tab-1"
        >
            <div class="card w-100 mt-5">
                <div class="card-body p-5">
                    <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Image 700x700') ?></h2></span>
                    </div>
                </div>
                <div class="mt-n5">
                    <div class="sa-divider"></div>
                    <div class="table-responsive">
                        <table class="sa-table">
                            <thead>
                            <tr>
                                <th class="w-min">Карт.</th>
                                <th class="min-w-10x">Назва</th>
                                <th class="w-min">Поз.</th>
                            </tr>
                            </thead>
                            <?php Pjax::begin(['id' => 'images']); ?>
                            <tbody id="images-table">
                            <?php if (!empty($model->images)) : ?>
                                <?php foreach ($model->images as $image) : ?>
                                    <tr>
                                        <td>
                                            <div class="sa-symbol sa-symbol--shape--rounded sa-symbol--size--xxl">
                                                <a href="#"
                                                   class="image-link"
                                                   data-bs-toggle="modal"
                                                   data-bs-target="#imageModal"
                                                   data-image-url="<?= Yii::$app->request->hostInfo . '/product/' . $image->name ?>">
                                                    <img src="<?= Yii::$app->request->hostInfo . '/product/' . $image->name ?>"
                                                         width="40" height="40" alt="">
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="alt[<?= $image->id ?>]"
                                                   class="form-control form-control-sm"
                                                   value="<?= $image->alt ? $image->alt : $model->name ?>"/>
                                        </td>
                                        <td>
                                            <input type="text" name="priority[<?= $image->id ?>]"
                                                   class="form-control form-control-sm wx-4x"
                                                   value="<?= $image->priority ? $image->priority : 0 ?>"/>
                                        </td>
                                        <td>
                                            <button class="btn btn-sa-muted btn-sm mx-n3"
                                                    onclick="removeImageStock(<?= $image->id ?>, '<?= $_SESSION['_language'] ?>')"
                                                    type="button" aria-label="Видалити зображення"
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    title="Видалити зображення">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                     height="12" viewBox="0 0 12 12" fill="currentColor">
                                                    <path d="M10.8,10.8L10.8,10.8c-0.4,0.4-1,0.4-1.4,0L6,7.4l-3.4,3.4c-0.4,0.4-1,0.4-1.4,0l0,0c-0.4-0.4-0.4-1,0-1.4L4.6,6L1.2,2.6 c-0.4-0.4-0.4-1,0-1.4l0,0c0.4-0.4,1-0.4,1.4,0L6,4.6l3.4-3.4c0.4-0.4,1-0.4,1.4,0l0,0c0.4,0.4,0.4,1,0,1.4L7.4,6l3.4,3.4 C11.2,9.8,11.2,10.4,10.8,10.8z"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <?php Pjax::end() ?>
                        </table>
                    </div>
                    <div class="sa-divider"></div>
                    <div class="px-5 py-4 my-2">
                        <?php if (!$model->isNewRecord): ?>
                            <?= Html::a(
                                Yii::t('app', 'Download images'),
                                Url::to(['create-image', 'id' => $model->id, 'language' => 'uk']),
                                ['role' => 'modal-remote', 'data-toggle' => 'tooltip']
                            ); ?>
                        <?php else: ?>
                            <?= Html::tag('span', 'Завантаження зображення буде доступно після створення товару!',
                                ['class' => 'text-danger']
                            ); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Модальное окно -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Увеличенное изображение</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Изображение" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const submitButton = document.getElementById('submitVariantBtn');
        submitButton.addEventListener('click', function () {
            // Собираем данные из модального окна
            const productId = document.querySelector('input[name="productId"]').value;
            const variantId = document.getElementById('variantId').value;
            const volume = document.getElementById('volume').value;
            const productVolume = document.getElementById('productVolume').value;

            if (!variantId || !volume || !productVolume) {
                return; // Останавливаем выполнение, если поля не заполнены
            }

            // Отправляем данные на сервер
            fetch('/admin/uk/product/add-product-variants', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': yii.getCsrfToken(), // Убедись, что CSRF токен подключён
                },
                body: JSON.stringify({
                    productId: productId,
                    variantId: variantId,
                    productVolume: productVolume,
                    volume: volume,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        const closeButton = document.querySelector('.btn-close');
                        // Проверяем, что кнопка существует
                        if (closeButton) {
                            // Симулируем клик по кнопке
                            closeButton.click();
                        }
                        // Очищаем поля формы
                        document.getElementById('variantId').value = '';
                        document.getElementById('volume').value = '';

                        document.getElementById('variant-table').innerHTML = data.variants;

                    } else {
                        alert('Помилка: ' + data.error);
                    }
                })
                .catch((error) => {
                    console.error('Помилка:', error);
                    alert('Сталася помилка при відправці даних.');
                });
        });

    });
</script>

<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "size" => Modal::SIZE_EXTRA_LARGE,
//    'scrollable' => true,
    'options' => [
        "data-bs-backdrop" => "static",
        // "class" => 'modal-dialog-scrollable',
    ],
    "footer" => "", // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>
<?php
$script = <<< JS

 $(document).on('click', '.image-link', function () {
    const imageUrl = $(this).data('image-url');
    $('#modalImage').attr('src', imageUrl);
});

JS;

$this->registerJs($script, View::POS_END);
?>
