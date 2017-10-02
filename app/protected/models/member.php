<?php

namespace App\Models;



use App\Core\DataBase;
use Lib\HelperService;
use Lib\LangService;

class Member extends DataBase
{

    private $categories;
    private $currentLang;

    public function __construct()
    {
        $this->categories = $this->getAllCategories();
        $this->currentLang = HelperService::currentLang();

    }

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


    public static function getMember($indentifier)
    {
        $sql = "SELECT `id`, `avatar`, `name`, `password`, `email` FROM `members` WHERE `name`= :indentifier OR `id`= :indentifier";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(':indentifier', $indentifier, \PDO::PARAM_STR);
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

    public function getAllCategories()
    {
        $sql = "SELECT `id`, `parent_id`, `title`, `eng_title` FROM `categories`";
        $stmt = self::conn()->query($sql);
        $categories = $stmt->fetchAll();

        return $categories;
    }


    public function getCategoryDropDownTree($parent = 0, $prefix = '')
    {


        $print = "";
        foreach ($this->categories as $category){
            if($category->parent_id == $parent){
                $print.= "<option value='{$category->id}'>
                                {$prefix}{$category->title}
                          </option>";

                foreach($this->categories as $subCategory){
                    if($subCategory->parent_id == $category->id){
                        $flag = true;
                    }
                }

                if(isset($flag)){
                    $prefix.='-';
                    $print.= $this->getCategoryDropDownTree($category->id, $prefix);

                    $flag = null; $prefix = substr($prefix,0,-1);
                }
            }
        }

        return $print;
    }



    public static function saveCategory($inputs)
    {
        $engTitle = LangService::translite_in_Latin($inputs['title']);

        $sql = "INSERT INTO `categories` (`parent_id`, `title`, `eng_title`) VALUES (?, ?, ?) ";
        $stmt = self::conn()->prepare($sql);
        $stmt -> bindValue(1, $_POST['parentId'], \PDO::PARAM_INT);
        $stmt -> bindValue(2, $inputs['title'], \PDO::PARAM_STR);
        $stmt -> bindValue(3, $engTitle, \PDO::PARAM_STR);
        $stmt -> execute();

        return true;
    }


    public static function saveTopic($inputs)
    {

        $memberId = self::getMemberId();
        $engTitle = LangService::translite_in_Latin($inputs['title']);

        $sql = "INSERT INTO `topics` (`category_id`, `member_id`, `title`, `eng_title`) VALUES (?, ?, ?, ?) ";
        $stmt = self::conn()->prepare($sql);
        $stmt -> bindValue(1, $_POST['categoryId'], \PDO::PARAM_INT);
        $stmt -> bindValue(2, $memberId, \PDO::PARAM_INT);
        $stmt -> bindValue(3, $inputs['title'], \PDO::PARAM_STR);
        $stmt -> bindValue(4, $engTitle, \PDO::PARAM_STR);
        $stmt -> execute();

        return true;
    }


    public static function getAllMembers()
    {
        $sql = "SELECT `id`, `user_id`, `avatar`, `name`, `email`, `added_at` FROM `members`";
        $stmt = self::conn()->query($sql);
        $members = $stmt->fetchAll();

        return $members;
    }

    public static function countMemberPages()
    {
         $sql = "SELECT COUNT(`id`) FROM `members`";
        $stmt = self::conn()->query($sql);
        $stmt->bindColumn(1, $count);
        $stmt->fetch();

        $pages = ceil($count/AMOUNTONPAGEADMIN);
        return $pages;

    }


    public static function adminUpdate($id,$inputs)
    {
        if($inputs['password']!=''){

            $password = password_hash($inputs['password'], PASSWORD_DEFAULT );

            $sql = "UPDATE `members` SET  `password` = ? WHERE `id`= ?";
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(1, $password, \PDO::PARAM_STR);
            $stmt->bindValue(2, $id, \PDO::PARAM_INT);
            $stmt->execute();
        }

        $avatar = !empty($_POST['imageData']) ? $_POST['imageData']: null;
        $sql = "UPDATE `members` SET `avatar` = ?,  `name` = ?,  `email` = ? WHERE `id`= ?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $avatar, \PDO::PARAM_STR);
        $stmt->bindValue(2, $inputs['name'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $inputs['email'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $id, \PDO::PARAM_INT);
        $stmt->execute();
    }


    public static function deleteMember($id)
    {
        $sql = "DELETE FROM `members` WHERE `id`= ?";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
    }





}