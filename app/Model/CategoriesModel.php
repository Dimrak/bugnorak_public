<?php

namespace App\Model;

use Core\Database;

class CategoriesModel
{
    private $id;
    private $name;
    private $des;
    private $parentId;
    private $slug;
    private $active;
    
    public function save($id = null)
    {
        if ($id != null){
            $this->id = $id;
            $this->update($id);
        }else {
            $this->create();
        }
    }
    public function create()
    {
        $db = new Database();
        $columns = 'name, des, parent_id, slug, active';
        $values = "'$this->name', '$this->des', $this->parentId, '$this->slug', $this->active";
        $db->insert('category', $columns, $values);
        $db->getOne();
    }
    public function update()
    {
        $db = new Database();
        $setContent = "name = '$this->name', des = '$this->des'";
        $db->update('category', $setContent)->where('id',$this->id);
        $db->getOne();
    }
    public static function getParentCategories()
    {
        $db = new Database();
        $db->select('name')->from('category')->where('parent_id', 0)->andWhere('active',  1);
        return $db->getAll();
    }
    public static function getCategories()
    {
        $db = new Database();
        $db->select()->from('category')->where('active', 1);
        return $db->getAll();
    }
    public static function getCategory($id)
    {
        $db = new Database();
        $db->select()->from('category')->where('id', $id);
        if ($db->getOne()){
            return true;
        }
        return false;
    }
    public function loadBySlug($slug)
    {
        $db = new Database();
        $db->select('id')->from('category')->where('slug', $slug); //variables - $fieldnama and id
        $category = $db->getOne();
        $this->load($category->id);
    }
    public function load($id)
    {
        $db = new Database();
        $db->select()->from('category')->where('id', $id);
        $category = $db->getOne();
        $this->id = $category->id;
        $this->name = $category->name;
        $this->des = $category->des;
        $this->parentId = $category->parent_id;
        $this->slug = $category->slug;
    }
    public function getContacts()
    {
        $db = new Database();
        $db->select('contact_id')->from('media_contact')
        ->where('media_id', $this->id);
        return $db->getAll();
    }  
    public function delete($id)
    {
        $db = new Database();
        $db->delete()->from('category')->where('id', $id);
        $db->getOne();
    }
    
    /**
    * Getters and setters
    */
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