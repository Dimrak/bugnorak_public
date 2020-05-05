<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019.07.04
 * Time: 11:13
 */

namespace App\Controller;

use App\Helper\InputHelper;
use App\Model\ContactModel;
use App\Helper\FormHelper;
use App\Model\UsersModel;
use App\Helper\Helper;
use Core\Controller;

class AccountController extends Controller
{
   public function register()
   {
      $form = new FormHelper(url('account/create'), 'post', 'registerForm');
      $form->addInput([
         'name' => 'username',
         'id' => 'Username',
         'type' => 'text',
         'autocomplete' => 'off',
         'placeholder' => 'Choose a username',
         ])
         ->addInput([
            'name' => 'email',
            'id' => 'emailRegister',
            'type' => 'email',
            'autocomplete' => 'off',
            'placeholder' => 'Enter your email'
         ])
         ->addInput([
            'name' => 'pwrd',
            'id' => 'password',
            'type' => 'password',
            'placeholder' => 'Enter your password',
         ])
         ->addInput([
            'name' => 'pwrd2',
            'id' => 'password2',
            'type' => 'password',
            'placeholder' => 'Reenter the password',
         ], 'Reenter password')
         ->addSubmit([
            'id' => 'submitRegister',
            'type' => 'submit',
            'name' => 'submit',
            'value' => 'Submit form',
         ],'modalBtn');
      $this->view->form = $form->get();
      $this->view->render('account/registration');
   }

   public function create()
    {
      $response = [];
      $userObj = new UsersModel();
      $userObj->setUsername($_POST['username']);
      $userObj->setEmail($_POST['email']);
      $email = $_POST['email'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $response['email'] = $email;
      $response['username'] = $username;
      $response['password'] = $password;
      $token = Helper::generateToken(16);
      $userObj->setToken($token);
      $pass = InputHelper::passwordGenerator($_POST['password']);
      $userObj->setPwrd($pass);
      $userObj->setActive(0);
      $userObj->setRole(0);
      echo json_encode($response);
      $userObj->save();
      $userObj->mailActivation($token);
    }

   public function activation($token)
   {
      if (InputHelper::uniqToken($token)) {
         $user = new UsersModel();
         $user->loadByToken($token);
         $user->setActive(1);
         $user->save($user->getId());
         redirect(url('contact/login'));
      } else {
         echo "Something went wrong";
      }
   }

    public function auth()
    {
        $pwrd = InputHelper::passwordGenerator($_POST['pwrd']);
        $email = $_POST['email'];
         $user = UsersModel::verification($email, $pwrd);
       //RESET TRIES TO LOGIN
        if (!empty($user)) {
            $_SESSION['user'] = $user;
            $usersObj = new UsersModel();
            $usersObj->resetLoginNumber($user->id);
            redirect(url('search'));
            echo $this->view->user;
            } else {
            if (InputHelper::uniqEmail($email)) {
                $user = new UsersModel();
                $user->loadByEmail($email);
               if ($user->getTriesToConnect() == 2) {
                  $triesToConnect = $user->getTriesToConnect() + 1;
                  $user->setTriesToConnect($triesToConnect);
                  $user->save($user->getId());
                  $_SESSION['incorrect'] = 'Incorrect login details. Tries left ' . (4 - $user->getTriesToConnect());
                  if ($user->getTriesToConnect() == 3) {
                     session_unset();
                     $_SESSION['warning'] = 'Las try, before disabling your account.';
                     $_SESSION['warning'] .= '<br>' . '<br>';
                     $_SESSION['warning'] .= '<i style="color: rgba(18,30,255,0.83)">'.$email.'</i>';
                     return redirect(url('account/login'));
                  }
                }
               elseif($user->getTriesToConnect() == 3){
                  $triesToConnect = $user->getTriesToConnect() + 1;
                  $user->setTriesToConnect($triesToConnect);
                  $user->save($user->getId());
                     if ($user->getTriesToConnect() == 4 ){
                        $user->delete();
                        $user->mail();
                        session_unset();
                        $_SESSION['disable'] = 'Your account has been disabled';
                        return redirect(url('account/login'));
                     }
                  }
               elseif ($user->getTriesToConnect() < 2){
                  $triesToConnect = $user->getTriesToConnect() + 1;
                  $user->setTriesToConnect($triesToConnect);
                  $user->save($user->getId());
                  session_unset();
                  $_SESSION['incorrect'] = 'Incorrect login details. Tries left ' . (4 - $user->getTriesToConnect());
                  return redirect(url('account/login'));
               }elseif ($user->getTriesToConnect() == 4){
                  session_unset();
                  $_SESSION['disable'] = 'The account ' . '<i style="color: rgba(18,30,255,0.83)">'.$email.'</i>' . ' is disabled.';
                  $_SESSION['disable'] .= '<br>';
                  $_SESSION['disable'] .= 'Contact the administrator';
                  return redirect(url('account/login'));
               }
            }elseif (InputHelper::uniqEmail($email) == false) {
               session_unset();
               $_SESSION['user_no_db'] = 'Login details dont exists';
               return redirect(url('account/login'));

            }
        }
    }

   public function uniqEmail()
   {
      $email = $_POST['email'];
      $emailObj = InputHelper::uniqEmail($email);
      if ($emailObj){
         echo 'true';
      }else{
         echo "false";
      }
   }
    public function login()
    {
        $form = new FormHelper('auth', 'post', 'form-login');
        $form->addInputLogin([
            'name' => 'email',
            'placeholder' => 'Enter email',
            'type' => 'email',
            'required' => 'true',
        ], 'input input-simple')
            ->addInput([
                'name' => 'pwrd',
                'placeholder' => 'Enter password',
                'type' => 'password',
                'required' => 'true',
            ], 'input input-simple')
            ->addInput([
                'name' => 'submit',
                'type' => 'submit',
            ], 'input submit-simple');
        $this->view->form = $form->get();
        $this->view->render('account/login');
    }
   public function logOut()
   {
      session_destroy();
      $contactObj = new ContactModel();
      url('contact');
      redirect(url('contact'));
   }

}
