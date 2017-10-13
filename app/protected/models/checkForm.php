<?php

namespace App\Models;

use App\Core\DataBase;
use Lib\CheckFieldsService;


use function \emptyField;
use function \notEqualRepeatedPassword;
use function \notApropriateLength;
use function \wrongEmail;
use function \repeatedLogin;
use function \wrongCaptcha;
use function \repeatedEmail;
use function \repeatedTitle;

use function \noFile;


class CheckForm extends DataBase
{
    use CheckFieldsService;


    protected static function checkIfNotEmpty(array $fields, $errors, $passwordException = [] )
    {

        foreach ($fields as $key => $field ){
            if(in_array($key, $passwordException))  continue;
            if(empty($field)){

               $errors->$key = emptyField();
           }
        }
    }


    protected static function checkFieldsLength(array $fields, $length, $errors, $exception = ['imageData'])
    {

        foreach ($fields as $key => $field){
            if($key == 'email') continue;
            if(in_array($key, $exception))  continue;
            if(strlen($field) < $length ) $errors->$key = $errors->$key ?? notApropriateLength();
        }
    }


    protected static function checkIfEmail($errors)
    {
        if(!filter_var(@$_POST['email'], FILTER_VALIDATE_EMAIL)) { $errors->email = $errors->email ?? wrongEmail();}

    }


    protected static function checkCaptcha($inputs, $errors)
    {

        if(@$_SESSION['phrase']!= $inputs['captcha']) { $errors->captcha = $errors->captcha ?? wrongCaptcha(); }
    }


    protected static function ifUniqueLogin(array $income, $errors)
    {
        $sql = "SELECT `id` FROM `users` WHERE `login`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $income['login']);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        if($id)  $errors->login = $errors->login ?? repeatedLogin();
    }

    protected static function ifUniqueMemberName(array $income, $errors)
    {
        $sql = "SELECT `id` FROM `members` WHERE `name`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $income['name']);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        if($id)  $errors->name = $errors->name ?? repeatedLogin();
    }


    protected static function ifUniqueMemberEmail(array $income, $errors)
    {
        $sql = "SELECT `id` FROM `members` WHERE `email`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $income['email']);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        if($id)  $errors->email = $errors->email ?? repeatedEmail();
    }


    protected static function comparePasswordFields($field1, $field2, $errors)
    {
        if($field1 != $field2) {
            $errors->password2 = $errors->password2 ?? notEqualRepeatedPassword();
        }
    }


    protected static function checkDownloadedFile($errors)
    {
        if (@!$_SESSION['downloadFile']) {
            $errors->downloadFile = $errors->downloadFile ?? noFile();
        }

    }



    public static function checkForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);

        return (array)$errors;
    }


    public static function checkRegisterMemberForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);
        self::checkFieldsLength($_POST, 6, $errors);
        self::checkIfEmail($errors);
        self::comparePasswordFields($_POST['password'], $_POST['password2'], $errors);

       if(!DEBUG_MODE){
           self::ifUniqueMemberName($inputs, $errors);
           self::ifUniqueMemberEmail($inputs, $errors);
       }

        return (array)$errors;
    }


    public static function checkUpdateMemberForm($inputs, $passwordException = ['password', 'password2'])
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors, $passwordException);
        self::checkIfEmail($errors);

        if(!empty($_POST['password'])){
            self::checkFieldsLength($_POST, 6, $errors);
            self::comparePasswordFields($_POST['password'], $_POST['password2'], $errors);
        } else {
            self::checkFieldsLength($_POST, 6, $errors, $exception = ['imageData', 'password', 'password2']);
        }

        if(!DEBUG_MODE){
            self::ifUniqueMemberName($inputs, $errors);
            self::ifUniqueMemberEmail($inputs, $errors);
        }

        return (array)$errors;
    }

    protected static function ifUniqueCategoryTitle(array $income, $errors)
    {
        $sql = "SELECT `title` FROM `categories` WHERE `title`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $income['title']);
        $stmt->execute();
        $title = $stmt->fetchColumn();
        if($title)  $errors->title = $errors->title ?? repeatedTitle();
    }

    public static function checkCreateCategoryForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);
        self::ifUniqueCategoryTitle($inputs, $errors);

        return (array)$errors;
    }


    public static function checkUpdateCategoryForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);

        return (array)$errors;
    }


    protected static function ifUniqueTopicTitle(array $income, $errors)
    {
        $sql = "SELECT `title` FROM `topics` WHERE `title`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $income['title']);
        $stmt->execute();
        $title = $stmt->fetchColumn();
        if($title)  $errors->title = $errors->title ?? repeatedTitle();
    }


    public static function checkCreateTopicForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);
        self::ifUniqueTopicTitle($inputs, $errors);

        return (array)$errors;
    }


    public static function checkUpdateTopicForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);

        return (array)$errors;
    }

    public static function checkCreateResponseForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);

        return (array)$errors;
    }

    public static function checkMemberForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);
        self::checkFieldsLength($_POST, 6, $errors);

        return (array)$errors;
    }

    public static function checkRegisterUserForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);

        self::checkIfEmail($errors);

        self::comparePasswordFields($_POST['password'], $_POST['password2'], $errors);

        if(!DEBUG_MODE){
            self::ifUniqueMemberName($inputs, $errors);

        }

        return (array)$errors;
    }


    public static function checkUpdateUserForm($inputs, $passwordException = ['password', 'password2'])
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors, $passwordException);
        self::checkIfEmail($errors);

        if(!empty($_POST['password'])){
            self::checkFieldsLength($_POST, 4, $errors);
            self::comparePasswordFields($_POST['password'], $_POST['password2'], $errors);
        } else {
            self::checkFieldsLength($_POST, 4, $errors, $exception = [ 'password', 'password2']);
        }


        return (array)$errors;
    }








}