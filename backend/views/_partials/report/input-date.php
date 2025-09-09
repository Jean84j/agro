<?php

?>
<form action="<?= $action ?>" method="get">
    <div class="row mb-3">
        <label for="periodStart" class="col-sm-4 col-form-label">Початок:</label>
        <div class="col-sm-7">
            <input type="date" class="form-control" id="periodStart" name="periodStart"
                   value="<?= htmlspecialchars($periodStart) ?>"
                   max="<?= htmlspecialchars($periodEnd) ?>" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="periodEnd" class="col-sm-4 col-form-label">Кінець:</label>
        <div class="col-sm-7">
            <input type="date" class="form-control" id="periodEnd" name="periodEnd"
                   value="<?= htmlspecialchars($periodEnd) ?>"
                   min="<?= htmlspecialchars($periodStart) ?>" required>
        </div>
    </div>
    <?php if (isset($budget)) : ?>
        <div class="row mb-3">
            <label for="budget" class="col-sm-4 col-form-label">Бюджет:</label>
            <div class="col-sm-7">
                <input type="number" class="form-control" id="budget" name="budget"
                       value="<?= htmlspecialchars($budget) ?>" step="0.01" required>
            </div>
        </div>
    <?php endif; ?>
    <div class="mt-5">
        <input class="btn btn-warning" type="submit" value="Отправить">
    </div>
</form>

