<?php

namespace App\Controllers;



use App\Core\BaseController;
use App\Models\Search as SearchModel;



class Search  extends BaseController
  {

    public function drawResultsBlock()
	{
        return ['view'=>'views/common/partials/searchBlock.php', 'ajax'=>true ];
    }

    public function find()
    {
       $results = SearchModel::find();

        return ['view'=>'views/common/partials/searchResults.php', 'ajax'=>true, 'results'=>$results];
    }



  }
  