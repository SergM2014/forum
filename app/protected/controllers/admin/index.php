<?php

namespace App\Controllers;



use App\Core\BaseController;

use App\Models\AdminModel;
use Lib\TokenService;



class Admin  extends BaseController
  {

    public function index()
	{

      if(!isset($_SESSION['admin'])) $noTemplate = true;

      return ['view'=>'views/admin/index.php', 'noTemplate'=> @$noTemplate];
    }


    public function login()
    {
        TokenService::check('admin');
        AdminModel::getAdminUser();


        if(!isset($_SESSION['admin'])){
            return $this->index();
        }


        return ['view'=>'views/admin/index.php'];
    }


    public function logout()
    {
        TokenService::check('admin');
        unset($_SESSION['admin']);

        return ['view'=>'views/admin/index.php','noTemplate'=>true];
    }













  }
  