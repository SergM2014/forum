<?php

namespace App\Models;

use App\Core\DataBase;
use Gregwar\Captcha\CaptchaBuilder;




 class Index extends DataBase
 {
     public function __construct()
     {
         $this->categories = $this->getGeneralInfo();
     }

     private $categories;

     private function getGeneralInfo()
     {
         $sql = "CREATE TEMPORARY TABLE `r2` SELECT `id`, `topic_id`, `member_id`, `response`,`created_at`, `updated_at` FROM `responses`  ORDER BY `created_at` DESC ";
         self::conn()->query($sql);

         $sql= "SELECT `c`.`id`, `c`.`parent_id`, `c`.`title`, COUNT(`t`.`id`) AS `topic_amount`, COUNT(`r2`.`id`)
         AS `response_amount`, `r2`.`response`, `r2`.`created_at` AS `added`, `m`.`name` FROM `categories` `c` LEFT JOIN `topics` `t` ON `c`.`id`= `t`.`category_id` LEFT JOIN
          `r2` ON `t`.`id`= `r2`.`topic_id` LEFT JOIN `members` `m` ON `r2`.`member_id`=`m`.`id` GROUP BY `c`.`id`";


         $stmt = self::conn()->query($sql);

         $result = $stmt->fetchAll();

         return $result;
     }

     public function getCategoryTableTree($parent = 0)
     {
         $print = "";
         foreach ($this->categories as $category){
             if($category->parent_id == $parent){
                 $print.= "<tr><td>{$category->title}</td> <td>{$category->topic_amount}</td> <td>{$category->response_amount}</td> <td>{$category->response}</td> <td>{$category->added}</td> <td>{$category->name}</td></tr>";

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

     public static function updateUser($inputs)
     {
         var_dump($inputs);
     }

 }
