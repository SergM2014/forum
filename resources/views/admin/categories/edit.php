<h1 class="content-zone__header"><?= $editCategoryL ?></h1>
<section class="centered">

    <form action="<?= \Lib\HelperService::currentLang() ?>/admin/category/<?= $categoryId ?>/update" method="post">
        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">
    <p><?= $chooseParentCategoryL ?></p>
    <select name="parentId">
        <option value="0"><?= $designateParentL ?></option>
        <?= $categoryDropDownList ?>
    </select>

        <div class="form__field-block">

            <label class="form-field__label">
                <?= $titleL ?> <br>
                <p><input type="text" name="title" value = "<?=  $title?? @$_POST['title']?>" ></p>

                <p><small class="error"><?= @$errors['title'] ?></small></p>
            </label>
        </div>

        <br>

        <p>
            <button  type="submit" class="form__button"><?= $updateCategoryL ?></button>
        </p>

    </form>

</section>

