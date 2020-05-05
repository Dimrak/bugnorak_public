<?php

namespace Core;

use App\Model\CategoriesModel;
use App\Model\ContactModel;
use App\Model\GenresModel;

class Controller
{
   protected $view;

   public function __construct()
   {
      $this->view = new View();
      $this->view->user = currentUser();
      $this->view->categories = CategoriesModel::getParentCategories();
      $this->view->genres = GenresModel::getGenres();
      $this->view->contacts = ContactModel::getContacts();
       //Para usar en el header en vez de currentUser() function
       //usaremos $this->user;
   }
}