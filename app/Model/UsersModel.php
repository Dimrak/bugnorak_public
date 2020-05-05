<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019.07.10
 * Time: 11:18
 */

namespace App\Model;

use Core\Database;
class UsersModel
{
   private $id;
   private $username;
   private $email;
   private $pwrd;
   private $active;
   private $token;
   private $triesToConnect;
   private $role;

   public function save($id = null)
   {
      if ($id !== null){
         $this->id = $id;
         $this->update();
      }else {
         $this->create();
      }
   }

    public function update()
    {
        $db = new Database();
        $setContent = "username = '$this->username', email = '$this->email', pwrd = '$this->pwrd', 
      tries_to_connect = ' $this->triesToConnect', active = $this->active";
        $db->update('users', $setContent)->where('id',$this->id);
        $db->getOne();
    }

   public function create()
   {
      $db = new Database();
      $columns = 'username, email, pwrd, token, active';
      $values = "'$this->username', '$this->email', '$this->pwrd', '$this->token', $this->active";
      $db->insert('users', $columns, $values);
      $db->getOne();
   }
   public static function verification($email, $pwrd)
   {
      $db = new Database();
      $db->select()->from('users')
          ->where('email', $email)
          ->andWhere('pwrd', $pwrd)
      ->andWhere('active', 1);

      return $db->getOne();
   }

   public static function resetLoginNumber($userId)
   {
      $db = new Database();
      $db->update('users', 'tries_to_connect = 0')
          ->where('id', $userId);
      $db->getOne();
   }

   public function selectAllEmail()
   {
       $db = new Database();
       $db->select('email')->from('users');
       $db->getAll();

   }

    public function delete()
    {
        $setContent = "active = 0";
        $db = new Database();
        $db->update('users', $setContent)->where('id',$this->id);
        $db->getOne();
    }

    public function load($id)
    {
        $db = new Database();
        $db->select()->from('users')->where('id', $id);
        $user = $db->getOne();
        $this->id = $user->id;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->pwrd = $user->pwrd;
        $this->active = $user->active;
        $this->token = $user->token;
        $this->triesToConnect = $user->tries_to_connect;
    }
    public function mailActivation($token)
    {
       $subject = 'the subject';
       $message = url('account/activation/') . $token;
       $headers = 'From: webmaster@example.com' . "\r\n" .
          'Reply-To: webmaster@example.com' . "\r\n" .
          'X-Mailer: PHP/' . phpversion();

       if (mail('diego_parte12@hotmail.com', $subject, $message, $headers)) {
         //echo "Mail sent";
           //removed this to avoid that would be sent to json in the AJAX request
       }else {
         // echo "Mail not sent";
       }
    }
   public function loadByToken($token)
   {
      $db = new Database();
      $db->select()->from('users')->where('token', $token);
      $user = $db->getOne();
      $this->id = $user->id;
      $this->username = $user->username;
      $this->email = $user->email;
      $this->pwrd = $user->pwrd;
      $this->active = $user->active;
      $this->token = $user->token;
      $this->triesToConnect = $user->tries_to_connect;
   }


   public function mail()
   {
        $subject = 'the subject';
        $message = 'hello';
        $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if (mail('diego_parte12@hotmail.com', $subject, $message, $headers)) {
            echo "Mail sent";
        }else {
            echo "Mail not sent";
        }
    }
    public function loadByEmail($email)
    {
        $db = new Database();
        $db->select('id')->from('users')->where('email', $email);
        $user = $db->getOne();
        $this->load($user->id);
    }


   public function getId()
   {
      return $this->id;
   }

   public function getUsername()
   {
      return $this->username;
   }

   public function setUsername($username)
   {
      $this->username = $username;
   }

   public function getEmail()
   {
      return $this->email;
   }

   public function setEmail($email)
   {
      $this->email = $email;
   }

   public function getPwrd()
   {
      return $this->pwrd;
   }

   public function setPwrd($pwrd)
   {
      $this->pwrd = $pwrd;
   }

   public function getToken()
   {
      return $this->token;
   }

   public function setToken($token)
   {
      $this->token = $token;
   }

   public function getTriesToConnect()
   {
      return $this->triesToConnect;
   }

   public function setTriesToConnect($triesToConnect)
   {
      $this->triesToConnect = $triesToConnect;
   }

   public function getActive()
   {
      return $this->active;
   }

   public function setActive($active)
   {
      $this->active = $active;
   }

    public function getRole()
    {
       return $this->role;
    }
 
    public function setRole($role)
    {
       $this->role = $role;
    }


}