<?php
//
//var_dump($comment);
//?>
<div class='parent-comment__output'>
    <div class="parent-comment__output-padding">
        <h3 class="add_response centered"><?= $CommentToRespondeTitleL ?></h3>
        <div class="clearfix">
            <img src="/img/small-close.png" alt="" title="close parent comment" class="parent-comment__close-sign" id="parentCommentCloseSign">
        </div>
        <div class='response_user_info'><?= $addedL ?>: <?= $comment->member_added_at ?>;

            <?php  if($comment->avatar): ?>
                <img src= '/uploads/avatars/<?= $comment->avatar ?>' alt='' class="response-item__avatar">
            <?php endif; ?>

            <br><?= $nameL ?>: <?= $comment->member_name ?></div>
        <div class='response_user_text'><?= $comment->response ?></div>
    </div>


</div>