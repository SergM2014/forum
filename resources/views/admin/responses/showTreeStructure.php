<?php if(empty($responsesDropDownList)): ?>

    <p class="green-text"><?= $yourFirstResponseL ?></p>

<?php else: ?>
<ul id="responseStructure" class="responses_list list">
    <?= $responsesDropDownList ?>
</ul>

<?php endif; ?>