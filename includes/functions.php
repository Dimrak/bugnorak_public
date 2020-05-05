<?php

function url($path)
{
    return APP_URL . $path;
}

function isAdmin()
{
   if (isset($_SESSION['user']) && $_SESSION['user']->role === ROLE_ADMIN) {
      return 'is admin';
   }
}

function is_guest()
{

}

function currentUser()
{
    if (isset($_SESSION['user'])){
        return $_SESSION['user']; //user es un objeto
    }else {
        return 0;
    }
}
function urlStyle($path)
{
    return APP_URL . $path;
}
//for dumping
function dump($data)
{
   echo '<pre>';
   print_r($data);
   
}
//for debugging
function dd($data)
{
   echo '<pre>';
   print_r($data);
   die();
}
function with($string)
{
   $html = '';
   $html .= '<p>' . $string . '</p>';
   return $html;
}
//To set and get the checkbox values
function setter($getter)
{
 if ($getter == 1) {
    $value = 'checked';
    return $value;
 }
 return true;
}
//alias getter
function translation($response)
{
   if ($response == 1){
      return true;
   }
   return false;
}
//------
//Redirect

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
}
