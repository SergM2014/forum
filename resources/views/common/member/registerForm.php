<section class="centered register-form">

    <h1><?= $signUpL ?></h1>
    <?php

    $imageCustomType = 'avatar';
    $givenImage = @$_POST['imageData'];
    $path = '/uploads/avatars/';
    include   PATH_SITE.'/resources/views/common/partials/addImage.php';

    ?>

    <form action="<?= \Lib\HelperService::currentLang() ?>/saveMember" method="post" class="form">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('user') ?>">
        <input type ="hidden" name="imageData" id="imageData" value="">

        <div class="form_field-block">
            <label class="form-field__label" for="name"><?= $nameL ?></label>
            <p><input type="text" class="input-field" id="name" name="name" value="<?= @$_POST['name'] ?>" ></p>
            <p><small id="nameError" class="error"><?= @$errors['name'] ?></small></p>
        </div>

        <div class="form_field-block">
            <label class="form-field__label" for="email"><?= $emailL ?></label>
            <p><input type="text" class="input-field" id="email" name="email" value="<?= @$_POST['email'] ?>" ></p>
            <p><small id="emailError" class="error"><?= @$errors['email'] ?></small></p>
        </div>


        <div class="form_field-block">
            <label class="form-field__label" for="password"><?= $passwordL ?></label>
            <p><input type="password" class="input-field" id="password" name="password" value="<?= @$_POST['password'] ?>"></p>
            <p><small id="passwordError" class="error"><?= @$errors['password'] ?></small></p>
        </div>

        <div class="form_field-block">
            <label class="form-field__label" for="password2"><?= $repeatPasswordL ?></label>
            <p><input type="password" class="input-field" id="password2" name="password2" value="<?= @$_POST['password2'] ?>"></p>
            <p><small id="password2Error" class="error"><?= @$errors['password2'] ?></small></p>
        </div>


        <br>
        <p>
            <button type="submit" class="subscribtion-form__button" id="addMemberSubmitBtn"><?= $signUpL ?></button>
        </p>

    </form>
</section>