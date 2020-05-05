<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019.07.04
 * Time: 10:26
 */
namespace Core;
class View
{
   public $url;

   public function render($template = '')
   {
      $path = __DIR__;
      $path = str_replace('core', '/', $path);
      include $path.'views/page/head.php';
      include $path.'views/page/header.php';
      include $path . 'views/' . $template . '.php';
      include $path.'views/page/footer.php';
    }
}