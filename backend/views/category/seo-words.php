<?php

use backend\models\SeoWords;

$words = SeoWords::find()->where(['category_id' => $model->id])->all();
?>
<div class="card mt-5">
    <div class="card-header">
        <?= $this->render('/_partials/card-name-label', ['cardName' => 'SEO слова']); ?>
    </div>
    <div class="card-body">
        <div class="card">
            <div class="sa-divider"></div>
            <table class="table table-hover mb-0">
                <thead>
                <tr>
                    <th>id</th>
                    <th class="min-w-15x">UK</th>
                    <th class="min-w-15x">RU</th>
                    <th class="min-w-15x">Товар</th>
                    <th class="min-w-15x">Ктегорія</th>
                </tr>
                </thead>
                <tbody id="seo-words-table">
                <?php if (!empty($words)): ?>
                    <?php foreach ($words as $word): ?>
                        <tr>
                            <td><?= $word->id ?></td>
                            <td><?= $word->uk_word ?></td>
                            <td><?= $word->ru_word ?></td>
                            <td><?= $model->getProductName($word->product_id) ?></td>
                            <td><?= $model->getCategoryName($word->category_id)?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

