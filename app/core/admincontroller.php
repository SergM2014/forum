<?php

namespace App\Core;




use Lib\CheckFieldsService;
/**
 *
 * the class protect against unauthorirized access to the admin part
 * Class AdminController
 * @package App\Core
 */
class AdminController  extends BaseController{


    use CheckFieldsService;
    /**
     *
     * realisation of protection against the unauthorized access
     * AdminController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        if(!isset($_SESSION['admin']['login'])){
            if (isset($_POST['ajax'])){
                echo json_encode(["message" => "you do not have permission to fire off the controller"]); exit();
            }
            header('Location: /admin');
        }

    }

    public function checkAdminLevel($level)
    {
        if(@$_SESSION['admin']['role'] < $level){ header('Location: /admin');}
    }



}