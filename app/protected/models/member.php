<?php

namespace App\Models;



use App\Core\DataBase;


class Member extends DataBase
{

    public static function persistMember($inputs)
    {
        $avatar = ($_POST['imageData']!='')? $_POST['imageData']: null;

        $password = password_hash( $inputs['password'], PASSWORD_DEFAULT );
        $token = md5(uniqid(rand(), true));

        $sql = "INSERT INTO `members` (`avatar`, `name`, `password`, `email`, `token`) VALUES (?, ?, ?, ?, ?)";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $avatar, \PDO::PARAM_STR);
        $stmt->bindValue(2, $inputs['name'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $password, \PDO::PARAM_STR);
        $stmt->bindValue(4, $inputs['email'], \PDO::PARAM_STR);
        $stmt->bindValue(5, $token, \PDO::PARAM_STR);
        $stmt->execute();

        $_SESSION['member'] = $inputs['name'];

    }


    public static function login()
    {
        if (@!$_POST['name'] OR @!$_POST['password']) return;
        $sql = "SELECT `name` , `password`,  `token` FROM `members` WHERE `name`= ? ";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['name'], \PDO::PARAM_STR);
        $stmt->execute();
        $member = $stmt->fetch();

        if (password_verify($_POST['password'], @$member->password)) {
            $_SESSION['member'] = $member->name;

          return true;
        }

        return false;
    }





}