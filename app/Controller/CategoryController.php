<?php


namespace App\Controller;
use App\Model\CategoriesModel;
use App\Model\ContactModel;
use Core\Controller;
use App\Helper\FormHelper;

class CategoryController extends Controller
{
   public function show($slug)
   {
      if(isAdmin())
      {    
         $category = new CategoriesModel();
         $category->loadBySlug($slug);
         $contacts = [];
         foreach ($category->getContacts() as $contact){
            $contactObj = new ContactModel();
            $contacts[] = $contactObj->load($contact->contact_id);
         }
         $this->view->categoryName = $category->getName();
         $this->view->category = $category;
         $this->view->contact = $contacts;
         $this->view->render('categories/show');
      }else{
         $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
         $this->html = '';
         redirect(url('account/login'));
      }
   }
   public function create()
   {
      if(isAdmin())
      {
         $form = new FormHelper(url('category/store'), 'post', '');
         $form->addInput([
            'id' => 'Category',
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Media name',
            'required' => 'true',
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
         $this->view->render('category/create');
      }else{
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
         $categObj = new CategoriesModel();
         $categObj->setName($data['name']);
         $categObj->setDes($data['des']);
         $categObj->setParentId(0);
         $categObj->setSlug($data['name']);
         $categObj->setActive(1);
         $categObj->save();
         $_SESSION['success'] = CREATE_SUCCESS . ' ' .$categObj->getName();
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
         $cateObj = new CategoriesModel();
         $cateObj->load($id);
         
         $form = new FormHelper(url('category/update/') . $id, 'post', '');
         $form->addInput([
            'name' => 'media',
            'type' => 'input',
            'value' => $cateObj->getName(),
            'placeholder' => 'something',
         ], 'input input-simple')->addTextarea([
            'name' => 'des',
            'rows' => 7,
            'cols' => 35,
         ],'textarea-simple', $cateObj->getDes(), 
         'Description <small> optional <i class="fas fa-exclamation"></i></small>')
         ->addSubmit([
            'type' => 'submit',
            'name' => 'submit',
            'value' => 'Submit'
         ], 'input submit-simple');
         $this->view->form = $form->get();
         $this->view->render('category/edit');
      } else {
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
         $cateObj = new CategoriesModel();
         $cateObj->setName($data['media']);
         $cateObj->setDes($data['des']);
         $cateObj->save($id);
         $_SESSION['success'] = UPDATE_SUCCESS . ' ' . $cateObj->getName();
         redirect(url('admin/index'));
      }else {
         $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
         $this->html = '';
         redirect(url('admin/index'));
      }
   }
   public function delete($id)
   {
      if (isAdmin() && ucfirst($_POST['response']) == CONFIRM_YES) 
      {
         $catObj = new CategoriesModel();
         $catObj->delete($id);
         $response = 'Deleted';
         echo json_encode($response);
      }elseif(isAdmin() && ucfirst($_POST['response']) == CONFIRM_NO)
      {
         $response = 'Cancel';
         echo json_encode($response);
      }else{
         $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
         $this->html = '';
         redirect(url('admin/index'));
      }
   }
}