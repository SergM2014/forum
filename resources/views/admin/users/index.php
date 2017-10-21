<h1 class="h1"><?= $adminsL ?></h1>

<?php var_dump($_SESSION) ?>



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
            <th><?= $loginL ?></th>
            <th><?= $emailL ?></th>
            <th><?= $roleL ?></th>
            <th><?= $addedAtL ?></th>
        </tr>
        <?php foreach($users as $user): ?>

            <tr class="table__row user_item" data-user-id="<?= $user->id ?>">
                <td><?=  ++$counter ?></td>
                <td><?php if($user->avatar): ?> <img src="/uploads/avatars/<?= $user->avatar ?> " class="table-thumb" alt="" ><?php endif; ?></td>
                <td><?= $user->login ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->role ?></td>
                <td><?= $user->created_at ?></td>
            </tr>

        <?php endforeach ?>
    </table>

    <?php include PATH_SITE.'/resources/views/admin/partials/pagination.php' ?>

</section>