<?php
/** @var array|null $data */
if (!$data) {
    echo "<p>Нет данных по IP.</p>";
    return;
}
$countryCode = strtolower($data['country'] ?? '');
?>
<?php if ($countryCode): ?>
    <span class="flag-icon flag-icon-<?= $countryCode ?>"></span>
    <p><strong>IP: </strong> <?= htmlspecialchars($data['ip'] ?? '') ?></p>
    <p><strong>Страна: </strong> <?= htmlspecialchars($data['country'] ?? '') ?></p>
    <p><strong>Регион: </strong> <?= htmlspecialchars($data['region'] ?? '') ?></p>
    <p><strong>Город: </strong> <?= htmlspecialchars($data['city'] ?? '') ?></p>
    <p><strong>Провайдер: </strong> <?= htmlspecialchars($data['org'] ?? '') ?></p>
<?php else: ?>
    <p><?= htmlspecialchars($data['ip'] ?? '') ?></p>
<?php endif; ?>
