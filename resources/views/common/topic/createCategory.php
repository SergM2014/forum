<h1 class="content-zone__header"><?= $createCategoryL ?></h1>

<section class="centered">



    <form action="<?= \Lib\HelperService::currentLang() ?>/category/store" method="post">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('member') ?>">

        <p>
            <select size="1" name="parentId">
                <option value="0" selected><?= $designateParentL ?></option>
                <?= $categories ?>
            </select>
        </p>

        <br>

        <div class="form__field-block">

            <label class="form-field__label">
                <?= $titleL ?> <br>
                <p><input type="text" name="title" value = "<?=  @$_POST['title']?>" ></p>

                <p><small class="error"><?= $errors['title'] ?></small></p>
            </label>
        </div>

        <br>

        <p>
            <button  type="submit" class="form__button"><?= $addCategoryL ?></button>
        </p>


    </form>
</section>