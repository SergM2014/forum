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

use function \noFile;


class CheckForm extends DataBase
{
    use CheckFieldsService;


    protected static function checkIfNotEmpty(array $fields, $errors)
    {
        foreach ($fields as $key => $field ){
           if(empty($field)){
               $errors->$key = emptyField();
           }
        }
    }


    protected static function checkFieldsLength(array $fields, $length, $errors, $exception = 'imageData')
    {

        foreach ($fields as $key => $field){
            if($key == 'email' OR $key == $exception) continue;
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








}