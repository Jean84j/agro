<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
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