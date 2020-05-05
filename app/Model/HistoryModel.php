<?php namespace App\Model;

use Core\Database;

class HistoryModel
{
    private $id;
    private $title;
    private $active;
    protected $db;
    
    public function __construct()
    {
       $this->db = new Database();
       return $this->db;
    }

    public function create()
    {
       $db = new Database();
       $columns = 'title, active';
       $values = "'$this->title', $this->active";
       $db->insert('history_creator', $columns, $values);
       $db->getOne();
    }

    public function save($id = null)
    {
       if ($id != null){
          $this->id = $id;
          print_r($this->id);
          $this->update($id);
       }else {
          $this->create();
          print_r($this->id);
       }
    }
    public function update()
    {
       $db = new Database();
       $setContent = "title = '$this->title'";
       $db->update('history_creator', $setContent)->where('id',$this->id);
       $db->getOne();
    }
    public function delete($id)
    {
      $db = new Database();
      $db->delete()->from('history_creator')->where('id', $id);
      $db->getOne();
    }

    public static function getHistories()
    {
        $db = new Database();
        $db->select()->from('history_creator')->where('active', 1);
        return $db->getAll();
    }

    public function get_history_name($id)
    {
       $this->db->select('title')->from('history_creator')->where('id', $id);
      //  dd($this->db->getOne());
       return $this->db->getOne();
    }

    public function get_history_ids()
    {
         $this->db->select('id')->from('history_creator')->where('active', 1);
         return $this->db->getAll();
    }

    public function load($id)
    {
       $db = new Database();
       $db->select()->from('history_creator')->where('id', $id);
       $history_item = $db->getOne();
       $this->id = $history_item->id;
       $this->title = $history_item->title;
       return $this;
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
    public function getTitle()
    {
       return $this->title;
    }
    public function setTitle($title)
    {
       $this->title = $title;
    }

    public function getActive()
    {
       return $this->active;
    }
 
    public function setActive($active)
    {
       $this->active = $active;
    }

}