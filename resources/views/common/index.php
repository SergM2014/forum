<section class="breadcrumbs">

    <span class="breadcrumb__item--current"><?= $mainPageL ?></span>

</section>




<h1 class="main-header__h1"><?= $mainPageL ?></h1>

<div class="table-container">

    <table class="table">
        <tr><th><?= $titleL ?></th><th><?= $topicAmountL ?></th><th><?= $responseAmountL ?></th><th><?= $latestResponseL ?></th>
            <th><?= $addedL ?></th><th><?= $nameL ?></th></tr>
        <?= $result ?>
    </table>

</div>



<p>
    <?= $visitorsOnlineL ?>: <?= $visitorsOnline ?>
</p>

<p>
    <?= $membersOnlineL ?>: <?= $membersOnline ?>
</p>

<p>
    <?= $responseAmountL ?>: <?= $responsesAmount ?>
</p>

<p>
    <?= $lastRegisteredMemberNameL ?>: <?= $lastMemberName ?>
</p>

<p>
    <?= $membersAmountL ?> : <?= $membersAmount ?>
</p>









