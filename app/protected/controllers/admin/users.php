<?php

namespace App\Controllers;

use App\Core\AdminController;


use App\Models\User;
use Lib\TokenService;
use App\Models\CheckForm;
use function userDeleted;

class AdminUsers  extends AdminController {

    public function index()
    {
        $pages = User::countUsersPages();
        $users = User::getAllUsers($pages);
        $counter = User::getTableCounter($pages);


        return ['view' => 'views/admin/users/index.php', 'users' => $users, 'pages' =>$pages, 'counter' =>$counter];
    }


    public function create($errors = null )
    {
        $_SESSION['createUser'] = true;
        return ['view' => 'views/admin/users/create.php', 'errors' => $errors ];
    }

    public function store()
    {

        TokenService::check('admin');

        if(@!$_SESSION['createUser']) return $this->create();

        $cleanedUpInputs = self::escapeInputs('login','role', 'email', 'password');

        $errors = CheckForm::checkRegisterUserForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->create($errors);
        };

        User::store($cleanedUpInputs);

        unset($_SESSION['createUser']);

        return ['view'=>'views/admin/users/stored.php' ];
    }


    public function edit($id, $errors = null)
    {
        $_SESSION['updateUser'] = true;
        $user = User::find($id);
        return ['view' => 'views/admin/users/edit.php', 'errors' => $errors, 'id' => $id, 'user' => $user ];
    }


    public function update($id)
    {
        TokenService::check('admin');

        if(@!$_SESSION['updateUser']) return $this->edit($id);

        $cleanedUpInputs = self::escapeInputs('login','role', 'email', 'password');

        $errors = CheckForm::checkUpdateUserForm($cleanedUpInputs);

        if(!empty($errors)) {
            return $this->edit($id, $errors);
        };

        User::update($id, $cleanedUpInputs);

        unset($_SESSION['updateUser']);

        return ['view'=>'views/admin/users/updated.php' ];
    }

    public function modalWindowDelete()
    {
        return ['view'=>'views/admin/modalWindows/deleteUser.php', 'ajax'=> true ];
    }


    public function delete($id){

        TokenService::check('admin');

        User::delete($id);
        echo json_encode(['success'=>true, 'message'=> userDeleted()]); exit();
    }

}
  