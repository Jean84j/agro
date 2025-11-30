<?php

/** @var  $files */

?>
    <div class="block-images">
        <div class="container">
            <div class="block-images__slider">
                <div class="owl-carousel">
                    <?php foreach ($files as $file): ?>
                        <div class="block-images__item">
                            <img src="<?= $file ?>" width="300" height="150" alt="1"
                                 loading="lazy">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <style>
        .block-images__slider {
            border: 2px solid #f0f0f0;
            border-radius: 2px;
            margin-top: 10px;
        }

        .block-images__item {
            padding: 2px 5px;
        }

        .block-images__slider .block-images__item img {
            height: 90px;
            object-fit: contain;
        }
    </style>

<?php
$js = <<<JS
   let DIRECTION = null;

        function direction() {
            if (DIRECTION === null) {
                DIRECTION = getComputedStyle(document.body).direction;
            }

            return DIRECTION;
        }

        function isRTL() {
            return direction() === 'rtl';
        }
        
        $(function () {
            $('.block-images__slider .owl-carousel').owlCarousel({
                nav: false,
                dots: false,
                loop: true,
                rtl: isRTL(),
                autoplay: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                responsive: {
                    1200: {items: 6},
                    992: {items: 5},
                    768: {items: 4},
                    576: {items: 3},
                    0: {items: 2}
                }
            });
        });
JS;

$this->registerJs($js);