<?php

namespace App\Controllers;



use App\Core\BaseController;




class Popup  extends BaseController
{

    public function categories()
    {

        return ['view' => 'views/admin/popUpMenu/categories.php', 'ajax' => true ];
    }


    public function topics()
    {

        return ['view' => 'views/admin/popUpMenu/topics.php', 'ajax' => true ];
    }




}