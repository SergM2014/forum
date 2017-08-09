
<?php if(isset($_SESSION['admin'])): ?>

<h2 class="admin-zone--greeting"><?= $adminGreetingsL ?></h2>

<?php else : ?>

    <?php include PATH_SITE.'/resources/views/admin/partials/login.php'; ?>


<?php endif; ?>


