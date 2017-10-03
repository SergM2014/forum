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


    public function responses()
    {

        return ['view' => 'views/admin/popUpMenu/responses.php', 'ajax' => true ];
    }

    public function members()
    {

        return ['view' => 'views/admin/popUpMenu/members.php', 'ajax' => true ];
    }

    public function users()
    {

        return ['view' => 'views/admin/popUpMenu/users.php', 'ajax' => true ];
    }





}