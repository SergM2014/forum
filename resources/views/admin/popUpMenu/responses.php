<p><a href='<?= \Lib\HelperService::currentLang()?>/admin/response/create' class='popUp-menu-item'><?= $addL ?></a></p>
<p><a href='<?= \Lib\HelperService::currentLang()?>/admin/response/<?= (int)$_POST['id'] ?>/edit' class='popUp-menu-item'><?= $updateL ?></a></p>




<form id="adminDeleteResponseForm" action="<?= \Lib\HelperService::currentLang() .'/admin/response/'.$_POST['id']?>/delete" method="post" class="">

    <input type="hidden" name="id" id="responseId" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>" >


    <button type="button" class="popUp-menu__delete-item" id="adminDeleteResponse" ><?= $deleteL ?></button>

</form>

