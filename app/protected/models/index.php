<?php

namespace App\Models;

use App\Core\DataBase;
use Gregwar\Captcha\CaptchaBuilder;
use Lib\HelperService;

use function added;
use function author;




 class Index extends DataBase
 {
     private $categories;

     private $currentLang;

     public function __construct()
     {
         $this->categories = $this->getGeneralInfo();
         $this->currentLang = HelperService::currentLang();

     }



     private function getGeneralInfo()
     {
         $sql = "CREATE TEMPORARY TABLE `r2` SELECT `id`, `topic_id`, `member_id`, `response`,`created_at`, `updated_at`
                  FROM `responses`  ORDER BY `created_at` DESC ";
         self::conn()->query($sql);

         $sql= "SELECT `c`.`id`, `c`.`parent_id`, `c`.`title`, `c`.`eng_title`, COUNT(DISTINCT`t`.`id`) AS
                `topic_amount`, COUNT(`r2`.`id`) AS `response_amount`, `r2`.`id` AS `response_id`, `r2`.`response`,
                 `r2`.`created_at` AS `added`, `m`.`name` FROM `categories` `c` LEFT JOIN `topics` `t` 
                 ON `c`.`id`= `t`.`category_id` LEFT JOIN `r2` ON `t`.`id`= `r2`.`topic_id`
                  LEFT JOIN `members` `m` ON `r2`.`member_id`=`m`.`id` GROUP BY `c`.`id` ";


         $stmt = self::conn()->query($sql);

         $result = $stmt->fetchAll();

         return $result;
     }

     public function getCategoryTableTree($parent = 0)
     {
         $print = "";
         foreach ($this->categories as $category){
             if($category->parent_id == $parent){
                 $print.= "<tr>
                                <td><a href='{$this->currentLang}/category/{$category->eng_title}'>{$category->title}</a></td>
                                 <td>{$category->topic_amount}</td> 
                                 <td>{$category->response_amount}</td> 
                                 <td>";
                 if(@$category->response_id){
                     $print.= "
                                <a href='{$this->currentLang}/response/{$category->response_id}#show'>{$category->response}</a>
                                      <p>".added().": {$category->added}</p> 
                                      <p>".author().": {$category->name}</p>
                     ";
                 }

                 $print.= "                 </td>
                                  </tr>";

                 foreach($this->categories as $subCategory){
                     if($subCategory->parent_id == $category->id){
                         $flag = true;
                     }
                 }

                 if(isset($flag)){

                     $print.= $this->getCategoryTableTree($category->id);


                     $flag = null;
                 }
             }
         }

         return $print;
     }


     public function getOneCategoryGeneralInfo($title)
     {
         $sql = "CREATE TEMPORARY TABLE IF NOT EXISTS `r2`  SELECT `id`, `topic_id`, `member_id`, `response`,`created_at`, `updated_at`
                  FROM `responses`  ORDER BY `created_at` DESC ";
         self::conn()->query($sql);

         $sql= "SELECT `c`.`id` AS `category_id`,`t`.`id`,  `t`.`title`, `t`.`eng_title`, COUNT(DISTINCT `r2`.`id`)
                 AS `response_amount`, `r2`.`id` AS `response_id`, `r2`.`response`, `r2`.`created_at` AS `added`, `m`.`name` FROM `categories` `c`
                  LEFT JOIN `topics` `t` ON `c`.`id`= `t`.`category_id` LEFT JOIN `r2` ON `t`.`id`= `r2`.`topic_id`
                  LEFT JOIN `members` `m` ON `r2`.`member_id`=`m`.`id` WHERE `c`.`title` = ?  GROUP BY `t`.`id` ORDER BY `r2`.`created_at` DESC";


         $stmt = self::conn()->prepare($sql);
         $stmt->bindValue(1, $title, \PDO::PARAM_STR);
         $stmt->execute();

         $result = $stmt->fetchAll();

         return $result;
     }







     public static function printCaptcha()
     {
         $builder = new CaptchaBuilder;
         $builder->build();
         $_SESSION['phrase'] = $builder->getPhrase();
         return $builder;
     }

     public static function getUser()
     {
         $sql = "SELECT `id`, `avatar`, `login`, `email` FROM `subscribers` WHERE `id`=1";
         $stmt = self::conn()->query($sql);

         $user = $stmt->fetch();

         return $user;
     }


     public static function getCategoryIdFromTitle($title)
     {
         $sql = "SELECT `id` FROM `categories` WHERE `title`=?";
         $stmt = self::conn()->prepare($sql);
         $stmt -> bindValue(1, $title, \PDO::PARAM_STR);
         $stmt -> execute();
         $stmt -> bindColumn(1, $id);
         $stmt ->fetch();

         return $id;
     }


     public static function updateUser($inputs)
     {
         var_dump($inputs);
     }

 }
