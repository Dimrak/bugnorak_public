<?php
namespace App\Controller;
use Core\Controller;

use App\Model\ContactModel;

class HomeController extends Controller
{
    public function index(){
        redirect('search');
    }
}

