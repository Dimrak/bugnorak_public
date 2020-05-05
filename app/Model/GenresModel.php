<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019.07.18
 * Time: 12:49
 */

namespace App\Model;

use Core\Database;
class GenresModel
{
   private $id;
   private $name;
   private $des;
   private $parentId;
   private $slug;
   private $active;
   protected $db;

   public function __construct()
   {
      $this->db = new Database();
      return $this->db;
   }

    public function load($id)
   {
      $db = new Database();
      $db->select()->from('genres')->where('id', $id);
      $genre = $db->getOne();
      $this->id = $genre->id;
      $this->name = $genre->name;
      $this->des = $genre->des;
      $this->parentId = $genre->parent_id;
      $this->slug = $genre->slug;
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

   public function create()
   {
      $db = new Database();
      $columns = 'name, des, parent_id, slug, active';
      $values = "'$this->name', '$this->des', $this->parentId, '$this->slug', $this->active";
      $db->insert('genres', $columns, $values);
      $db->getOne();
   }

   public static function getGenres()
   {
      $db = new Database();
      $db->select()->from('genres')->where('active', 1);
      return $db->getAll();
   } 
   
   public function get_genres_names()
   {
      $this->db->select('name')->from('genres')->where('active', 1);
      return $this->db->getAll();
   }
   
    public function delete($id)
    {
      $db = new Database();
      $db->delete()->from('genres')->where('id', $id);
      $db->getOne();
    }
    public function update()
   {
      $db = new Database();
      $setContent = "name = '$this->name', des = '$this->des'";
      $db->update('genres', $setContent)->where('id',$this->id);
      $db->getOne();
   }

   public function getId()
   {
      return $this->id;
   }

   public function setId($id)
   {
      $this->id = $id;
   }

   public function getName()
   {
      return $this->name;
   }

   public function setName($name)
   {
      $this->name = $name;
   }

   public function getDes()
   {
      return $this->des;
   }

   public function setDes($des)
   {
      $this->des = $des;
   }

   public function getParentId()
   {
      return $this->parentId;
   }

   public function setParentId($parentId)
   {
      $this->parentId = $parentId;
   }

   public function getSlug()
   {
      return $this->slug;
   }

   public function setSlug($slug)
   {
      $this->slug = $slug;
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