<?php
function renderPagination($pagination, $baseUrl) {
    if ($pagination['lastPage'] <= 1) return;
    ?>
<nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center">
        <?php if ($pagination['currentPage'] > 1): ?>
        <li class="page-item">
            <a class="page-link" href="<?= $baseUrl ?>?page=<?= $pagination['currentPage'] - 1 ?>">Previous</a>
        </li>
        <?php endif; ?>

        <?php
            $start = max(1, $pagination['currentPage'] - 2);
            $end = min($pagination['lastPage'], $pagination['currentPage'] + 2);
            
            if ($start > 1): ?>
        <li class="page-item">
            <a class="page-link" href="<?= $baseUrl ?>?page=1">1</a>
        </li>
        <?php if ($start > 2): ?>
        <li class="page-item disabled"><span class="page-link">...</span></li>
        <?php endif; ?>
        <?php endif;

            for ($i = $start; $i <= $end; $i++): ?>
        <li class="page-item <?= $i === $pagination['currentPage'] ? 'active' : '' ?>">
            <a class="page-link" href="<?= $baseUrl ?>?page=<?= $i ?>"><?= $i ?></a>
        </li>
        <?php endfor;

            if ($end < $pagination['lastPage']): ?>
        <?php if ($end < $pagination['lastPage'] - 1): ?>
        <li class="page-item disabled"><span class="page-link">...</span></li>
        <?php endif; ?>
        <li class="page-item">
            <a class="page-link"
                href="<?= $baseUrl ?>?page=<?= $pagination['lastPage'] ?>"><?= $pagination['lastPage'] ?></a>
        </li>
        <?php endif; ?>

        <?php if ($pagination['currentPage'] < $pagination['lastPage']): ?>
        <li class="page-item">
            <a class="page-link" href="<?= $baseUrl ?>?page=<?= $pagination['currentPage'] + 1 ?>">Next</a>
        </li>
        <?php endif; ?>
    </ul>
</nav>
<?php
}
?>