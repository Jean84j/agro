<?php

use common\models\shop\ActivePages;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use kartik\ipinfo\IpInfo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\LinkPager;

/** @var yii\web\View $this */
/** @var backend\models\search\ActivePagesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Active Pages');
$ipAddress = Yii::$app->request->getUserIP();

?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container" style="max-width: 1623px">
            <div class="card">
                <?php echo Html::beginForm(['check-delete']); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'responsiveWrap' => false,
                    'summary' => Yii::$app->devicedetect->isMobile() ? false : "Показано <span class='summary-info'>{begin}</span> - <span class='summary-info'>{end}</span> из <span class='summary-info'>{totalCount}</span> Записей",
                    'panel' => [
                        'type' => 'warning',
                        'heading' =>
                            '<h3 class="panel-title"><i class="fas fa-globe"></i> ' . $this->title . ' ' .
                            '<span id="copyTarget" style="color: #121e57">'
                            . $ipAddress .
                            '</span>' . ' ' . '<svg id="copyButton" onclick="copyText()" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="cursor: pointer;">
            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
        </svg>
        </h3>',
                        'headingOptions' => ['style' => 'height: 60px; margin-top: 10px'],
                        'before' => false,
                        'after' =>
                            Html::submitButton('<i class="fas fa-trash-alt"></i> Вибрані', ['class' => 'btn btn-danger', 'style' => 'margin-right: 5px']) .
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
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($model) {
                                return ['name' => 'selection', 'value' => $model->id];
                            },
                        ],
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'ip_user',
                            'format' => 'raw',
                            'value' => function ($model) {
                                try {
                                    return IpInfo::widget([
                                        'ip' => $model->ip_user,
                                        'showPopover' => false,
                                        'template' => ['inlineContent' => '{flag} {city} {ip}'],
                                    ]);
                                } catch (\Throwable $e) {
                                    Yii::error("IpInfo error for IP {$model->ip_user}: " . $e->getMessage(), __METHOD__);
                                    return Html::encode($model->ip_user ?: '—');
                                }
                            },
                            'contentOptions' => ['style' => 'width: 150px'],
                        ],


                        [
                            'attribute' => 'date_visit',
                            'filter' => false,
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDatetime($model->date_visit, 'medium');
                            },
                            'contentOptions' => ['style' => 'width: 200px'],
                        ],
                        [
                            'label' => 'count',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $productUrl = $model->getClearUrl($model->url_page);

                                return '<span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-user">
                                            ' . ActivePages::productCountViews($productUrl) . '
                                        </span>';
                            },
                        ],
                        [
                            'attribute' => 'url_page',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $productUrl = $model->getClearUrl($model->url_page);
                                $imageUrl = $model->getImage($productUrl);

                                return Html::img(Yii::$app->request->hostInfo . $imageUrl, [
                                        'style' => 'max-width:42px; max-height:42px; margin-right:5px;',
                                    ]) .
                                    Html::encode($productUrl);
                            },
                        ],
                        [
                            'attribute' => 'client_from',
                            'label' => 'Откуда',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $url = Html::encode($model->getClearUrl($model->client_from));

                                return match (true) {
                                    $url === 'https://www.google.com/' =>
                                    '<i class="fab fa-google google-multicolor-icon"></i>',

                                    $url === 'android-app://com.google.android.googlequicksearchbox/' =>
                                    '<i class="fab fa-android google-multicolor-icon"></i>',

                                    $url === 'https://www.google.com.ua/' =>
                                    '<i class="fab fa-google google-gradient-icon"></i>',

                                    $url === 'https://www.bing.com/' =>
                                    '<i class="fab fa-microsoft microsoft-multicolor-icon"></i>',

                                    str_contains($url, 'https://www.google.com/url') =>
                                    '<i class="fab fa-apple google-apple-multicolor-icon"></i>',

                                    default => $url,
                                };
                            },
                        ],
                        [
                            'attribute' => 'other',
                            'filter' => false,
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->other == 'mobile') {
                                    return '<i class="fas fa-mobile-alt" style="width: 3.125em; font-size: 23px; color: #a77120"></i>';
                                } elseif ($model->other == 'desktop') {
                                    return '<i class="fas fa-desktop" style="width: 3.125em; font-size: 23px; color: #20a73d"></i>';
                                } else {
                                    return '<i class="fas fa-ban" style="width: 3.125em; font-size: 23px; color: #a72032"></i>';
                                }
                            },
                            'contentOptions' => ['style' => 'width: 62px'],
                        ],
                        [
                            'attribute' => 'status_serv',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->status_serv == '200') {
                                    return '<i style="color: #398d05">' . $model->status_serv . '</i>';
                                } elseif ($model->status_serv == '500') {
                                    return '<i style="color: #c86408">' . $model->status_serv . '</i>';
                                } elseif ($model->status_serv == '404') {
                                    return '<i style="color: #c10518">' . $model->status_serv . '</i>';
                                } else {
                                    return '<i style="color: #0c33be">' . $model->status_serv . '</i>';
                                }
                            },
                            'contentOptions' => ['style' => 'width: 40px; text-align: center;'],
                        ],
                        [
                            'class' => ActionColumn::class,
                            'urlCreator' => function ($action, ActivePages $model) {
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
<style>
    .summary-info {
        font-size: 18px;
        font-weight: bold;
        color: #00050b;
    }

    .google-gradient-icon {
        font-size: 30px;
        background: linear-gradient(to top, #f9e503 50%, #00aaff 50%);
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .google-multicolor-icon {
        font-size: 30px;
        background: linear-gradient(
                to top,
                #4285F4 25%,
                #EA4335 25%,
                #EA4335 50%,
                #FBBC05 50%,
                #FBBC05 75%,
                #34A853 75%
        );
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .google-apple-multicolor-icon {
        font-size: 40px;
        background: linear-gradient(
                to top,
                #4285F4 25%,
                #EA4335 25%,
                #EA4335 50%,
                #FBBC05 50%,
                #FBBC05 75%,
                #34A853 75%
        );
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .microsoft-multicolor-icon {
        font-size: 33px;
        background: linear-gradient(
                to top,
                #4285F4 25%,
                #EA4335 25%,
                #FBBC05 75%,
                #34A853 75%
        );
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }
</style>
<script>
    const copyButton = document.getElementById("copyButton");

    copyButton.addEventListener("mouseenter", () => {
        copyButton.style.transform = "scale(1.2)"; // Увеличение при наведении
    });

    copyButton.addEventListener("mouseleave", () => {
        copyButton.style.transform = "scale(1)"; // Возвращение к нормальному размеру
    });

    copyButton.addEventListener("click", function () {
        const copyTarget = document.getElementById("copyTarget").textContent;
        navigator.clipboard.writeText(copyTarget).then(() => {
            copyButton.style.transform = "scale(0.8)"; // Уменьшение при клике
            setTimeout(() => {
                copyButton.style.transform = "scale(1.2)"; // Восстановление после клика
            }, 100);
        });
    });
</script>
