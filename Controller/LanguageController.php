<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 09.09.18
 * Time: 20:36
 */

namespace Controller;


use Library\Controller;
use Library\Router;
use Model\Repository\LanguageRepository;
use Model\Repository\UserRepository;

class LanguageController extends Controller
{
    public function __construct()
    {

    }

    public function actionChange()
    {
        $languageForChangeId = (new LanguageRepository())->changeLanguage();
        (new UserRepository())->updateUserLanguage($_SESSION['user'], $languageForChangeId);
        Router::redirect('/author');
    }
}