<?php

namespace App\Models;



use App\Core\DataBase;
use Lib\HelperService;
use Lib\LangService;

class Category extends DataBase
{

    private $categories;
    private $currentLang;

    public function __construct()
    {
        $this->categories = $this->getAllCategories();
        $this->currentLang = HelperService::currentLang();

    }



    public function getAllCategories()
    {
        $sql = "SELECT `id`, `parent_id`, `title`, `eng_title` FROM `categories`";
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



    public static function saveCategory($inputs)
    {
        $engTitle = LangService::translite_in_Latin($inputs['title']);

        $sql = "INSERT INTO `categories` (`parent_id`, `title`, `eng_title`) VALUES (?, ?, ?) ";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['parentId'], \PDO::PARAM_INT);
        $stmt->bindValue(2, $inputs['title'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $engTitle, \PDO::PARAM_STR);
        $stmt->execute();

        return true;
    }

    public static function updateCategory($id, $inputs)
    {
        $engTitle = LangService::translite_in_Latin($inputs['title']);

        $sql = "UPDATE `categories` SET `parent_id`=?, `title`=?, `eng_title`=? WHERE `id`=? ";
        $stmt = self::conn()->prepare($sql);
        $stmt->bindValue(1, $_POST['parentId'], \PDO::PARAM_INT);
        $stmt->bindValue(2, $inputs['title'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $engTitle, \PDO::PARAM_STR);
        $stmt->bindValue(4, $id, \PDO::PARAM_INT);
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


    public static function getOneCategory($id)
    {
        $sql = "SELECT `id`, `parent_id`, `title`, `eng_title` FROM `categories` WHERE `id`=?";
        $stmt = self::conn()->prepare($sql);
        $stmt -> bindValue(1, $id, \PDO::PARAM_INT);
        $stmt-> execute();
        $category = $stmt ->fetch();
        return $category;

    }




}