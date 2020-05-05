<?php namespace App\Block\Contacts;
use App\Model\GenresModel;
use App\Model\CategoriesModel;
use App\Model\ContactModel;
use App\Model\DetailModel as Detail;

class SearchResults
{
   
   protected $pepper = PEPPER_TRANS;
   
   public function getResultsBlock($results)
   {
      $html = '';
      //Making the table header
      $html .= $this->table_header();
      // Making the table rows with each contact details
      $html .= '<tbody role="rowgroup">';
      foreach ($results as $contact){
         $html .= $this->getContactBlock($contact);
      }
      $html .= '</tbody>';
      // Storing physical change
      $html .= '</table>';
      return $html;
   }  
   public function physical_form($contact, $physical)
   {
      $html = '';
      $html .= '<td role="cell" style="width: 110%; display: flex; flex-direction: row; flex-wrap: nowrap; align-items: center; color:rgba(0,0,0,0); font-size:0px;">'. $physical .'';
      $html .= '<form style="display:flex;" method="post" action="' . APP_URL . 'contact/store_physical/' .'" id="physical-form-'.$contact->id.'">';
      $html .= '<input type="checkbox" style="display: inline" class="sentBani-answer" id="'.'physi' . $contact->id . '" name="physical"'. $physical .'>';
      $html .= '<input class="store-physical" type="submit" style="border:3px solid indianred;font-weight:600;border-radius:50%; padding:10px;display:inline-block; margin-left:15px; margin-right:15px"" id="'.$contact->id.'" value="S">';
      // $html .= '<span style="display:none; position:fixed; z-index:1;" class="'. 'update' . $contact->id .' physical-update">  </span>';
      $html .= '</form>';
      $html .= '</td>';
      $html .= '<span style="display:none; position:fixed; z-index:1;" class="'. 'update' . $contact->id .' physical-update">  </span>';

      return $html;
   }
   
   public function translate_physical($physical_value)
   {
      if ($physical_value == 1)
      {
         $physical = 'checked';
      }else{
         $physical = 'n/a';
      }
      return $physical;
   }
   
   
   public function translate_meet($meet_value)
   {
      if ($meet_value == 1)
      {
         $meet = CONFIRM_YES;
      }else{
         $meet = CONFIRM_NO;
      }
      return $meet;
   }
   
   public function translate_response($contact_value, $responses)
   {
      if ($contact_value == 1 || !empty($responses))
      {
         $response = CONFIRM_YES;
      }else{
         $response = CONFIRM_NO;
      }
      return $response;
   }
   
   public function get_response_value($id)
   {
      $history_response = Detail::get_history_details($id);
      $responses = [];
      foreach ($history_response as $key => $value) {
         if ((int)$value->response === (int)1) {
            $responses[] = $value->response;
         }
      }
      return $responses;
   }
   
