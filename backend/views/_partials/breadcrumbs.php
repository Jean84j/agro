<?php

use yii\bootstrap5\Breadcrumbs;

?>
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
