<?php

namespace App\Controllers;

use App\Core\AdminController;


use App\Models\Index;

class Admincategories  extends AdminController {

    public function __construct()
    {
        //if(@$_SESSION['admin']['upgrading_status']!= 3) exit('Unathoriraised access!');
        parent::__construct();
    }


    public function index()
    {
        $categories = (new Index)->getCategoryTree();
        return ['view' => 'views/admin/categories/index.php', 'categories'=> $categories ];
    }

}
  