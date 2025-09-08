<?php

use common\models\OrderPayMent;
use common\models\shop\OrderProvider;
use common\models\shop\OrderStatus;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var common\models\shop\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
    <div class="container container--max--xl">
        <div class="py-5">
            <div class="row g-4 align-items-center">
                <div class="col">
                    <nav class="mb-2" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-sa-simple">
                            <?php echo Breadcrumbs::widget([
                                'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                                'homeLink' => [
                                    'label' => Yii::t('app', 'Home'),
                                    'url' => Yii::$app->homeUrl,
                                ],
                                'links' => $this->params['breadcrumbs'] ?? [],
                            ]);
                            ?>
                        </ol>
                    </nav>
                </div>
                <div class="col-auto d-flex">
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
        <div class="sa-entity-layout"
             data-sa-container-query='{"920":"sa-entity-layout--size--md","1100":"sa-entity-layout--size--lg"}'>
            <div class="sa-entity-layout__body">
                <div class="sa-entity-layout__main">
                    <div class="card">
                        <div class="card-body p-5">
                            <?= $this->render('/_partials/card-name-label', ['cardName' => 'Basic information']); ?>
                            <div class="row">
                                <div class="col-4 mb-4">
                                    <?= $form->field($model, 'order_status_id')->dropDownList(
                                        ArrayHelper::map(OrderStatus::find()->all(), 'id', 'name'),
                                        [
                                            'style' => 'font-weight: 500; font-size: 20px',
                                            'id' => 'order-status-dropdown',
                                        ],
                                    ) ?>
                                </div>
                                <div class="col-4 mb-4">
                                    <?= $form->field($model, 'order_pay_ment_id')->dropDownList(
                                        ArrayHelper::map(OrderPayMent::find()->all(), 'id', 'name'),
                                        [
                                            'style' => 'font-weight: 500; font-size: 20px',
                                            'id' => 'order-payment-status-dropdown',
                                        ],
                                    ) ?>
                                </div>
                                <div class="col-4 mb-4">
                                    <?= $form->field($model, 'order_provider_id')->dropDownList(
                                        ArrayHelper::map(OrderProvider::find()->all(), 'id', 'name')
                                    ) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 sm-2 mb-4">
                                    <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                                        'mask' => '+38(999)999 9999',
                                    ]) ?>
                                </div>
                                <div class="col-4 sm-5 mb-4">
                                    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-4 sm-5 mb-4">
                                    <?php echo $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div>
                                <div class="mb-4">
                                    <?= $form->field($model, 'note')->textarea(['rows' => 4]) ?>
                                </div>
                                <div class="mb-4">
                                    <?= $form->field($model, 'comment')->textarea(['rows' => 4]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var paymentDropdown = document.getElementById('order-payment-status-dropdown');
        var orderDropdown = document.getElementById('order-status-dropdown');

        var updatePaymentBackgroundColor = function () {
            if (paymentDropdown.value === '3') {
                paymentDropdown.style.backgroundColor = '#4ee95e5c';
            } else if (paymentDropdown.value === '1') {
                paymentDropdown.style.backgroundColor = '#ffa5005c';
            } else if (paymentDropdown.value === '5') {
                paymentDropdown.style.backgroundColor = 'rgba(223,27,18,0.77)';
            } else if (paymentDropdown.value === '4') {
                paymentDropdown.style.backgroundColor = 'rgba(79,76,76,0.47)';
            } else {
                paymentDropdown.style.backgroundColor = ''; // Установить в пустую строку для значения по умолчанию
            }
        };

        var updateOrderBackgroundColor = function () {
            switch (orderDropdown.value) {
                case '1':
                    orderDropdown.style.backgroundColor = 'rgba(80,172,243,0.36)'; // Желтый цвет для "Очікується"
                    break;
                case '2':
                    orderDropdown.style.backgroundColor = 'rgba(231, 195, 6, 0.7)'; // Голубой цвет для "Комплектується"
                    break;
                case '6':
                    orderDropdown.style.backgroundColor = '#ffa5005c'; // Оранжевый цвет для "Доставляється"
                    break;
                case '5':
                    orderDropdown.style.backgroundColor = 'rgba(79,76,76,0.47)'; // Красный цвет для "Відміна"
                    break;
                case '3':
                    orderDropdown.style.backgroundColor = '#4ee95e5c'; // Зеленый цвет для "Одержано"
                    break;
                case '4':
                    orderDropdown.style.backgroundColor = 'rgba(223,27,18,0.77)'; // Серый цвет для "Повернення"
                    break;
                default:
                    orderDropdown.style.backgroundColor = ''; // Установить в пустую строку для значения по умолчанию
            }
        };

        // Обработчики события изменения значения
        paymentDropdown.addEventListener('change', updatePaymentBackgroundColor);
        orderDropdown.addEventListener('change', updateOrderBackgroundColor);

        // Вызовем функции для установки начального цвета при загрузке страницы
        updatePaymentBackgroundColor();
        updateOrderBackgroundColor();
    });
</script>

