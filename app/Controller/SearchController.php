<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019.07.25
 * Time: 23:49
 */

namespace App\Controller;

use Core\Controller;
use App\Model\GenresModel;
use App\Helper\FormHelper;
use App\Model\ContactModel;
use App\Model\CategoriesModel;
use App\Block\Contacts\SearchResults;

class SearchController extends Controller
{
   public function index()
   {
      if (isAdmin()) 
      {
         //This would load the manual_search fields
         $contact_obj = new ContactModel();
         $contacts = $contact_obj->getContacts();
         $countries = $contact_obj->getCountries();
         $countries = [0 => 'Country'];
         foreach ($contacts as $country){
            $countries[$country->country] = $country->country;
            $countries = array_unique($countries, SORT_REGULAR); //remove duplicated entries
            $countries = array_filter($countries); //remove empty array entries
         }
         $genreObj = GenresModel::getGenres();
         $genres = [0 => 'Genres'];
         foreach ($genreObj as $genre){
            $genres[$genre->id] = $genre->name;
         }
         $categories = CategoriesModel::getCategories();
         $this->view->categories = $categories;
         $medias = [0 => 'Media'];
         foreach ($categories as $media) {
            $medias[$media->id] = $media->name;
         }
         //Loading the manual form
         $form = $this->form_maker($medias, $genres, $countries);
         $this->view->form = $form->get();
         $this->view->render('contact/search');
      }else
      {
         $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
         $this->html = '';
         redirect(url('account/login'));
      }
   }

   public function search()
   {
      //VALIDATION IN CASE NOT SET - SETTING DEFAULT VALUE
      if(currentUser())
      {
         if (empty($_GET['meet']))
         {
            $_GET['meet'] = 0;
         }else{
            $_GET['meet'] = 1;
         }
         if (!isset($_GET['response']))
         {
            $_GET['response'] = 0;
         }else{
            $_GET['response'] = 1;
         }
         $genre = $_GET['genre'];
         $media = $_GET['media'];
         $country = $_GET['country'];
         $meet = $_GET['meet'];
         $response = $_GET['response'];
         //Getting all the contacts mathing the search fields
         $results = ContactModel::getSearchResults($genre, $media, $country, $meet, $response);
         $block = new SearchResults();
         //Printing the results
         echo $block->getResultsBlock($results);
      }else{
        $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
        $this->html = '';
        redirect(url('account/login'));
      }
   }
   public function form_maker($medias, $genres, $countries)
   {
      $form = new FormHelper(url('search/search'), 'get', 'searchForm containerSearch gridContainer');
      $form ->addSelect($medias, 'media', 'medias', 'selectSearch grid-item')
            ->addSelect($genres, 'genre','genres', 'selectSearch grid-item')
            ->addSelect($countries, 'country', 'countries', 'selectSearch grid-item specialCountry')
            ->addTitle('Response', 'response-title')
            ->addInput([
               'id' => 'response',
               'type' => 'checkbox',
               'value' => 1,
               'name' => 'response',
            ],'response')
            ->addSubmit([
               'id' => 'searchSelect',
               'name' => 'submit',
               'type' => 'submit',
            ])
            ->addTitle('Meet', 'meet-title')
            ->addInput([
               'id' => 'meet',
               'type' => 'checkbox',
               'value' => 1,
               'name' => 'meet',
            ],'meet');
      return $form;      
   }

   // universe in this enchairmen -> book
   public function delete($id)
   {
      if (currentUser()->role == 1 && isset($_POST['yes'])) {
         $contactObj = new ContactModel();
         $contactObj->delete($id);
         redirect(url('search'));
      }elseif(currentUser()->role == 1 && isset($_POST['no'])){
         redirect(url('search/index'));
      }else{
         $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
         $this->html = '';
         redirect(url('search/index'));
      }
   }
   public function hover_show($id)
   {
      $contact_obj = new ContactModel;
      $contact = $contact_obj::getContact($id);
      $html = '';
      $html = '<div class="artboard">
         <div class="card">
         <div class="card__side card__side--back">
         <div class="card__cover">
         <h4 class="card__heading">
         <span class="card__heading-span"><?= $this->contact->name ?></span>
         </h4>
         </div>
         <div class="card__details">';
      $html .= '<ul>';
      foreach ($contact as $key => $value) {
         $html .= '<li>' .ucfirst($key) . ': ' . $value;
      }
      $html .= '</ul>';
      $html .= '</div>
         </div>
         <div class="card__side card__side--front">
         <div class="card__theme">
         <div class="card__theme-box">
         <p class="card__subject">Show</p>
         </div>
         </div>
         </div>
         </div>
         </div>';
         echo $html;
      // return $html;
   }
   
   public function index_second()
   {
      if (currentUser()) {
         //CONTACTS - countries -
         $contactObj = new ContactModel();
         $contacts = $contactObj->getContacts();
         $countries = $contactObj->getCountries();
         
         $this->view->contacts = $contacts;
         $this->view->countries = $countries;

         $countries = [0 => 'Country'];
         foreach ($contacts as $country){
            $countries[$country->country] = $country->country;
            $countries = array_unique($countries, SORT_REGULAR); //remove duplicated entries
            $countries = array_filter($countries); //remove empty array entries
         }
         //GENRES
         $genreObj = GenresModel::getGenres();
         $this->view->genres = $genreObj;
         $genres = [0 => 'Genres'];
         foreach ($genreObj as $genre){
            $genres[$genre->id] = $genre->name;
         }
          //MEDIAS
         $categories = CategoriesModel::getCategories();
         $this->view->categories = $categories;
         $medias = [0 => 'Media'];
         foreach ($categories as $media) {
            $medias[$media->id] = $media->name;
         }
         $form = new FormHelper(url('search/search'), 'get', 'searchForm containerSearch gridContainer');
         $form ->addSelect($medias, 'media', 'medias', 'selectSearch grid-item')
         ->addSelect($genres, 'genre','genres', 'selectSearch grid-item')
            ->addSelect($countries, 'country', 'countries', 'selectSearch grid-item specialCountry')
            ->addTitle('Response', 'response-title')
            ->addInput([
               'id' => 'response',
               'type' => 'checkbox',
               'value' => 1,
               'name' => 'response',
            ],'response')
            ->addSubmit([
               'id' => 'searchSelect',
               'name' => 'submit',
               'type' => 'submit',
            ])
         ->addTitle('Meet', 'meet-title')
            ->addInput([
               'id' => 'meet',
               'type' => 'checkbox',
               'value' => 1,
               'name' => 'meet',
            ],'meet');
         $this->view->form = $form->get();
         $this->view->render('contact/search');
      }else{
        $_SESSION['denied'] = strtoupper('<h1>Access denied</h1>');
        $this->html = '';
        redirect(url('account/login'));
      }
   }
}
