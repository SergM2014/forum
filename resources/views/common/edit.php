<section class="breadcrumbs">

    <span class="breadcrumb__item--current">Main Page</span>

</section>





<section class="centered">

    <h1 class="main-header__h1">edit</h1>
    <?php

        $imageCustomType = 'avatar';
        $givenImage = $_POST['imageData']?? @$user->avatar;
        $path = '/uploads/avatars/';
        include   PATH_SITE.'/resources/views/common/partials/addImage.php';

    ?>

    <form action="<?= \Lib\HelperService::currentLang() ?>/index/update" method="post" >
        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">
        <input type="hidden" name="userId" value = "<?= @$user->id ?>" >
        <input type="hidden" name="imageData" id="imageData" value = "<?= $givenImage ?>" >
        <div class="subscribtion-form__field-block">

            <label class="form-field__label">
                Cahange Name <br>
                <input type="text" name="login" value = "<?=  @$_POST['login']?? @$user->login ?>" >
                <p><small class="error"><?= @$errors['login'] ?></small></p>
            </label>
        </div>


        <div class="subscribtion-form__field-block">
            <label class="form-field__label">
                change Email <br>
                <input type="text" name="email" value = "<?=  @$_POST['email']?? @$user->email ?>" >
                <p><small class="error"><?= @$errors['email'] ?></small></p>
            </label>
        </div>


        <br>
        <p>
            <button class="subscribtion-form__button">OK</button>
        </p>
    </form>



</section>







