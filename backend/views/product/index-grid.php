<?php

use common\models\shop\Product;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\bootstrap5\LinkPager;
use kartik\widgets\SwitchInput;
use yii\web\View;

/** @var yii\web\View $this */
/** @var backend\models\search\ActivePagesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Products');
$seoErrors = Yii::$app->session->get('errorsSeo');

$btnPc = Html::tag('div',
    SwitchInput::widget([
        'name' => 'errorsSeo',
        'value' => Yii::$app->session->get('errorsSeo') === 'yes' ? 1 : 0,
        'pluginOptions' => [
            'size' => 'medium',
            'onColor' => 'success',
            'offColor' => 'danger',
            'onText' => 'On',
            'offText' => 'Off',
        ],
        'containerOptions' => [
            'class' => 'form-group me-3'],
        'pluginEvents' => [
            "switchChange.bootstrapSwitch" => "function(event, state) { 
                                            var url = '" . Url::to(['product/update-error-checkbox']) . "';
                                            updateErrorCheckbox(url, state); 
                                        }",
        ],
    ]) .
    Html::a(Html::tag('i', '', ['class' => 'fas fa-file-export']) . ' ' . Yii::t('app', 'Excel'), Url::to(['product/export-to-excel']), [
        'class' => 'btn btn-outline-success me-3'
    ]) .
    Html::a(Html::tag('i', '', ['class' => 'fas fa-file-import']) . ' ' . Yii::t('app', 'Excel'), Url::to(['product/upload']), [
        'class' => 'btn btn-outline-success me-3',
        'id' => 'excelFileInput',
        'style' => 'color: red'
    ]) .
    Html::a(Yii::t('app', 'New +'), Url::to(['create']), [
        'class' => 'btn btn-primary me-3'
    ]),
    ['class' => 'd-flex align-items-center']
);

$btnMob = false;

?>
<div id="top" class="sa-app__body">
    <div class="mx-xxl-3 px-4 px-sm-5 pb-6">
        <div class="sa-layout">
            <div class="sa-layout__backdrop" data-sa-layout-sidebar-close=""></div>
            <?php echo $this->render('_search', ['model' => $dataProvider->models]); ?>
            <div class="sa-layout__content">
                <div class="card">
                    <div class="p-1">
                        <div class="row g-4">
                            <div class="col-auto sa-layout__filters-button">
                                <button class="btn btn-sa-muted btn-sa-icon fs-exact-16"
                                        data-sa-layout-sidebar-open="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                         viewBox="0 0 16 16"
                                         fill="currentColor">
                                        <path
                                                d="M7,14v-2h9v2H7z M14,7h2v2h-2V7z M12.5,6C12.8,6,13,6.2,13,6.5v3c0,0.3-0.2,0.5-0.5,0.5h-2 C10.2,10,10,9.8,10,9.5v-3C10,6.2,10.2,6,10.5,6H12.5z M7,2h9v2H7V2z M5.5,5h-2C3.2,5,3,4.8,3,4.5v-3C3,1.2,3.2,1,3.5,1h2 C5.8,1,6,1.2,6,1.5v3C6,4.8,5.8,5,5.5,5z M0,2h2v2H0V2z M9,9H0V7h9V9z M2,14H0v-2h2V14z M3.5,11h2C5.8,11,6,11.2,6,11.5v3 C6,14.8,5.8,15,5.5,15h-2C3.2,15,3,14.8,3,14.5v-3C3,11.2,3.2,11,3.5,11z"
                                        ></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'responsiveWrap' => false,
                        'summary' => Yii::$app->devicedetect->isMobile() ? false : "Показано <span class='summary-info'>{begin}</span> - <span class='summary-info'>{end}</span> из <span class='summary-info'>{totalCount}</span> Записей",
                        'panel' => [
                            'type' => 'warning',
                            'heading' => '<h3 class="panel-title"><i class="fas fa-globe"></i> ' . $this->title . '</h3>',
                            'headingOptions' => ['style' => 'height: 50px; margin-top: 0px'],
                            'before' => Yii::$app->devicedetect->isMobile() ? $btnMob : $btnPc,
                            'after' =>
                                Html::a('<i class="fas fa-redo"></i> Обновити', ['index'], ['class' => 'btn btn-info']),
                        ],
                        'pager' => [
                            'class' => LinkPager::class,
                            'options' => ['class' => 'pagination justify-content-center'],
                            'maxButtonCount' => Yii::$app->devicedetect->isMobile() ? 3 : 10,
                            'firstPageLabel' => '<<',
                            'lastPageLabel' => '>>',
                            'prevPageLabel' => '<',
                            'nextPageLabel' => '>',
                        ],
                        'columns' => [
                            [
                                'attribute' => 'image',
                                'label' => Html::tag('i', '', ['class' => 'fas fa-images']),
                                'encodeLabel' => false,
                                'headerOptions' => ['style' => 'text-align: center;'],
                                'format' => 'html',
                                'value' => function ($model) {
                                    $imageUrl = isset($model->images[0])
                                        ? Yii::$app->request->hostInfo . '/product/' . $model->images[0]->extra_small
                                        : Yii::$app->request->hostInfo . '/images/no-image.png';

                                    return Html::img($imageUrl, ['style' => 'width: 64px; height: 64px; object-fit: cover;']);
                                },
                            ],
                            [
                                'attribute' => 'name',
                                'contentOptions' => ['style' => 'font-size: 16px;'],
                                'filter' => true,
                                'format' => 'raw',
                                'value' => function ($model) use ($seoErrors) {
                                    $url = Url::to(['product/update', 'id' => $model->id]);

                                    $html = '<div>';

                                    $html .= "<a href=\"{$url}\" class=\"text-reset\" style=\"font-weight: bold;\">{$model->name}";

                                    if ($seoErrors === 'yes') {
                                        $html .= $model->getNonSeoTitle($model->id);
                                        $html .= $model->getNonDescription($model->id);
                                        $html .= $model->getNonShortDescr($model->id);
                                        $html .= $model->getNonH1($model->id);
                                        $html .= $model->getNonH3Descr($model->id);
                                        $html .= $model->getNonParametr($model->id);
                                        $html .= $model->getNonBrand($model->id);
                                        $html .= $model->getNonSeoDescr($model->id);
                                        $html .= $model->getNonKeywords($model->id);
                                    }

                                    $html .= '</a>';

                                    $html .= '<div class="sa-meta mt-0"><ul class="sa-meta__list">';

                                    $html .= '<li class="sa-meta__item">ID: <span class="st-copy">' . $model->id . '</span></li>';
                                    
                                    $html .= '<li class="sa-meta__item"><i class="fas fa-indent"></i>: <span class="st-copy">' . Yii::$app->formatter->asDate($model->date_public, 'php:d.m.Y') . '</span></li>';
                                    
                                    $html .= '<li class="sa-meta__item"><i class="fas fa-edit"></i>: <span class="st-copy">' . Yii::$app->formatter->asDate($model->date_updated, 'php:d.m.Y') . '</span></li>';


                                    $countProductView = $model->getProductView($model->slug);
                                    $html .= '<li class="sa-meta__item"><i class="fas fa-eye"></i>: <span class="st-copy"><span class="badge badge-sa-theme-view">' . $countProductView . '</span></span></li>';

                                    $analogProducts = $model->getProductsAnalog($model->id);
                                    if (!empty($analogProducts)) {
                                        $html .= '<li class="sa-meta__item"><i class="fas fa-puzzle-piece"></i>: <span class="st-copy"><span class="badge badge-sa-theme-analog">' . $analogProducts . '</span></span></li>';
                                    }

                                    if ($model->grups) {
                                        $html .= '<li class="sa-meta__item"><i class="fas fa-layer-group"></i>: <span class="st-copy">';
                                        foreach ($model->grups as $grup) {
                                            $html .= '<span class="badge badge-sa-secondary-grup">' . $grup->name . '</span>';
                                        }
                                        $html .= '</span></li>';
                                    }

                                    if (isset($model->label)) {
                                        $html .= '<li class="sa-meta__item"><i class="fas fa-tag"></i>: <span class="st-copy"><span class="badge badge-sa-primary-label">' . $model->label->name . '</span></span></li>';
                                    }

                                    if ($model->tags) {
                                        $html .= '<li class="sa-meta__item"><i class="fas fa-tags"></i>: <span class="st-copy">';
                                        foreach ($model->tags as $tag) {
                                            $html .= '<span class="badge badge-sa-secondary">' . $tag->name . '</span>';
                                        }
                                        $html .= '</span></li>';
                                    }

                                    $html .= '</ul></div></div>';

                                    return $html;
                                },
                            ],
                            [
                                'attribute' => 'status',
                                'label' => 'Статус',
                                'filter' => false,
                                'format' => 'raw',
                                'value' => function ($model) {

                                    switch ($model->status_id) {
                                        case 1:
                                            $color = 'success';
                                            break;
                                        case 2:
                                            $color = 'danger';
                                            break;
                                        case 3:
                                            $color = 'warning';
                                            break;
                                        case 4:
                                            $color = 'info';
                                            break;

                                        default:
                                            $color = 'secondary';
                                    }

                                    return '<div class="badge badge-sa-' . $color . '">' . $model->status->name . '</div>';
                                },
                            ],
                            [
                                'attribute' => 'category',
                                'label' => 'Категорія',
                                'filter' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return '<strong>' . $model->category->name . '</strong>';
                                },
                            ],
                            [
                                'attribute' => 'price',
                                'filter' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $price = $model->getPrice();
                                    return '<span style = "font-weight: bold">' . $price . '</span>';
                                },
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id, 'selection' => $model->id]);
                                }
                            ],
                        ],
                    ]); ?>
                    <?php echo Html::endForm(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .summary-info {
        font-size: 18px;
        font-weight: bold;
        color: #00050b;
    }
</style>
<?php
$script = <<< JS

 document.getElementById('excelFileInput').addEventListener('change', function () {
// Получите выбранный файл
        const selectedFile = this.files[0];

// Создайте объект FormData для отправки файла
        const formData = new FormData();
        formData.append('excelFile', selectedFile); // 'excelFile' - это имя поля на сервере

// Отправьте файл на сервер с использованием Fetch API
        fetch('/upload-url', {
            method: 'POST',
            body: formData,
        })
            .then(response => {
                if (response.ok) {
                    return response.text(); // Если загрузка прошла успешно, вы можете обработать ответ сервера
                }
                throw new Error('Ошибка при загрузке файла на сервер');
            })
            .then(responseText => {
// Обработайте успешный ответ от сервера здесь
                console.log('Серверный ответ:', responseText);
            })
            .catch(error => {
// Обработайте ошибку загрузки
                console.error('Ошибка загрузки:', error);
            });
    });

    document.querySelector('.btn-outline-success').addEventListener('click', function () {
// Симулируйте щелчок по скрытому полю для выбора файла
        document.getElementById('excelFileInput').click();
    });
    
   function updateErrorCheckbox(url, state) {
    var isChecked = state ? 'yes' : 'no';
    
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-CSRF-Token', csrfToken);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.reload();
                } else {
                    console.error('Failed to update checkbox state');
                }
            } else {
                console.error('Failed to send request');
            }
        }
    };
    
    xhr.send('errorsSeo=' + isChecked);
}

JS;

$this->registerJs($script, View::POS_END);
?>
