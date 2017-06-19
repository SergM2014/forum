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
use function \noCategoryAndSerie;
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




    protected static function checkFieldsLength(array $fields, $length, $errors)
    {
        foreach ($fields as $key => $field){
            if($key == 'email') continue;
            if(strlen($field) < $length ) $errors->$key = $errors->$key ?? notApropriateLength();
        }
    }


    protected static function checkIfEmail($errors)
    {
        if(!filter_var(@$_POST['email'], FILTER_VALIDATE_EMAIL)) { $errors->email = $errors->email ?? wrongEmail();}

    }


    protected static function checkCaptcha($inputs, $errors)
    {
        if($_SESSION['phrase']!= $inputs['captcha']) { $errors->captcha = $errors->captcha ?? wrongCaptcha(); }
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


    public static function checkUpdateFormUser($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);
        self::checkIfEmail($errors);

        return (array)$errors;
    }

    public static function checkForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);
        self::checkIfEmail($errors);

        return (array)$errors;
    }


    public static function checkManyItemsForm($inputs)
    {
        $errors =  new \stdClass();

        self::checkIfNotEmpty($inputs, $errors);
        return (array)$errors;
    }





}