   public function hover_show($contact)
   {
      
      $html = '';
      $html .= '<div class="hidden-class hide"  id="container-hidden' . $contact->id .'">';
      $html .= '<div class="inside-box">';
      $html .= '<span class="close">&times;</span>'; 
      foreach ($contact as $key => $value) {
         if ($key == 'address') {
            $html .= '<div class="mb1">'. '<span class="label__show">'.ucfirst($key) . '</span>' .'<i class="far fa-copy"></i><input readonly="readonly" class="address-copy full-width" value="' . $value . '">' . '</div>';
         }
         if ($key == 'notes') {
            $html .= '<div class="mb1">'.'<p >' .'<span class="label__show">'.ucfirst($key) . '</span>'  . $value . '</p>'.'</div>';
         } 
         if ($key == 'website') {
            $html .= '<div class="mb1">'. '<span class="label__show">'.ucfirst($key) . '</span>'.'<a style="border:none;" href="' . $value . '" target="_blank">'. $value .'</a>' . '</div>';
         }    
      }
      $html .= '<a style="display:inline-block;  margin:10px 0;" href="' . url('contact/show/'). $contact->id .'" class="btn-custom"> Go to contact' . '</a>';
      $html .= '</div>';
      $html .= '</div>';
      return $html;
   }
   
   
   public function getContactBlock($contact)
   {
      //first part   
         $html = '';
         //Getting the response value -Yes or No
         $responses = $this->get_response_value($contact->id);
         //Translations
         //Response
         $response = $this->translate_response($contact->response, $responses);
         //Meet
         $meet = $this->translate_meet($contact->meet);
         //Physical checkbox active
         $physical = $this->translate_physical($contact->physical);
         //Getting the media and genre names
         $contact_obj = new ContactModel;
         $genre = $contact_obj->get_genre_name($contact->genre);
         $media = $contact_obj->get_media_name($contact->media);
         if (empty($genre)) {
            $genre_name = '';
         }else{
            $genre_name = $genre->name;
         }
         if (empty($media)) {
            $media_name = '';
         }else{
            $media_name = $media->name;
         }
         //TABLE CONTENT
         $html .= '<tr role="row" class="tableColor">';
         //media, genre, media-name, email
         $html .= '<td role="cell">' . $media_name . '</td>';
         $html .= '<td role="cell">' . ucfirst($genre_name) . '</td>';
         $html .= '<td role="cell">' . $contact->mediaName . '</td>';
         $html .= '<td role="cell">' . ucfirst($contact->name) . '</td>';
         // <i class="far fa-copy"></i>
         // $html .= '<td role="cell" class="email-td"><input readonly="readonly" class="email-copy" value="' . $contact->email . '"></td>';
         $html .= '<td role="cell" class="email-td">'. $contact->email .'<i class="far fa-copy"></i></td>';
         
         //physical, country, response, meet
         $html .= $this->physical_form($contact, $physical);
         $html .= '<td role="cell">' . ucfirst($contact->country) . '</td>';
         $html .= '<td class="centerTd" role="cell">' . $response . '</td>';
         $html .= '<td class="centerTd" role="cell">' . $meet . '</td>';
      
      //History
      
      // $html .= '<td class="centerTd" role="cell">' . '<a class="contact-history" href="' . url('history/get_histories/') . $contact->id. '" >His</a>' . '</td>';
      $html .= '<td class="centerTd history-td" role="cell">' . '<a class="contact-history" href="' . url('history/get_histories/') . $contact->id. '" rel="modal:open" extra-id="'. $contact->id .'">His</a>' . '</td>';
      // Action btns
      
      $html .= '<td role="cell">';
      $html .= '<a class="contact-show" href="' . url('contact/show/'). $contact->id .'" extra-id="'. $contact->id .'" target="_blank">More</a>';
      $html .= $this->hover_show($contact);
      
      //Action validation role
      if (isAdmin()){
         $html .= '<a disable="true" class=" editProfile" id="' . $contact->id . '" target="" href="' . url('contact/edit/') . $contact->id . '" value="' . $contact->id . '">Edit' . '</a>';
         $html .= '<a id="' . $contact->id . '" class="actionBtn modalBtnContact searchBtn" value="' . $contact->id . '" data-delete="'. $contact->id .'">Delete</button>';
      }
      $html .= '</td>';
      $html .= '</tr>';
      return $html;
   }
   public function table_header()
   {
      $html = '';
      $html .= '<table id="tableMain" role="table">';
      $html .= '<thead>';
      $html .= '<tr role="row">';
      $html .= '<th role="columnheader">Media</th>';
      $html .= '<th role="columnheader">Genre</th>';
      $html .= '<th role="columnheader">MediaName</th>';
      $html .= '<th role="columnheader" class="extra-space">Name</th>';
      $html .= '<th role="columnheader">Email</th>';
      $html .= '<th role="columnheader">Only physical</th>';
      $html .= '<th role="columnheader">Country</th>';
      $html .= '<th role="columnheader">Response</th>';
      $html .= '<th role="columnheader">Meet</th>';
      $html .= '<th role="columnheader">History</th>';
      $html .= '<th style="min-width:260px;"role="columnheader">Actions</th>';
      $html .= '</tr>';
      $html .= '<script>
      $(document).ready( function () {
            $("#tableMain").DataTable( {
                  paging: false} );
               } );                      
               </script>';
            $html .= '</thead>';
            return $html;
         }
         
         //   ON DEV
         //to reduce the translation functions to 1
         //    public function translation($value)
         // {
            //    // dd($value == 19881);
            //    // (int)$last = substr($value, -1);
            //    (int)$last = end($value);
            //    dd($last);
            //    dump($value . '-' .gettype((int)$value));
            //    dump($last . '-' .gettype((int)$last));
            //    // dd();
            //    if ((int)$value === $last) {
               //       dd($value);
               //       dump('asdasdads');
               //    }
               //    if ((int)$value === (int)1 || (int)$value === (int)PEPPER_TRANS . (int)1) {
                  //       if ((int)$value === (int)1) {
                     //          dd('  sda');
                     //          $translation = CONFIRM_YES;
                     //       }elseif((int)$value === (int)PEPPER_TRANS . (int)1)
                     //       {
                        //          dd('helllllllllllo');
                        //          $translation = 'checked';
                        //       }else{
                           //          dd('polla');
                           //       }
                           //    }else{
                              //       if ((int)$value === (int)0) {
                                 //          $translation = CONFIRM_NO;
                                 //       }else{
                                    //          $translation = '';
                                    //       }
                                    //    }
                                    //    return $translation;
                                    // }
                                    
}