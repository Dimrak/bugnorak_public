<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019.07.04
 * Time: 10:27
 */
namespace App\Controller;
use Core\Controller;

class ErrorController extends Controller
{
   public function errorPage()
   {
      $this->view->render('errorPage');
   }
   public function errorMethod()
   {
      $this->view->render('errorMethod');
   }

}