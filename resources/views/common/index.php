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


<div class="general-info">

    <span>
    <?= $visitorsOnlineL ?>: <?= $visitorsOnline ?>
</span>

    <span>
    <?= $membersOnlineL ?>: <?= $membersOnline ?>
</span>

    <span>
    <?= $responseAmountL ?>: <?= $responsesAmount ?>
</span>

    <span>
    <?= $lastRegisteredMemberNameL ?>: <?= $lastMemberName ?>
</span>

    <span>
    <?= $membersAmountL ?> : <?= $membersAmount ?>
</span>

</div>










