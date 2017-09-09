<p><a href='<?= \Lib\HelperService::currentLang()?>/admin/topic/create' class='popUp-menu-item'><?= $addL ?></a></p>
<p><a href='<?= \Lib\HelperService::currentLang()?>/admin/topic/<?= (int)$_POST['id'] ?>/edit' class='popUp-menu-item'><?= $updateL ?></a></p>




<form id="adminDeleteTopicForm" action="<?= \Lib\HelperService::currentLang() .'/admin/topic/'.$_POST['id']?>/delete" method="post" class="">

    <input type="hidden" name="id" id="topicId" value="<?= (int)$_POST['id'] ?>">
    <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>" >


    <button type="button" class="popUp-menu__delete-item" id="adminDeleteTopic" ><?= $deleteL ?></button>

</form>

