<p><a href='<?= \Lib\HelperService::currentLang()?>/admin/users/create' class='popUp-menu-item'><?= $addL ?></a></p>
<p><a href='<?= \Lib\HelperService::currentLang()?>/admin/users/<?= (int)$_POST['id'] ?>/edit' class='popUp-menu-item'><?= $updateL ?></a></p>




<form id="adminDeleteUserForm" action="<?= \Lib\HelperService::currentLang() .'/admin/users/'.$_POST['id']?>/delete" method="post" class="">

    <input type="hidden" name="id" id="userId" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>" >


    <button type="button" class="popUp-menu__delete-item" id="adminDeleteUser" ><?= $deleteL ?></button>

</form>

