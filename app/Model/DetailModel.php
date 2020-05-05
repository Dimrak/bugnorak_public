<?php namespace App\Model;

use Core\Database;

class DetailModel
{
    private $id;
    private $contact_id;
    private $history_creator_id;
    private $sent;
    private $response;
    private $notes;
    private $created_at;
    protected $db;
    
    public function __construct()
    {
       $this->db = new Database();
       return $this->db;
    }

    //Set here the input name="" of the details form
    const PREFIX_SENT = 'sent';
    const PREFIX_RESPONSE = 'response';
    const PREFIX_NOTES = 'notes';
    const PREFIX_UPDATE = 'update_details';
    const UPDATED = 'Changes saved ' . '&#128521';

    public function create()
    {
       $db = new Database();
       $columns = 'history_creator_id, contact_id, sent, response, notes';
       $values = "$this->history_creator_id, $this->contact_id, $this->sent, $this->response, '$this->notes'";
       $db->insert('contacts_history', $columns, $values);
       $db->getOne();
    }

    public static function order_by($id, $order)
    {
       $db = new Database;
       $db->select()->from('contacts_history')->where('contact_id', $id)->order('created_at', $order);
       return $db->getAll();
    }

    public static function get_history_details($id)
    {
      $db = new Database;
      $db->select()->from('contacts_history')->where('contact_id', $id);
      return $db->getAll();
    }
    
    public function delete_by_contact_id($id)
    {
        $this->db->delete()->from('contacts_history')->where('contact_id', $id);
        $this->db->getAll();
    }

    public function delete_by_history_id($id)
    {
        $this->db->delete()->from('contacts_history')->where('history_creator_id', $id);
        $this->db->getAll();
    }

    public static function get_existence_details($id, $contact_id)
    {
        $db = new Database;
        $db->select()
        ->from('contacts_history')
        ->where('history_creator_id', $id)
        ->andWhere('contact_id', $contact_id);
        return $db->getAll();
    }

    public function save($id = null)
    {
       if ($id != null){
          $this->id = $id;
          $this->update($id);
       }else {
          $this->create();
       }
    }
    public function update()
    {
       $db = new Database();
       $setContent = "sent = $this->sent, response = $this->response, notes = '$this->notes'";
       $db->update('contacts_history', $setContent)->where('id',$this->id);
       $db->getOne();
    }
    public function delete($id)
    {
      $db = new Database();
      $db->delete()->from('contacts_history')->where('id', $id);
      $db->getOne();
    }

    public static function getHistories()
    {
        $db = new Database();
        $db->select()->from('history_creator')->where('history', 1);
        return $db->getAll();
    }

    public function load($id)
    {
       $db = new Database();
       $db->select()->from('history_creator')->where('id', $id);
       $history_item = $db->getOne();
       $this->id = $history_item->id;
       $this->contact_id = $history_item->contact_id;
    }   

    #Getters and setters
    public function getId()
    {
       return $this->id;
    }
    public function setId($id)
    {
       $this->id = $id;
    }
    public function getcontact_id()
    {
       return $this->contact_id;
    }
    public function setcontact_id($contact_id)
    {
       $this->contact_id = $contact_id;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getHistory_creator_id()
    {
        return $this->history_creator_id;
    }

    public function setHistory_creator_id($history_creator_id)
    {
        $this->history_creator_id = $history_creator_id;

        return $this;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    public function getSent()
    {
        return $this->sent;
    }

    public function setSent($sent)
    {
        $this->sent = $sent;

        return $this;
    }
}