<?php
/** @var array|null $data */
if (!$data) {
    echo "<p>Нет данных по IP.</p>";
    return;
}
$countryCode = strtolower($data['country'] ?? '');
?>
<?php if ($countryCode): ?>
    <table class="table table-hover table-bordered shadow-sm rounded-3" style="max-width: 500px;">
        <thead class="table-light">
        <tr>
            <th colspan="2" class="text-center fs-5">
                <span class="flag-icon flag-icon-<?= $countryCode ?>"></span> Информация об IP
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">IP</th>
            <td><?= htmlspecialchars($data['ip'] ?? '') ?></td>
        </tr>
        <tr>
            <th scope="row">Страна</th>
            <td><?= htmlspecialchars($data['country'] ?? '') ?></td>
        </tr>
        <tr>
            <th scope="row">Регион</th>
            <td><?= htmlspecialchars($data['region'] ?? '') ?></td>
        </tr>
        <tr>
            <th scope="row">Город</th>
            <td><?= htmlspecialchars($data['city'] ?? '') ?></td>
        </tr>
        <tr>
            <th scope="row">Провайдер</th>
            <td><?= htmlspecialchars($data['org'] ?? '') ?></td>
        </tr>
        <tr>
            <th scope="row">Координаты</th>
            <td><?= htmlspecialchars($data['loc'] ?? '') ?></td>
        </tr>
        <tr>
            <th scope="row">Час</th>
            <td><?= htmlspecialchars($data['timezone'] ?? '') ?></td>
        </tr>
        <tr>
            <th scope="row">Индекс</th>
            <td><?= htmlspecialchars($data['postal'] ?? '') ?></td>
        </tr>
        </tbody>
    </table>
<?php else: ?>
    <p><?= htmlspecialchars($data['ip'] ?? '') ?></p>
<?php endif; ?>
