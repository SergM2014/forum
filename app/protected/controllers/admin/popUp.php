<?php

namespace App\Controllers;



use App\Core\BaseController;




class PopUp  extends BaseController
{

    public function lesson()
    {
        return ['view' => 'views/admin/popUp/showMenu.php', 'ajax' => true ];
    }



    public function drawDeleteLessonModal()
    {
        return ['view'=> '/views/admin/modalWindow/deleteLesson.php', 'ajax'=> true ];
    }

}