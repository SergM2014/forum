<?php

namespace App\Controllers;

use App\Core\AdminController;


use App\Models\User;
use Lib\TokenService;
use App\Models\CheckForm;
use function userDeleted;

class AdminUsers  extends AdminController {



    public function __construct()
    {
        parent::__construct();

        $this->checkAdminLevel(3);
    }

    public function index()
    {
        $pages = User::countUsersPages();
        $users = User::getAllUsers($pages);
        $counter = User::getTableCounter($pages);


        return ['view' => 'views/admin/users/index.php', 'users' => $users, 'pages' =>$pages, 'counter' =>$counter];
    }


    public function create($errors = null )
    {
        $this->setReferrer('createUser');
        return ['view' => 'views/admin/users/create.php', 'errors' => $errors ];
    }

    public function store()
    {
        $this->checkReferrer('createUser');

        TokenService::check('admin');

        $cleanedUpInputs = self::escapeInputs('login','role', 'email', 'password');

        $errors = CheckForm::checkRegisterUserForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->create($errors);
        };

        User::store($cleanedUpInputs);

        return ['view'=>'views/admin/completedAction.php', 'action' => 'newUserSavedL' ];
    }


    public function edit($id, $errors = null)
    {
        $this->setReferrer('updateUser');
        $user = User::find($id);
        return ['view' => 'views/admin/users/edit.php', 'errors' => $errors, 'id' => $id, 'user' => $user ];
    }


    public function update($id)
    {
        $this->checkReferrer('updateUser');
        TokenService::check('admin');

        $cleanedUpInputs = self::escapeInputs('login','role', 'email', 'password');

        $errors = CheckForm::checkUpdateUserForm($cleanedUpInputs);

        if(!empty($errors)) {
            return $this->edit($id, $errors);
        };

        User::update($id, $cleanedUpInputs);

        return ['view'=>'views/admin/completedAction.php', 'action' => 'userUpdatedL' ];
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
  