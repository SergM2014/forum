<?php

namespace App\Models;



use App\Core\DataBase;


class Member extends DataBase
{

    public static function persistMember($inputs)
    {
        $avatar = !empty($_POST['imageData'])? $_POST['imageData']: null;

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


    public static function getMember($name)
    {
        $sql = "SELECT `id`, `avatar`, `name`, `password`, `email` FROM `members` WHERE `name`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $name, \PDO::PARAM_STR);
        $stmt->execute();
        $member = $stmt->fetch();

        return $member;
    }

    public static function update($inputs)
    {

        if($inputs['password']!=''){

            $password = password_hash($inputs['password'], PASSWORD_DEFAULT );

            $sql = "UPDATE `members` SET  `password` = ? WHERE `name`= ?";
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(1, $password, \PDO::PARAM_STR);
            $stmt->bindValue(2, $_POST['memberName'], \PDO::PARAM_STR);
            $stmt->execute();
        }

        $avatar = !empty($_POST['imageData']) ? $_POST['imageData']: null;
        $sql = "UPDATE `members` SET `avatar` = ?,  `name` = ?,  `email` = ? WHERE `name`= ?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $avatar, \PDO::PARAM_STR);
        $stmt->bindValue(2, $inputs['name'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $inputs['email'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $_POST['memberName'], \PDO::PARAM_STR);
        $stmt->execute();
    }

    public static function getMemberId()
    {
        $sql = "SELECT `id` FROM `members` WHERE `name` = ?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_SESSION['member'], \PDO::PARAM_STR);
        $stmt->execute();
        $stmt->bindColumn(1, $id);
        $stmt->fetch();
        return $id;
    }





}