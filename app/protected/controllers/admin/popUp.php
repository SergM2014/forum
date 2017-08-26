<?php

namespace App\Controllers;



use App\Core\BaseController;




class Popup  extends BaseController
{

    public function categories()
    {

        return ['view' => 'views/admin/popUpMenu/categories.php', 'ajax' => true ];
    }

    public function lesson()
    {
        return ['view' => 'views/admin/popUp/showMenu.php', 'ajax' => true ];
    }



    public function drawDeleteLessonModal()
    {
        return ['view'=> '/views/admin/modalWindow/deleteLesson.php', 'ajax'=> true ];
    }

}