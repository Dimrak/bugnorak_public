<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019.07.18
 * Time: 12:49
 */

namespace App\Controller;

use Core\Controller;
use App\Helper\FormHelper;
use App\Model\GenresModel;

class GenreController extends Controller
{
   public function create()
   {
      if(isAdmin())
      {
         $genres = GenresModel::getGenres();
         $options = [0 => 'Choose parent genre'];
         foreach ($genres as $genre){
            $options[$genre->id] = $genre->name;
         };
         $form = new FormHelper(url('genre/store'), 'post', '');
         $form->addInput([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Genre name'
            ],'input input-simple')
            ->addTextarea([
               'name' => 'des',
               'rows' => 7,
               'cols' => 35,
            ],'textarea-simple', '', 'Description <small> optional <i class="fas fa-exclamation"></i></small>')
            ->addSubmit([
               'id' => 'Submit',
               'name' => 'submit',
               'type' => 'submit',
            ],'input submit-simple');
         $this->view->form = $form->get();
         $this->view->render('genre/create');
      }else {
         $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
         $this->html = '';
         redirect(url('account/login'));
       }
   }
   public function store()
   {
      if(isAdmin())
      {
         $data = $_POST;
         $genreObj = new GenresModel();
         $genreObj->setName($data['name']);
         $genreObj->setDes($data['des']);
         $genreObj->setSlug(strtolower($data['name']));
         $genreObj->setParentId($data['parentId']);
         $genreObj->setActive(1);
         $genreObj->save();
         $_SESSION['success'] = CREATE_SUCCESS . ' ' .$genreObj->getName();
         redirect(url('admin/index'));
      }else{
         $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
         $this->html = '';
         redirect(url('account/login'));
      }
   }
   public function edit($id)
   {
      if (isAdmin())
      {
         $genreObj = new GenresModel();
         $genreObj->load($id);
         $form = new FormHelper(url('genre/update/'). $id, 'post', '');
         $form->addInput([
            'name' => 'genre',
            'type' => 'input',
            'value' => $genreObj->getName()
         ],'input input-simple')->addTextarea([
               'name' => 'des',
               'rows' => 7,
               'cols' => 35,
            ],'textarea-simple', $genreObj->getDes(), 
            'Description <small> optional <i class="fas fa-exclamation"></i></small>')
            ->addSubmit([
            'type' => 'submit',
            'name' => 'submit',
            'value' => 'Submit'
            ],'input submit-simple');;
         $this->view->form = $form->get();
         $this->view->render('genre/edit');
      }else {
         $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
         $this->html = '';
         redirect(url('admin/index'));
      }
   }
   public function update($id)
   {
      if (isAdmin()) 
      {
         $data = $_POST;
         $genreObj = new GenresModel();
         $genreObj->setName($data['genre']);
         $genreObj->setDes($data['des']);
         $genreObj->save($id);
         $_SESSION['success'] = UPDATE_SUCCESS . ' ' . $genreObj->getName();
         redirect(url('admin/index'));
      }else{
         $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
         $this->html = '';
         redirect(url('admin/index'));
      }
   }
    public function delete()
    {
        if(isAdmin() && ucfirst($_POST['response']) == CONFIRM_YES) 
        {
            $genre_obj = new GenresModel();
            $genre_obj->delete($_POST['id']);
            $response = 'Deleted';
            echo json_encode($response);
        }elseif(isAdmin() && ucfirst($_POST['response']) == CONFIRM_NO) {
            $response = 'Cancel';
            echo json_encode($response);
        }else{
            $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
            $this->html = '';
            redirect(url('admin/index'));
        }
    }
}