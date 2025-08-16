<?php


?>

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


