<?php

namespace App\Controllers;

use App\Core\AdminController;


use App\Models\User;
use Lib\TokenService;
use App\Models\CheckForm;

class AdminUsers  extends AdminController {

    public function index()
    {
        $pages = User::countUsersPages();
        $users = User::getAllUsers($pages);
        $counter = User::getTableCounter($pages);


        return ['view' => 'views/admin/users/index.php', 'users' => $users, 'pages' =>$pages, 'counter' =>$counter];
    }








}
  