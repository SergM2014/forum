<h1 class="content-zone__header"><?= $addTopicL ?></h1>

<section class="centered">



    <form action="<?= \Lib\HelperService::currentLang() ?>/topic/store" method="post">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('member') ?>">
        <input type="hidden" name="categoryId" value="<?= $id ?>">



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
            <button  type="submit" class="form__button"><?= $saveTopicL ?></button>
        </p>


    </form>
</section>