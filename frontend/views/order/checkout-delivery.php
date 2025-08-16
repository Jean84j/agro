<?php

use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\widgets\MaskedInput;

?>
<div class="col-12 col-lg-6 col-xl-7">
    <div class="card mb-lg-0">
        <div class="card-body">
            <h3 class="card-title"><?= Yii::t('app', 'Інформація для доставки') ?></h3>
            <div class="form-row">
                <div class="col-md-8">
                    <?= $form->field($order, 'fio')->textInput([
                        'maxlength' => true,
                        'class' => 'form-control',
                        'options' => [
                            'id' => 'order-fio',
                        ],
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($order, 'phone')->widget(MaskedInput::class, [
                        'mask' => '+38(999)999 9999',
                    ]) ?>
                </div>
            </div>
            <div class="payment-methods">
                <ul class="payment-methods__list">
                    <li class="payment-methods__item">
                        <label class="payment-methods__item-header">
                                        <span class="payment-methods__item-radio input-radio">
                                            <span class="input-radio__body">
                                                <input class="input-radio__input" name="checkout_payment_method"
                                                       value="" type="radio">
                                                <span class="input-radio__circle"></span>
                                            </span>
                                        </span>
                            <span class="delivery-methods__item-name">
                                                <svg width="32px" height="32px" style="margin-right: 5px;">
                                                        <use xlink:href="/images/sprite.svg#novaposhta"></use>
                                                </svg>
                                            </span>
                            <span style="font-size:20px; margin:0 20px"><?= Yii::t('app', 'Нова Пошта') ?></span>
                        </label>
                        <div class="payment-methods__item-container" style="">
                            <div class="payment-methods__item-description text-muted">
                                <div class="form-group">
                                    <?php echo $form->field($order, 'area')->widget(Select2::class, [
                                        'data' => $areas,
                                        'theme' => Select2::THEME_DEFAULT,
                                        'maintainOrder' => true,
                                        'pluginLoading' => false,
                                        'options' => [
                                            'id' => 'order-areas',
                                            'data-url-cities' => Yii::$app->urlManager->createUrl(['n-p/cities']),
                                            'placeholder' => Yii::t('app', 'Виберіть область...'),
                                            'class' => 'sa-select2 form-select',
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'width' => '100%',
                                            'max-width' => '550px',
                                            'margin' => '0 auto',
                                        ],
                                    ])->label(Yii::t('app', 'Область'));
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->field($order, 'city')->widget(Select2::class, [
                                        'data' => [],
                                        'theme' => Select2::THEME_DEFAULT,
                                        'maintainOrder' => true,
                                        'pluginLoading' => false,
                                        'options' => [
                                            'id' => 'order-city',
                                            'data-url-warehouses' => Yii::$app->urlManager->createUrl(['n-p/warehouses']),
                                            'placeholder' => Yii::t('app', 'Виберіть місто...'),
                                            'class' => 'sa-select2 form-select',
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'width' => '100%',
                                            'max-width' => '550px',
                                            'margin' => '0 auto',
                                            'matcher' => new JsExpression("function(params, data) {
                                                                if ($.trim(params.term) === '') {
                                                                    return data;
                                                                }
                                                                var terms = params.term.split(' ');
                                                                for (var i = 0; i < terms.length; i++) {
                                                                    if (data.text.toUpperCase().indexOf(terms[i].toUpperCase()) === 0) {
                                                                        return data;
                                                                    }
                                                                }
                                                                return null;
                                                            }"),
                                        ],
                                    ])->label(Yii::t('app', 'Місто'));
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->field($order, 'warehouses')->widget(Select2::class, [
                                        'data' => [],
                                        'theme' => Select2::THEME_DEFAULT,
                                        'maintainOrder' => true,
                                        'pluginLoading' => false,
                                        'options' => [
                                            'id' => 'order-warehouses',
                                            'placeholder' => Yii::t('app', 'Виберіть відділення...'),
                                            'class' => 'sa-select2 form-select',
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'width' => '100%',
                                            'max-width' => '550px',
                                            'margin' => '0 auto',
                                        ],
                                    ])->label(Yii::t('app', 'Відділення'));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="payment-methods__item">
                        <label class="payment-methods__item-header">
                                        <span class="payment-methods__item-radio input-radio">
                                            <span class="input-radio__body">
                                                <input class="input-radio__input" name="checkout_payment_method"
                                                       value="ukrpost" type="radio">
                                                <span class="input-radio__circle"></span>
                                            </span>
                                        </span>
                            <span class="payment-methods__item-name">
                                                    <svg width="32px" height="32px" style="margin-right: 5px;">
                                                        <use xlink:href="/images/sprite.svg#ukrposhta"></use>
                                                </svg> </span>
                            <span style="font-size:20px; margin:0 20px"><?= Yii::t('app', 'Укрпошта') ?></span>
                        </label>
                        <div class="payment-methods__item-container" style="">
                            <div class="payment-methods__item-description text-muted">
                                <?= $form->field($order, 'ukrIndex')->textInput([
                                    'id' => 'ukr-post-area',
                                    'maxlength' => 5,
                                ])->label('Індекс') ?>

                                <?= $form->field($order, 'ukrCity')->textInput([
                                    'id' => 'ukr-post-city',
                                    'maxlength' => true,
                                    'class' => 'form-control'
                                ])->label('Місто/Село') ?>
                            </div>
                        </div>
                    </li>
                    <li class="payment-methods__item">
                        <label class="payment-methods__item-header">
                                        <span class="payment-methods__item-radio input-radio">
                                            <span class="input-radio__body">
                                                <input class="input-radio__input" name="checkout_payment_method"
                                                       value="beznal" type="radio">
                                                <span class="input-radio__circle"></span>
                                            </span>
                                        </span>
                            <span class="payment-methods__item-name">
                                                    <i style="font-size: 25px; color: #2f720e" class="fas fa-truck"></i>
                                                    <span style="font-size:20px; margin:0 20px"><?= Yii::t('app', 'Самовивіз') ?>
                                                    </span>
                                                </span>
                        </label>
                        <div class="payment-methods__item-container" style="">
                            <div class="payment-methods__item-description text-muted">
                                <ul class="footer-contacts__contacts">
                                    <li>
                                        <i class="footer-contacts__icon fas fa-globe-americas"></i> <?= $contacts->address ?>
                                    </li>
                                    <li>
                                        <i class="footer-contacts__icon far fa-envelope"></i> <?= $contacts->email ?>
                                    </li>
                                    <li><i class="footer-contacts__icon fas fa-mobile-alt"></i> <a
                                                href="tel:<?= str_replace([' ', '(', ')', '-'], '', $contacts->tel_primary) ?>"><?= $contacts->tel_primary ?></a>
                                    </li>
                                    <li><i class="footer-contacts__icon fas fa-mobile-alt"></i> <a
                                                href="tel:<?= str_replace([' ', '(', ')', '-'], '', $contacts->tel_second) ?>"><?= $contacts->tel_second ?></a>
                                    </li>
                                    <li>
                                        <i class="footer-contacts__icon far fa-clock"></i> <?= $contacts->work_time_short ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="form-group">
                <?= $form->field($order, 'note')->textarea(['maxlength' => true, 'rows' => 4, 'class' => 'form-control']) ?>
            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
    $(document).ready(function () {

        var stock = $('input[name="checkout_payment_method"]:checked').val();

        $('input[name="checkout_payment_method"]').change(function () {
            stock = $(this).val();
            
                $('#order-areas').val("").trigger("change");
                $('#order-city').val("").trigger("change");
                $('#order-warehouses').val("").trigger("change");
                $('#ukr-post-city').val("").trigger("change");
                $('#ukr-post-area').val("").trigger("change");
           
        });
        
        if (stock !== "beznal") {
            $('#order-areas').on('change', function () {
                var urlCities = $(this).data('url-cities');
                var areaId = $(this).val();
                $.ajax({
                    url: urlCities,
                    type: 'POST',
                    data: {areaId: areaId},
                    success: function (data) {
                        if (data.cities) {
                            var citySelect = $('#order-city');
                            citySelect.empty();
                            $.each(data.cities, function (key, value) {
                                citySelect.append(new Option(value, key, false, false));
                            });
                            citySelect.trigger('change');
                        }
                    }
                });
            });

            $('#order-city').on('change', function () {
                var urlWarehouses = $(this).data('url-warehouses');
                var cityId = $(this).val();
                $.ajax({
                    url: urlWarehouses,
                    type: 'POST',
                    data: {cityId: cityId},
                    success: function (data) {
                        if (data.warehouses) {
                            var warehousesSelect = $('#order-warehouses');
                            warehousesSelect.empty();
                            $.each(data.warehouses, function (key, value) {
                                warehousesSelect.append(new Option(value, key, false, false));
                            });
                            warehousesSelect.trigger('change');
                        }
                    }
                });
            });
            $('#order-areas').select2();
            $('#order-city').select2();
            $('#order-warehouses').select2();
        }
    });

$(document).ready(function() {
    $('#order-fio').on('input', function() {
        let words = $(this).val().toLowerCase().replace(/(^|\s)\S/g, function(c) {
            return c.toUpperCase();
        });
        $(this).val(words);
    });
});

JS;
$this->registerJs($js);
?>
