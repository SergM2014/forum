<p><a href='<?= \Lib\HelperService::currentLang()?>/admin/category/create' class='popUp-menu-item'><?= $addL ?></a></p>
<p><a href='<?= \Lib\HelperService::currentLang()?>/admin/category/<?= (int)$_POST['id'] ?>/edit' class='popUp-menu-item'><?= $updateL ?></a></p>




<form id="" action="<?= \Lib\HelperService::currentLang() .'/admin/category/'.$_POST['id']?>/delete" method="post" class="">

    <input type="hidden" name="id" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>" >


    <button type="button" class="popUp-menu__delete-item" id="adminDeleteCategory" ><?= $deleteL ?></button>

</form>

