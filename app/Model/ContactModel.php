<?php
namespace App\Model;

use Core\Database;

class ContactModel
{
   private $id = null;
   private $media;
   private $mediaName;
   private $genre;
   private $name;
   private $email;
   private $country;
   private $address;
   private $notes;
   private $response;
   private $meet;
   private $website;
   private $active;
   private $physical;

   protected $db;
    
   public function __construct()
   {
      $this->db = new Database();
      return $this->db;
   }

   public static function getContact($id)
   {
      $db = new Database();
      $db->select()->from('contacts')->where('id', $id);
      return $db->getOne();
   }

   public function get_genre($id)
   {
      $this->db->select()->from('genres')->where('id', $id);
      return $this->db->getOne();
   }
   public function get_media($id)
      {
         $this->db->select()->from('category')->where('id', $id);
         return $this->db->getOne();
      }

      public function get_genre_name($id)
      {
         $this->db->select('name')->from('genres')->where('id', $id);
         return $this->db->getOne();
      }
   public function get_media_name($id)
   {
      $this->db->select('name')->from('category')->where('id', $id);
      return $this->db->getOne();
   }   

   public static function getContacts()
   {
      $db = new Database();
      $db->select()->from('contacts');
      return $db->getAll();
   }
   public static function getCountries()
   {
      $db = new Database();
      $db->select('country')->from('contacts');
      return $db->getAll();
   }
   public function getContactsbyMedia($id)
   {
      $db = new Database();
      $db->select()->from('contacts')->where('media', $id);
      return $db->getAll();
   }
   public function search($data)
   {
      $db = new Database();
      $db->select()->from('contacts')->Where('country', $data['country']);
      return $db->getAll();
   }
   public function load($id)
   {
      $db = new Database();
      $db->select()->from('contacts')->where('id', $id);
      $contact = $db->getOne();
      $this->id = $contact->id;
      $this->name = ucfirst($contact->name);
      $this->email = $contact->email;
      $this->country = ucfirst($contact->country);
      $this->media = $contact->media;
      $this->genre = $contact->genre;
      $this->notes = $contact->notes;
      $this->mediaName = $contact->mediaName;
      $this->address = $contact->address;
      $this->website = $contact->website;
      $this->response = $contact->response;
      $this->meet = $contact->meet;
      $this->physical = $contact->physical;
      return $this;
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
   public function create()
   {
      $db = new Database();
      $columns = 'media, mediaName, genre, country, email, name, address, notes, response, meet, website, active, physical';
      $values = "$this->media, '$this->mediaName', $this->genre, '$this->country', '$this->email', '$this->name', '$this->address', '$this->notes', $this->response, $this->meet, '$this->website', $this->active, $this->physical";
      $db->insert('contacts', $columns, $values);
      $db->getOne();
   }
   public function update($id)
   {
      $db = new Database();
      $setContent = "name = '$this->name', mediaName = '$this->mediaName', email = '$this->email', country = '$this->country', media= $this->media, notes = '$this->notes', genre = $this->genre, website = '$this->website', address = '$this->address',response = $this->response, meet = $this->meet";
      $db->update('contacts', $setContent)->where('id', $id);
      $db->getOne();
   }
   public function update_physical($id)
   {
      $db = new Database();
      $setContent = "physical = $this->physical";
      $db->update('contacts', $setContent)->where('id', $id);
      $db->getOne();
   }
   public function delete($id)
   {
      $db = new Database();
      $db->delete()->from('contacts')->where('id', $id);
      $db->getOne();
   }
   public function search2($data)
   {
      $db = new Database();
      $db->select()->from('contacts')->where('genre', $data['genres'])->andWhere('media', $data['categories']);
      return $db->getAll();
   }

   public static function getSearchResults($genre, $media, $country, $meet, $response)
   {
      $db = new Database();
      $db->select()->from('contacts')->where('active',1);

      if($media != 0)
      {
         $db->andWhere('media', $media);
      }
      if($genre != 0) 
      {
         $db->andWhere('genre', $genre);
      }
      if ($meet != 0)
      {
         $db->andWhere('meet', $meet);
      }
      if ($response != 0)
      {
         $db->andWhere('response', $response);
      }
      if (!empty($country))
      {
         $db->andWhere('country', $country);
      }
      return $db->getAll();
   }

   /**
    * GETTERS AND SETTERS
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

   public function getEmail()
   {
      return $this->email;
   }

   public function setEmail($email)
   {
      $this->email = $email;
   }

   public function getCountry()
   {
      return $this->country;
   }

   public function setCountry($country)
   {
      $this->country = $country;
   }

   public function getMedia()
   {
      return $this->media;
   }

   public function setMedia($media)
   {
      $this->media = $media;
   }

   public function getMediaName(){
      return $this->mediaName;
   }

   public function setMediaName($mediaName){
      $this->mediaName = $mediaName;
   }

   public function getNotes()
   {
      return $this->notes;
   }

   public function getNotesShort()
   {
      return substr($this->notes, 0, 5);
   }

   public function setNotes($notes)
   {
      $this->notes = $notes;
   }
   public function getGenre()
   {
      return $this->genre;
   }

   public function setGenre($genre)
   {
      $this->genre = $genre;
   }

   public function getAddress()
   {
      return $this->address;
   }

   public function setAddress($address)
   {
      $this->address = $address;
   }

   public function getResponse()
   {
      return $this->response;
   }

   public function setResponse($response)
   {
      $this->response = $response;
   }

   public function getMeet()
   {
      return $this->meet;
   }

   public function setMeet($meet)
   {
      $this->meet = $meet;
   }

   public function getWebsite()
   {
      return $this->website;
   }

   public function setWebsite($website)
   {
      $this->website = $website;
   }
   public function getActive()
   {
      return $this->active;
   }
   public function setActive($active)
   {
      $this->active = $active;
   }
   public function setPhysical($physical)
   {
      $this->physical = $physical;
   }
   public function getPhysical()
   {
      return $this->physical;
   }
}