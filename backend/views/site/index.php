<?php

/** @var yii\web\View $this */

$this->title = 'Admin AgroPro';
?>
    <div id="top" class="sa-app__body px-2 px-lg-4">
        <div class="container" style="max-width: 1500px">
            <div class="py-2">
<!--                <div class="row g-4 align-items-center">-->
<!--                    <div class="col"><h1 class="h3 m-0">Статистика</h1></div>-->
<!--                    <div class="col-auto d-flex">-->
<!--                        <select class="form-select me-3">-->
<!--                            <option selected="">7 October, 2021</option>-->
<!--                        </select>-->
<!--                        <a href="/#" class="btn btn-primary">Export</a>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <?= $this->render('dashboard') ?>
        </div>
    </div>
