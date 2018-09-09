<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 08.09.18
 * Time: 17:45
 */

namespace Controller;

use Library\Controller;
use Model\Repository\AuthorsRepository;

class AuthorController extends Controller
{
    public function __construct()
    {
    }

    public function actionIndex()
    {
       $authors = (new AuthorsRepository())->getAuthorList();

       if (!$authors) {
           throw new \Exception('Authors not foun');
       }

       return $this->render('author', [
           'authors' => $authors
       ]);
    }
}