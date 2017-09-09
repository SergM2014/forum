<section class="modal-window" id="deleteModalWindow">
    <h1 class="modal-window__text"><?= $shureToDelTopicL ?></h1>
    <div class="modal-window__footer">
        <form id ="delTopicForm">

            <input type="hidden" name="topicId"  value="<?= (int)$_POST['id'] ?>">
            <input type="hidden" name="_token" value="<?= Lib\TokenService::printTocken('admin') ?>">

            <button type="button" id= "confirmDelAdmTopic" class="modal-window__btn">OK</button>
        </form>

        <button type="button" id="canselBtn" class="modal-window__btn">Cansel</button>
    </div>
</section>