<p><a href='<?= \Lib\HelperService::currentLang()?>/admin/members/create' class='popUp-menu-item'><?= $addL ?></a></p>
<p><a href='<?= \Lib\HelperService::currentLang()?>/admin/members/<?= (int)$_POST['id'] ?>/edit' class='popUp-menu-item'><?= $updateL ?></a></p>




<form id="adminDeleteMemberForm" action="<?= \Lib\HelperService::currentLang() .'/admin/members/'.$_POST['id']?>/delete" method="post" class="">

    <input type="hidden" name="id" id="memberId" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>" >


    <button type="button" class="popUp-menu__delete-item" id="adminDeleteMember" ><?= $deleteL ?></button>

</form>

