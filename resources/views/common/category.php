<section class="breadcrumbs">

    <a href="/" class="breadcrumb__item"><?= $mainPageL ?></a> =>
    <span class="breadcrumb__item--current"><?= $categoryL ?></span>

</section>




<h1 class="main-header__h1"><?= $categoryL ?></h1>

<div class="table-container">

    <table class="table">
        <tr>
            <th><?= $topicTitleL ?></th><th><?= $responseAmountL ?></th><th><?= $latestResponseL ?></th>
        </tr>
       <?php foreach ($categoryTopics as $topic): ?>

           <tr>
               <td><?php if($topic->title): ?>
                   <a href="<?= \Lib\HelperService::currentLang() ?>/topic/<?= $topic->eng_title ?>"><?= $topic->title ?></a> <?php else: ?>
                    <?= $noThemaL ?>
                   <?php endif; ?>
               </td>
               <td><?= $topic->response_amount ?></td>
               <td><?php  if($topic->response_id): ?>

                   <a href="<?= \Lib\HelperService::currentLang() ?>/response/<?= $topic->response_id ?>"><?= $topic->response ?></a>
                   <p><?= $addedL ?>:  <?= $topic->added ?></p>
                   <p><?= $authorL ?>: <?= $topic->name ?></p>

                   <?php endif; ?>

               </td>
           </tr>

        <?php endforeach; ?>
    </table>

</div>


<?php if(isset($_SESSION['member'])): ?>

    <div class="clearfix create-category__btn-container">
        <a href="<?= \Lib\HelperService::currentLang() ?>/category/<?= $categoryId ?>/create/topic" class="create-category__btn"> <?= $addTopicL ?></a>
    </div>

<?php endif; ?>

<?php  include_once PATH_SITE.'/resources/views/common/partials/siteStatistic.php' ?>

