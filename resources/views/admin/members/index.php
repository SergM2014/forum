<h1 class="h1"><?= $membersL ?></h1>





<section class="centered">

    <div class="order-selector">
        <form method="get" action="/admin/members">

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
            <th><?= $avatarL ?></th>
            <th><?= $nameL ?></th>
            <th><?= $emailL ?></th>
            <th><?= $addedAtL ?></th>
        </tr>
        <?php foreach($members as $member): ?>

            <tr class="table__row member-item" data-member-id="<?= $member->id ?>">
                <td><?=  ++$counter ?></td>
                <td><?php if($member->avatar): ?> <img src="/uploads/avatars/<?= $member->avatar ?> " class="table-thumb" alt="" ><?php endif; ?></td>
                <td><?= $member->name ?></td>
                <td><?= $member->email ?></td>
                <td><?= $member->added_at ?></td>
            </tr>

        <?php endforeach ?>
    </table>

    <?php include PATH_SITE.'/resources/views/admin/partials/pagination.php' ?>

</section>
