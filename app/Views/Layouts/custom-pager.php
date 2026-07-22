<?php if($pager->getPageCount() > 1): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if($pager->hasPrevious()): ?>
                <li class="page-item">
                    <a href="<?= $pager->getPrevious() ?>" class="page-link">Previous</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
            <?php endif; ?>

            <?php foreach($pager->links() as $link): ?>
                <li class="page-item <?= $link["active"] ? "active" : "" ?>">
                    <a href="<?= $link["uri"] ?>" class="page-link"><?= $link["title"] ?></a>
                </li>
            <?php endforeach; ?>

            <?php if($pager->hasNext()): ?>
                <li class="page-item">
                    <a href="<?= $pager->getNext() ?>" class="page-link">Next</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif ?>