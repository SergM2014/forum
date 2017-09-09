<?php

namespace App\Models;



use App\Core\DataBase;
use Lib\HelperService;
use Lib\LangService;

class Topic extends DataBase
{

   // private $categories;
    private $currentLang;

    public function __construct()
    {
      //  $this->categories = $this->getAllCategories();
        $this->currentLang = HelperService::currentLang();

    }



    public static function getAllTopics()
    {
        $sql = "SELECT `id`, `category_id`, `member_id`, `title`, `eng_title` FROM `topics`";
        $stmt = self::conn()->query($sql);
        $categories = $stmt->fetchAll();

        return $categories;
    }


    public function getCategoryDropDownTree($selected = null, $parent = 0, $prefix = '')
    {
        $print = "";
        foreach ($this->categories as $category){
            if($category->parent_id == $parent){
                $print.= "<option value='{$category->id}'";

                $selectedOption = ($selected === $category->id)? 'selected': '';
//dd($selectedOption);
                $print.= " $selectedOption >
                                {$prefix}{$category->title}
                          </option>";

                foreach($this->categories as $subCategory){
                    if($subCategory->parent_id == $category->id){
                        $flag = true;
                    }
                }

                if(isset($flag)){
                    $prefix.='-';
                    $print.= $this->getCategoryDropDownTree( $selected, $category->id, $prefix);

                    $flag = null; $prefix = substr($prefix,0,-1);
                }
            }
        }

        return $print;
    }



    public static function store($inputs)
    {

        $engTitle = LangService::translite_in_Latin($inputs['title']);
        $categoryId = $_POST['parentId'];

        $sql = "INSERT INTO `topics` (`category_id`, `member_id`, `title`, `eng_title`) VALUES (?, ?, ?, ?) ";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $categoryId, \PDO::PARAM_INT);
        $stmt->bindValue(2, $_POST['memberId'], \PDO::PARAM_INT);
        $stmt->bindValue(3, $inputs['title'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $engTitle, \PDO::PARAM_STR);
        $stmt->execute();

        return true;
    }


    public static function getOneTopic($id)
    {
        $sql = "SELECT `id`, `category_id`, `member_id`, `title`, `eng_title` FROM `topics` WHERE `id`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt -> bindValue(1, $id, \PDO::PARAM_INT);
        $stmt-> execute();
        $topic = $stmt ->fetch();
        return $topic;

    }



    public static function update($id, $inputs)
    {
        $engTitle = LangService::translite_in_Latin($inputs['title']);

        $sql = "UPDATE `topics` SET `category_id`=?, `member_id`=?, `title`=?, `eng_title`=? WHERE `id`=? ";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['categoryId'], \PDO::PARAM_INT);
        $stmt->bindValue(2, $_POST['memberId'], \PDO::PARAM_INT);
        $stmt->bindValue(3, $inputs['title'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $engTitle, \PDO::PARAM_STR);
        $stmt->bindValue(5, $id, \PDO::PARAM_INT);
        $stmt->execute();

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




    public static function delete($id)
    {
        $sql = "DELETE FROM `topics` WHERE `id`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt -> bindValue(1, $id, \PDO::PARAM_INT);
        $stmt -> execute();

        return;
    }

    public static function hasChildren($id)
    {
        $sql = "SELECT COUNT(DISTINCT `id`) FROM `categories` WHERE `parent_id` = ?";
        $stmt = self::conn()->prepare($sql);
        $stmt-> bindValue(1, $id, \PDO::PARAM_INT);
        $stmt-> execute();
        $stmt->bindColumn(1, $count);
        $stmt-> fetch();
        return !!$count;

    }




}