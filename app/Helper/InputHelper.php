<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019.07.10
 * Time: 11:29
 */

namespace App\Helper;
use Core\Database;

class InputHelper
{
   public static function passwordGenerator($pwrd){
      return md5(md5($pwrd . 'pepper'));
   }

    public static function uniqEmail($email)
    {
        $db = new Database();
        $db->select()->from('users')->where('email', $email);
        if($db->getOne()) {
            return true;
        }
        return false;
    }

   public static function uniqToken($token){
      $db = new Database();
      $db->select()->from('admin')->where('token', $token);
      if ($db->getOne()){
         return true;
      }
      return false;
   }
//    public static function checkTwc($data){
//       if (empty($data)){
//          $data = 0;
//       }else{
//          $data = 1;
//       }
//       return $data;
//    }
}