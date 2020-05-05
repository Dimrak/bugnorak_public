<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019.07.04
 * Time: 10:26
 */
namespace App\Helper;

class Helper
{
   public function getController($path){
      $controller = strtolower($path);
      $controller = ucfirst($controller);
      $controller = "App\Controller\\" . $controller . "Controller";
      return $controller;
   }
   public static function generateToken($length = 16){
       $symbols = 'abcdefghijklmnopqrstuvwxyz1234567890';
       //is ko generuosim token
       $token = '';
       for ($i = 0; $i < $length; $i++){
           $token .= $symbols[mt_rand(0,strlen($symbols)-1)];
       }
       //16 veces va elegiendo una por uno y anadiendolo a token
       return $token;
   }   
   public static function generateToken_short($length = 8){
       $symbols = 'abcdefghijklmnopqrstuvwxyz1234567890';
       //is ko generuosim token
       $token = '';
       for ($i = 0; $i < $length; $i++){
           $token .= $symbols[mt_rand(0,strlen($symbols)-1)];
       }
       //16 veces va elegiendo una por uno y anadiendolo a token
       return $token;
   }
   
}