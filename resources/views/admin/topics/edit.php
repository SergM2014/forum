<h1 class="content-zone__header"><?= $updateTopicL ?></h1>
<section class="centered">

    <form action="<?= \Lib\HelperService::currentLang() ?>/admin/topic/<?= $id ?>/update" method="post">
        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">
    <p><?= $chooseParentCategoryL ?></p>
    <select name="categoryId">

        <?= $categoryDropDownList ?>
    </select>

    <p><?= $chooseMemberL ?></p>

        <select name="memberId">
            <?= $memberId = $_POST['memberId']?? $memberId; ?>
            <?php foreach($members as $member): ?>
            <option <?=  $memberId == $member->id? 'selected':'' ?> value="<?= $member->id ?>"><?= $member->name ?></option>

            <?php endforeach; ?>
        </select>

        <div class="form__field-block">

            <label class="form-field__label">
                <?= $titleL ?> <br>
                <p><input type="text" name="title" value = "<?= $_POST['title']?? @$title?>" ></p>

                <p><small class="error"><?= @$errors['title'] ?></small></p>
            </label>
        </div>

        <br>

        <p>
            <button  type="submit" class="form__button"><?= $updateTopicL ?></button>
        </p>

    </form>

</section>

