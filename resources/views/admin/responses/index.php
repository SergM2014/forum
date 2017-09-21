<h1 class="h1">This is topics</h1>

<section class="centered">
    <table>
        <tr>
            <th>#</th>
            <th><?= $topicL ?></th>
            <th><?= $memberL ?></th>
            <th><?= $responseL ?></th>
            <th><?= $publishedL ?></th>
            <th><?= $changedL ?></th>
            <th><?= $addedAtL ?></th>
        </tr>
        <?php foreach($responses as $response): ?>

            <tr class="table__row response-item" data-response-id="<?= $response->id ?>">
                <td><?= @$counter? ++$counter: $counter=1 ?></td>
                <td><?= $response->title ?></td>
                <td><?= $response->name ?></td>
                <td><?= $response->response ?></td>
                <td class="<?= $response->published ==1? 'green':'red' ?>"><?= $response->published == 1? $yesL: $noL ?></td>
                <td class="<?= $response->changed ==1? 'red': 'green' ?>"><?= $response->changed == 1? $yesL: $noL ?></td>
                <td><?= $response->created_at ?></td>
            </tr>

        <?php endforeach ?>
    </table>

    <?php include PATH_SITE.'/resources/views/admin/partials/pagination.php' ?>

</section>
