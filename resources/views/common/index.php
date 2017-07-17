<section class="breadcrumbs">

    <span class="breadcrumb__item--current"><?= $mainPageL ?></span>

</section>




<h1 class="main-header__h1"><?= $mainPageL ?></h1>

<div class="table-container">

    <table class="table">
        <tr>
            <th><?= $titleL ?></th><th><?= $topicAmountL ?></th><th><?= $responseAmountL ?></th><th><?= $latestResponseL ?></th>
        </tr>
        <?= $result ?>
    </table>

</div>


<?php  include_once PATH_SITE.'/resources/views/common/partials/siteStatistic.php' ?>









