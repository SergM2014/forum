<?php

namespace App\Controllers;



use App\Core\BaseController;

use Lib\HelperService;
use Lib\CheckFieldsService;
use App\Models\ManyItems;
use App\Models\CheckForm;



class Many  extends BaseController
  {

    use CheckFieldsService;
      /**
       * fire off he index action
       *
       * @return array
       */


    public function edit($errors = null )
    {
        $result = ManyItems::getOneItem();

        $this->setReferrer('edit');

        return ['view'=>'views/common/many/edit.php', 'result'=>$result, 'errors'=> $errors];
    }

    public function update()
    {
        $this->checkReferrer('edit');

        $cleanedUpInputs = self::escapeInputs('title', 'describtion');
        $errors = CheckForm::checkManyItemsForm($cleanedUpInputs);

        if(!empty($errors)) return $this->edit($errors);
        ManyItems::updateItem($cleanedUpInputs);
        exit('this is update controller having work further');
    }



  }
  