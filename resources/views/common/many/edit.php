<section class="breadcrumbs">

    <span class="breadcrumb__item--current">Main Page</span>

</section>





<section class="centered">

    <h1 class="main-header__h1">edit Many Pictures</h1>

        <?php if($result->imagesArray): ?>

            <div class="images-container" id="manyImagesContainer">
                <?php foreach ($result->imagesArray as $image): ?>

                    <div class="image-item"><img class="image" src="/uploads/manyItems/<?= $image ?>" alt="" data-image="<?= $image ?>" title="<?= $dragToMoveAndClickToDel ?>"></div>

                <?php endforeach; ?>
            </div>
        <?php endif; ?>

<?php
        $givenImage = @array_pop($_POST['imageData']);
        $imageCustomType = 'manyItems';
        $path = '/uploads/manyItems/';
        include   PATH_SITE.'/resources/views/common/partials/addImage.php';

    ?>

    <form action="<?= \Lib\HelperService::currentLang() ?>/many/update" method="post" >
        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">
        <input type="hidden" name="userId" value = "<?= @$result->id ?>" >
        <input type="hidden" name="imageData" id="imageData" value="<?= $_POST['imageData']?? @$result->images ?>">

        <div class="subscribtion-form__field-block">

            <label class="form-field__label">
                Change title <br>
                <input type="text" name="title" value = "<?=  @$_POST['title']?? @$result->title ?>" >
                <p><small class="error"><?= @$errors['title'] ?></small></p>
            </label>
        </div>


        <div class="subscribtion-form__field-block">
            <label class="form-field__label">
                change Description <br>
                <textarea name="describtion" cols="40" rows="10" ><?=  @$_POST['describtion']?? @$result->describtion ?></textarea>
                <p><small class="error"><?= @$errors['describtion'] ?></small></p>
            </label>
        </div>


        <br>
        <p>
            <button class="subscribtion-form__button">OK</button>
        </p>
    </form>


    <script src="//cdnjs.cloudflare.com/ajax/libs/Sortable/1.6.0/Sortable.min.js"></script>
</section>







