<?php

namespace App\Models;


use App\Core\DataBase;




 class Search extends DataBase
 {
    public static function find()
    {
      $sql = "SELECT `id`, `parent_id`, `topic_id`, `response` FROM `responses` WHERE MATCH (`response`) AGAINST (:search IN BOOLEAN MODE) LIMIT 0,5";
      $stmt = self::conn()->prepare($sql);
      $stmt->bindValue( ':search',  $_POST['searchValue'].'*', \PDO::PARAM_INT);
      $stmt->execute();
      $results = $stmt->fetchAll();
      return $results;
    }

 }
