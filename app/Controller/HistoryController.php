<?php namespace App\Controller;

use Core\Controller;
use App\Helper\Helper;
use App\Helper\FormHelper;
use App\Model\DetailModel as Detail;
use App\Model\ContactModel as Contact;
use App\Model\HistoryModel as History;

class HistoryController extends Controller
{
   public function get_histories($id)
   {
      $html = '';
      $histories = History::getHistories();
      if (empty($histories)) {
         $html .= '<h2> Please add history categories on the '.'<a class="cool-link" style="color:white; text-decoration:none" href="'. url('admin/index') .'">'. 'Admin-panel &rArr;</h2>';
         echo $html;
         die();
      }
      $html .= '<div id="container-hidden-history' .$id.'">';
      $html .= '<div class="inside-box">';
      $html .= '<h2 class="circles" style="text-transform: unset"> '.ucfirst('History details of '. Contact::getContact($id)->name). '</h2>';
      $html .= '<form action="' . url('details/store/'. $id) . '" method="post" id="history-form">';
      $html .= '<table id="history-table"  style="width:100%" class="">';
      $html .= '<thead>';
      $html .= '<tr>';
      $html .= '<th role="columnheader">'. '' .'</th>';
      $html .= '<th role="columnheader">'. 'Sent' .'</th>';
      $html .= '<th role="columnheader">'. 'Response' .'</th>';
      $html .= '<th role="columnheader">'. 'Notes' .'</th>';
      $html .= '</tr>';
      $html .= '</thead>';
      $html .= '<tbody>';
      $html .= $this->formMaker($histories, $id);
      $html .= '</tbody>';
      $html .= '</table>';
      $html .= '<td><input type="hidden" name="contact" value="'. $id . '"></td>';
      $html .= '<input type="submit" id="history-submit">';
      $html .= '</form>';
      $html .= '<div id="notify" class="pb-3 pt-3">
      <span id="notify__message"></span>
      </div>';
      $html .= '</div>';
      $html .= '</div>';
      echo $html;
   }
   

   public function formMaker($histories, $id)
   {
      $html = '';
      foreach ($histories as $key => $history) {
         $html .= '<tr>';
         $html .= '<th class="mimic-td">'. $history->title .'</th>';
         # Here need to pass if to check if that history exists for the user on contacts_history table
         if (Detail::get_existence_details($history->id,$id)) {
            //Check if the $id is on that array of entries
            $match = Detail::get_existence_details($history->id, $id);   
            $html .= $this->get_contact_history_details($match);
         }else{
            $html .= '<td class="ps-2"><input type="checkbox"  name="'. Detail::PREFIX_SENT . '-' . $history->id .'" value="1"></td>';
            $html .= '<td><input type="checkbox"  name="'. Detail::PREFIX_RESPONSE . '-' . $history->id .'" value="1"></td>';
            $html .= '<td><textarea class="white" name="'. Detail::PREFIX_NOTES . '-'. $history->id . '"></textarea></td>';
            $html .= '</tr>';
         }
      }
      return $html;
   }

   public function get_contact_history_details($contact_details)
   {
      $html = '';
      foreach ($contact_details as $key => $value) {
         if ($value->sent == 1) {
            $html .= '<td class="ps-2"><input type="checkbox"  name="'. Detail::PREFIX_SENT . '-' . $value->history_creator_id.'" value="1" checked></td>';
         }else{
            $html .= '<td class="ps-2"><input type="checkbox"  name="'. Detail::PREFIX_SENT . '-' . $value->history_creator_id.'" value="1"></td>';
         }
         if ($value->response == 1) {
            $html .= '<td><input type="checkbox"  name="'. Detail::PREFIX_RESPONSE . '-' . $value->history_creator_id .'" value="1" checked></td>';
         }else{
            $html .= '<td><input type="checkbox"  name="'. Detail::PREFIX_RESPONSE . '-' . $value->history_creator_id .'" value="1"></td>';
         }
         $html .= '<td><textarea class="white" name="'. Detail::PREFIX_NOTES . '-'. $value->history_creator_id . '">'. $value->notes .'</textarea></td>';
         $html .= '<input type="hidden" name="'. $value->history_creator_id . '-' . Detail::PREFIX_UPDATE . '" value="'. $value->id . '">';
         $html .= '</tr>';
      }
      return $html;
   }
   
   public function create()
   {
      if(isAdmin())
      {
         $histories = History::getHistories();
         $options = [0 => 'Choose parent genre'];
         foreach ($histories as $item){
            $options[$item->id] = $item->title;
         };
         $form = new FormHelper(url('history/store'), 'post', '');
         $form->addInput([
            'name' => 'title',
            'type' => 'text',
            'placeholder' => 'Create item'
         ],'input input-simple')
         ->addSubmit([
            'id' => 'Submit',
            'name' => 'submit',
            'type' => 'submit',
         ],'input submit-simple');
         $this->view->form = $form->get();
         $this->view->render('history/create');
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
         if(!empty($data))
         {
            $item_history = new History();
            $item_history->setTitle($data['title']);
            $item_history->setActive(1);
            $item_history->save();
            $_SESSION['success'] = CREATE_SUCCESS . ' ' .$item_history->getTitle();
            redirect(url('admin/index'));
         }
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
         $item_history = new History();
         $item_history->load($id);
         $form = new FormHelper(url('history/update/'). $id, 'post', '');
         $form->addInput([
            'name' => 'history_item',
            'type' => 'input',
            'value' => $item_history->getTitle()
         ],'input input-simple')->addSubmit([
               'type' => 'submit',
               'name' => 'submit',
               'value' => 'Submit'
            ],'input submit-simple');;
            $this->view->form = $form->get();
            $this->view->render('history/edit');
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
            $item_history = new History();
            $item_history->setTitle($data['history_item']);
            $item_history->save($id);
            $_SESSION['success'] = UPDATE_SUCCESS . ' ' . $item_history->getTitle();
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
            $details = new Detail;
            $details->delete_by_history_id($_POST['id']);
            $history_item = new History();
            $history_item->delete($_POST['id']);
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
   
   