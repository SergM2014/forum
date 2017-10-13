<section class="centered register-form">

    <h1 class="content-zone__header"><?= $updateUserL ?></h1>


    <form action="<?= \Lib\HelperService::currentLang() ?>/admin/users/<?= $id ?>/update" method="post" class="form">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('admin') ?>">


        <div class="form_field-block">
            <label class="form-field__label" for="login"><?= $loginL ?></label>
            <p><input type="text" class="input-field" id="login" name="login" value="<?=
                   isset($_POST['login'])? htmlspecialchars($_POST['login']): $user->login
                ?>" ></p>
            <p><small id="loginError" class="error"><?= @$errors['login'] ?></small></p>
        </div>

        <div class="form_field-block">
            <label class="form-field__label" for="email"><?= $emailL ?></label>
            <p><input type="text" class="input-field" id="email" name="email" value="<?=
                     isset($_POST['email'])? htmlspecialchars($_POST['email']): $user->email
                ?>" ></p>
            <p><small id="emailError" class="error"><?= @$errors['email'] ?></small></p>
        </div>

        <div class="form_field-block">
            <?php $role = $_POST['role']?? $user->role ?>
            <label class="form-field__label" for="email"><?= $roleL ?></label>
            <p><select class="input-field" id="role" name="role"  >
                    <option value="user" <?= @$role == 'user'? 'selected': '' ?> >user</option>
                    <option value="admin" <?= @$role == 'admin'? 'selected': '' ?> >admin</option>
                    <option value="superadmin" <?= @$role == 'superadmin'? 'selected': '' ?> >superadmin</option>
                </select></p>

        </div>


        <div class="form_field-block">
            <label class="form-field__label" for="password"><?= $passwordL ?></label>
            <p><input type="password" class="input-field" id="password" name="password" ></p>
            <p><small id="passwordError" class="error"><?= @$errors['password'] ?></small></p>
        </div>

        <div class="form_field-block">
            <label class="form-field__label" for="password2"><?= $repeatPasswordL ?></label>
            <p><input type="password" class="input-field" id="password2" name="password2" ></p>
            <p><small id="password2Error" class="error"><?= @$errors['password2'] ?></small></p>
        </div>


        <br>
        <p>
            <button type="submit" class="subscribtion-form__button" id="updateUserSubmitBtn"><?= $updateUserL ?></button>
        </p>

    </form>

<?/*= var_dump($user) */?>

</section>
