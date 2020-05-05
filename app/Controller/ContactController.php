<?php
/**
* Created by PhpStorm.
* User: pc
* Date: 2019.07.04
* Time: 10:27
*/
namespace App\Controller;

use App\Model\GenresModel;
use Core\Controller;
use App\Helper\FormHelper;
use App\Model\CategoriesModel;
use App\Model\ContactModel;
use App\Model\DetailModel as Detail;

class ContactController extends Controller
{
   private $html;
   public function index()
   {
      if (currentUser()) {
         
         $contactObj = new ContactModel();
         $countries = $contactObj->getCountries();
         $countries = array_unique($countries, SORT_REGULAR);
         $this->view->countries = $countries;
         
         $contactObj = new ContactModel();
         $contacts = $contactObj->getContacts();
         $this->view->contacts = $contacts;
         
         $genreObj = new GenresModel();
         $this->view->genres = $genreObj->getGenres();
         
         $categories = CategoriesModel::getCategories();
         $this->view->categories = $categories;
         $options = [];
         foreach ($categories as $category) {
            $options[$category->id] = $category->name;
         }
         $this->view->render('contact/contacts');
      }else {
         $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
         $this->html = '';
         redirect(url('account/login'));
      }
   }
   public function show($id)
   {
      if(isAdmin()){
         $contact_obj = new ContactModel;
         $contact = $contact_obj::getContact($id);
         $genre = $contact_obj->get_genre($contact->genre);
         $media = $contact_obj->get_media($contact->media);
         if (empty($genre)) {
            $contact->genre = '';
         }else{
            $contact->genre = $genre->name;
         } 
         if (empty($media)) {
            $contact->media = '';
         }else{
            $contact->media = $media->name;
         }
         $this->view->contact = $contact;
         $this->view->render('contact/show');
         //To load the the media name
      }elseif(isAdmin() == false){
         $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
         $this->html = '';
         redirect(url('account/login'));
      }
   }
   public function create()
   {
      if (currentUser()) {
         $categories = CategoriesModel::getCategories();
         $medias = [0 => 'Choose a media'];
         foreach($categories as $category){
            $medias[$category->id] = $category->name;
         };
         $genresCat = GenresModel::getGenres();
         $genres = [0 => 'Which genre?'];
         foreach ($genresCat as $genre){
            $genres[$genre->id] = $genre->name;
         }
         $form = new FormHelper(url('contact/store'), 'post', '');
         $form->addInput([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Enter contact name'
         ],'input input-complex')
         ->addInput([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'Enter the contact email'
         ],'input input-complex')
         ->addSelect($medias,'media','none','input select-complex')
         ->addSelect($genres, 'genre', 'none', 'input select-complex')
         ->addInput([
            'id' => 'MediaName',
            'name' => 'mediaName',
            'type' => 'text',
            'placeholder' => 'Enter media name'
         ], 'input input-complex')
         ->add_contries_select('input select-complex')
         ->addInput([
            'id' => 'website',
            'type' => 'text',
            'name' => 'website',
            'placeholder' => 'website'
         ],'input input-complex')
         ->addTextarea([
            'id' => 'textarea-address',
            'name' => 'address',
            'rows' => 4,
            'cols' => 50,
            'placeholder' => 'Physical address',
            'wrap' => 'soft',
         ],'textarea-complex', '', 'Address')         
         ->addInput([
            'type' => 'checkbox',
            'value' => 1,
            'name' => 'response',
         ],'input', 'Response','checkbox-div') 
         ->addInput([
            'type' => 'checkbox',
            'value' => 1,
            'name' => 'physical',
         ],'input ', 'Only physical?','checkbox-div')
         ->addInput([
            'type' => 'checkbox',
            'value' => 1,
            'name' => 'meet',
         ],'input', 'Meet?', 'checkbox-div')
         ->addTextarea([
            'id' => 'textarea',
            'name' => 'notes',
            'rows' => 7,
            'cols' => 60,
            'placeholder' => 'Give us your thoughts',
         ],'textarea-complex', '', 'Notes')
         ->addSubmit([
            'type' => 'submit',
            'name' => 'submit'
         ],'input');
         $this->view->form = $form->get();
         $this->view->render('contact/admin/create');
      }else {
         $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
         $this->html = '';
         redirect(url('account/login'));
      }
   }
   public function store_physical($id)
   {
      $response = [];
      if(isAdmin()) {
         $contactUpdate = new ContactModel();
         $contactDetails = $contactUpdate->load($id);
         
         if (!empty($_POST['physical'])) {
            if ($contactDetails->getPhysical() == 1) {
               $response['exists'] = 'No changes';
               echo json_encode($response);
               die();
            }
            $response['yes'] = '1';
            $contactDetails->setPhysical(1);
            $contactDetails->update_physical($id);
            echo json_encode($response);
         }elseif(empty($_POST['physical'])){
            if ($contactDetails->getPhysical() == 0) {
               $response['exists'] = 'No changes';
               echo json_encode($response);
               die();
            }
            $contactDetails->setPhysical(0);
            $contactDetails->update_physical($id);
            $response['no'] = '0';
            echo json_encode($response);
         } 
      }else{
         $_SESSION['message'] = '<h1>Access denied for editing</h1>';
         return json_encode($response);
         $this->html = 'Access denied';
      }
   }
   public function store()
   {
      $data = $_POST;
      if (empty($data['meet'])){
         $data['meet'] = 0;
      }else{
         $data['meet'] = 1;
      }
      if (empty($data['response'])){
         $data['response'] = 0;
      }else{
         $data['response'] = 1;
      }
      $meet = $data['meet'];
      $response = $data['response'];
      //Validation
      $contactObj = new ContactModel();
      $contactObj->setMedia($data['media']);
      $contactObj->setmediaName(ucfirst($data['mediaName']));
      $contactObj->setGenre($data['genre']);
      $contactObj->setName($data['name']);
      $contactObj->setEmail($data['email']);
      $contactObj->setCountry(ucfirst($data['country']));
      $contactObj->setAddress($data['address']);
      $contactObj->setResponse($response);
      $contactObj->setMeet($meet);
      $contactObj->setNotes($data['notes']);
      $contactObj->setWebsite($data['website']);
      $contactObj->setActive(1);
      $contactObj->setPhysical(1);
      $contactObj->save();
      redirect(url('search'));
      
   }
   public function edit($id)
   {
      if (isAdmin()) {
         
         $contactObj = new ContactModel();
         $contactObj->load($id);
         $this->view->contact = $contactObj;
         $categories = CategoriesModel::getCategories();
         //This part need to change maybe a individual function
         foreach($categories as $category){
            $medias = [$contactObj->getMedia() => $category->name];
         };
         foreach($categories as $category){
            //            $medias = [$contactObj->getMedia() => $category->name];
            $medias[$category->id] = $category->name;
         };
         
         $genresObj = GenresModel::getGenres();
         //         $genres = [0 => $contactObj->getMedia()];
         foreach($genresObj as $genre){
            $genres = [$contactObj->getGenre() => $genre->name];
         };
         foreach ($genresObj as $genre){
            $genres[$genre->id] = $genre->name;
         }
         
         $form = new FormHelper(url('contact/update/' . $id), 'post', '');
         $form->addInput([
            'name' => 'name',
            'type' => 'text',
            'value' => ucfirst($contactObj->getName()),
         ],'input input-complex')
         ->addInput([
            'name' => 'email',
            'type' => 'email',
            'value' => $contactObj->getEmail()
         ],'input input-complex')
         ->addSelect($medias,'media','none','input select-complex')
         ->addSelect($genres, 'genre', 'none', 'input select-complex');
         $form->addInput([
            'name' => 'mediaName',
            'type' => 'text',
            'value' => $contactObj->getMediaName()
         ], 'input select-complex')
         ->add_contries_select('input select-complex', $contactObj->getCountry())
         // ->addInput([
         //    'name' => 'country',
         //    'type' => 'text',
         //    'value' => $contactObj->getCountry()
         // ],'input select-complex')
            ->addInput([
               'id' => 'website',
               'type' => 'text',
               'name' => 'website',
               'value' => $contactObj->getWebsite()
            ],'input select-complex','website')
            ->addTextarea([
               'id' => 'textarea-address',
               'name' => 'address',
               'rows' => 4,
               'cols' => 60,
               'placeholder' => 'Physical address',
            ],'textarea-complex', $contactObj->getAddress(), 'Address');
            $responseGetter = translation($contactObj->getResponse());
            $meetGetter = translation($contactObj->getMeet());
            $form->addInput([
               'type' => 'checkbox',
               'value' => $contactObj->getResponse(),
               'name' => 'response',
               setter($responseGetter) => '',
            ],'input', 'Response','checkbox-div')
            ->addInput([
               'type' => 'checkbox',
               'value' => 1,
               'name' => 'physical',
            ],'input ', 'Only physical?','checkbox-div')
            ->addInput([
               'type' => 'checkbox',
               'value' => $contactObj->getMeet(),
               'name' => 'meet',
               setter($meetGetter) => '',
            ],'input', 'Meet?', 'checkbox-div')
            ->addTextarea([
               'id' => 'content',
               'name' => 'notes',
               'rows' => 5,
               'cols' => 60,
            ], 'textarea-complex',$contactObj->getNotes(),'Notes');
            //Entonces lo mandamos hide el id
            $form->addSubmit([
               'type' => 'submit',
               'name' => 'submit',
               'value' => 'Submit'
            ],'input');
            $this->view->form = $form->get();
            $this->view->render('contact/admin/edit');
         } else {
            $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
            $this->html = '';
            redirect(url('search/index'));
         }
      }
   public function update($id)
      {
         $data = $_POST;
         if (isAdmin()) {
            if (!isset($data['meet'])) {
               $data['meet'] = 0;
            }else{
               $data['meet'] = 1;
            }
            if (!isset($data['response'])) {
               $data['response'] = 0;
            }else{
               $data['response'] = 1;
            }
            $contactObj = new ContactModel();
            $contactObj->setName($data['name']);
            $contactObj->setEmail($data['email']);
            $contactObj->setMedia($data['media']);
            $contactObj->setGenre($data['genre']);
            $contactObj->setCountry($data['country']);
            $contactObj->setMediaName($data['mediaName']);
            $contactObj->setNotes($data['notes']);
            $contactObj->setWebsite($data['website']);
            $contactObj->setAddress($data['address']);
            $contactObj->setResponse($data['response']);
            $contactObj->setMeet($data['meet']);
            $contactObj->save($id);
            redirect(url('search'));
         }else{
            $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
            $this->html = '';
            redirect(url('search/index'));
         }
         
      }
   public function delete()
      {
         if(isAdmin() && ucfirst($_POST['response']) == CONFIRM_YES) 
         {
            $details = new Detail;
            $details->delete_by_contact_id($_POST['id']);
            $contactObj = new ContactModel();
            $contactObj->delete($_POST['id']);
            $response = 'Deleted';
            echo json_encode($response);
         }elseif(isAdmin() && ucfirst($_POST['response']) == CONFIRM_NO)
         {
            $response = 'Cancel';
            echo json_encode($response);
         }else{
            $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
            $this->html = '';
            return redirect(url('admin/index'));
         }
      }
      
   }