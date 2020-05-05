<?php namespace App\Controller;
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019.09.01
 * Time: 21:40
 */

use App\Model\CategoriesModel;
use App\Model\HistoryModel;
use App\Model\GenresModel;
use Core\Controller;

class AdminController extends Controller
{
   public function index()
   {
      if(isAdmin())
      {
         $categories = CategoriesModel::getCategories();
         $histories = HistoryModel::getHistories();
         $genreObj = new GenresModel();
         $this->view->categories = $categories;
         $this->view->histories = $histories;
         $this->view->genres = $genreObj->getGenres();
         $this->view->render('contact/admin/admin-panel');
      }else{
         $this->view->render('errorPage');
      }
   }
}