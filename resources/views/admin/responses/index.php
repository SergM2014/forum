<h1 class="h1"><?= $responsesL ?></h1>





<section class="centered">

    <div class="order-selector">
        <form method="get" action="/admin/responses">

            <select name="order">
                <option value="nameAZ" <?= @$_POST['order'] == "nameAZ"? 'selected':'' ?>><?= $membersAZL ?></option>
                <option value="nameZA" <?= @$_POST['order'] == "nameZA"? 'selected':'' ?>><?= $membersZAL ?></option>
                <option value="oldestFirst" <?= @$_POST['order'] == "oldestFirst"? 'selected':'' ?> ><?= $oldFirstL ?></option>
                <option value="newestFirst" <?= @$_POST['order'] == "newestFirst"? 'selected':'' ?> ><?= $newFirstL ?></option>
            </select>

            <button type="submit">OK</button>

        </form>
    </div>


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
                <td><?=  ++$counter ?></td>
                <td><?= $response->title ?></td>
                <td><?= $response->name ?></td>
                <td><?= $response->response ?></td>
                <td class="<?= $response->published ==1? 'green':'red' ?>" data-response-publish-field ="<?= $response->id ?>"><?= $response->published == 1? $yesL: $noL ?></td>
                <td class="<?= $response->changed ==1? 'red': 'green' ?>"><?= $response->changed == 1? $yesL: $noL ?></td>
                <td><?= $response->created_at ?></td>
            </tr>

        <?php endforeach ?>
    </table>

    <?php include PATH_SITE.'/resources/views/admin/partials/pagination.php' ?>

</section>
