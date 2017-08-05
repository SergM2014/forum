<?php if(empty($results)): ?>

    <span><?= $nothingIsFound ?></span>

<?php else: ?>

    <?php foreach($results as $result): ?>

        <p><a href="/response/<?= $result->id ?>#show"><?= \Lib\HelperService::reduceString($result->response) ?></a></p>

    <?php endforeach; ?>

<?php endif; ?>
