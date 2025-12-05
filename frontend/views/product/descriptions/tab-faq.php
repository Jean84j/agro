<?php

/** @var  $faq */

?>
<div class="product-tabs__pane" id="tab-faq">
    <div class="spec">
        <h2 class="spec__header"><?= Yii::t('app', 'Часті запитання') ?></h2>
        <div class="spec__section">
            <?php foreach ($faq as $item): ?>
                <div class="faq">
                    <h3 class="faq-title"><?= $item['question'] ?></h3>
                    <p class="faq-text">
                        <?= $item['answer'] ?>
                    </p>
                    <button class="faq-toggle" aria-label="Toggle FAQ">
                        <i class="fas fa-chevron-down"></i>
                        <i class="fas fa-chevron-up"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="spec__disclaimer">

        </div>
    </div>
</div>
