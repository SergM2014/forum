<section class="centered register-form">

    <h1><?= $signInL ?></h1>


    <form action="<?= \Lib\HelperService::currentLang() ?>/getMember" method="post" class="form">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('user') ?>">

        <?php if(@$loginError): ?>
          <span class="error"><?= $loginErrorL ?></small></span>
        <?php endif; ?>

        <div class="form_field-block">
            <label class="form-field__label" for="name"><?= $nameL ?></label>
            <p><input type="text" class="input-field" id="name" name="name" value="<?= @$_POST['name'] ?>" ></p>
        </div>


        <div class="form_field-block">
            <label class="form-field__label" for="password"><?= $passwordL ?></label>
            <p><input type="password" class="input-field" id="password" name="password" value="<?= @$_POST['password'] ?>"></p>
        </div>


        <br>
        <p>
            <button type="submit" class="login-form__button" id="loginMemberSubmitBtn"><?= $logInL ?></button>
        </p>

    </form>
</section>