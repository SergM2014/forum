<h1 class="content-zone__header"><?= $createTopicL ?></h1>
<section class="centered">

    <form action="<?= \Lib\HelperService::currentLang() ?>/admin/topic/store" method="post">
        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">
    <p><?= $chooseParentCategoryL ?></p>
    <select name="parentId">

        <?= $categoryDropDownList ?>
    </select>

    <p><?= $chooseMemberL ?></p>
        <select name="memberId">
            <?php foreach($members as $member): ?>
            <option value="<?= $member->id ?>"><?= $member->name ?></option>

            <?php endforeach; ?>
        </select>

        <div class="form__field-block">

            <label class="form-field__label">
                <?= $titleL ?> <br>
                <p><input type="text" name="title" value = "<?=  @$_POST['title']?>" ></p>

                <p><small class="error"><?= @$errors['title'] ?></small></p>
            </label>
        </div>

        <br>

        <p>
            <button  type="submit" class="form__button"><?= $addTopicL ?></button>
        </p>

    </form>

</section>

