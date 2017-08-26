<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Category;
use Lib\TokenService;
use App\Models\CheckForm;

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

    public function create($errors = null)
    {
       $categoryDropDownList = (new Category)->getCategoryDropDownTree();
        $_SESSION['createCategory'] = true;
       return ['view' => 'views/admin/categories/create.php', 'categoryDropDownList' => $categoryDropDownList, 'errors' => $errors];

    }

    public function store()
    {
       // $this->checkIfMember();
        TokenService::check('admin');

        if(@!$_SESSION['createCategory']) return $this->create();

        $cleanedUpInputs = self::escapeInputs('title');
        $errors = CheckForm::checkCreateCategoryForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->create($errors);
        };

        Category::saveCategory($cleanedUpInputs);

        unset($_SESSION['createCategory']);

        return ['view'=>'views/admin/categories/storedCategory.php' ];
    }

}
  