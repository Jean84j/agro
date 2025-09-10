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
    <span><?= htmlspecialchars($data['country']) ?></span>
<p><?= htmlspecialchars($data['ip'] ?? '') ?></p>
<?php else: ?>
    <span class="flag-icon flag-icon"></span>
    <p><?= htmlspecialchars($data['ip'] ?? '') ?></p>
<?php endif; ?>
