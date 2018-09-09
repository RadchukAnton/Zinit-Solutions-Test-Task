<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 08.09.18
 * Time: 16:23
 */
namespace Controller;


use Library\Controller;
use Library\Router;
use Model\Repository\UserRepository;
use Model\Forms\LoginForm;

class LoginController extends Controller
{
    public function __construct()
    {
    }

    public function actionIndex()
    {
        $form = new LoginForm(
          $this->request->post('email'),
          $this->request->post('password')
        );

        if ($this->request->isPost()){
            if ($form->isValid()) {
                $user = (new UserRepository())->findOneByEmail($form->email);
                if (!$user) {
                    $_SESSION['flash'] = 'User not found, please register';
                    Router::redirect('/register');
                }

                if (!$this->passwordCheck($form->password, $user->getPassword())) {
                    $_SESSION['flash'] = 'Please enter correct password';
                    Router::redirect('/login');
                }

                $_SESSION['user'] = $user->getEmail();
                Router::redirect('/author');
            } else {
                $_SESSION['flash'] = 'Form is not valid, please enter correct data';
                Router::redirect('/login');
            }
        }

        return $this->render('login');
    }

    public function actionRegister()
    {
        $form = new LoginForm(
            $this->request->post('email'),
            $this->request->post('password')
        );

        if ($this->request->isPost()){
            if ($form->isValid()) {
                $user = (new UserRepository())->findOneByEmail($form->email);
                if (!$user) {
                    $newUser = (new UserRepository())->userCreate($form->email, $form->password);
                    $_SESSION['user'] = $newUser->getEmail();
                    $_SESSION['flash'] = 'You successfully register, please login';
                    Router::redirect('/login');
                } else {
                    $_SESSION['flash'] = 'User with same email is exist';
                    Router::redirect('/register');
                }
            }
        }

        return $this->render('login');
    }
}

