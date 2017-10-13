<section class="modal-window" id="deleteModalWindow">
    <h1 class="modal-window__text"><?= $shureToDelUserL ?></h1>
    <div class="modal-window__footer">

        <form id ="delUserForm">
            <input type="hidden" name="userId"  value="<?= (int)$_POST['id'] ?>">
            <input type="hidden" name="_token" value="<?= Lib\TokenService::printTocken('admin') ?>">

            <button type="button" id= "confirmDelAdmUser" class="modal-window__btn">OK</button>
        </form>

        <button type="button" id="canselBtn" class="modal-window__btn">Cansel</button>
    </div>
</section>