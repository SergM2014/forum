<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Category;
use Lib\TokenService;
use App\Models\CheckForm;

use App\Models\Index;

use function categoryHasChildren;
use function categoryDeleted;

class AdminCategories  extends AdminController {

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

        $this->setReferrer('createCategory');

       return ['view' => 'views/admin/categories/create.php', 'categoryDropDownList' => $categoryDropDownList, 'errors' => $errors];

    }

    public function store()
    {
        $this->checkReferrer('createCategory');
        TokenService::check('admin');

        $cleanedUpInputs = self::escapeInputs('title');
        $errors = CheckForm::checkCreateCategoryForm($cleanedUpInputs);
//if errors
        if(!empty($errors)) {
            return $this->create($errors);
        };

        Category::saveCategory($cleanedUpInputs);

        return ['view'=>'views/admin/completedAction.php', 'action' => 'categoryCreatedL' ];
    }


    public function edit($id,$errors = null)
    {
        $category = Category::getOneCategory($id);

        $categoryDropDownList = (new Category)->getCategoryDropDownTree($category->parent_id);

        $this->setReferrer('updateCategory');

        return ['view' => 'views/admin/categories/edit.php', 'categoryDropDownList' => $categoryDropDownList,
            'categoryId' => $id, 'title' => $category->title, 'errors' => $errors];

    }

    public function update($id)
    {
        $this->checkReferrer('updateCategory');
        TokenService::check('admin');

        $cleanedUpInputs = self::escapeInputs('title');
        $errors = CheckForm::checkUpdateCategoryForm($cleanedUpInputs);

//if errors
        if(!empty($errors)) {
            return $this->edit($id, $errors);
        };

        Category::updateCategory($id,$cleanedUpInputs);

        return ['view'=>'views/admin/completedAction.php', 'action' => 'categoryUpdatedL' ];
    }

    public function modalWindowDelete()
    {
        return ['view'=>'views/admin/modalWindows/deleteCategory.php', 'ajax'=> true ];
    }


    public function delete(){

        TokenService::check('admin');
//chek if category has child categories
       if( Category::hasChildren($_POST['categoryId'])){
           echo json_encode(['hasChildren' => true, 'message' => categoryHasChildren() ]); exit();
       }
        Category::delete($_POST['categoryId']);
        echo json_encode(['success'=>true, 'message'=> categoryDeleted()]); exit();
    }

}
  