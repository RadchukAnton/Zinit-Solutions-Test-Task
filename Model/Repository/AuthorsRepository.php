<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 09.09.18
 * Time: 19:41
 */

namespace Model\Repository;

use Library\DbConnection;
use Model\Entities\Author;
use Fresh\Transliteration\Transliterator;

class AuthorsRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DbConnection::getInstance()->getPdo();
    }

    public function getAuthorList()
    {
        $result = [];

        $sth = $this->pdo->prepare("SELECT `authors`.`name`, `authors`.`surname`, `books`.title, `authors`.id, `languages`.`language` FROM `authors`
                                              INNER JOIN `books` ON `authors`.id = `books`.`authorId`
                                              INNER JOIN `languages` ON `books`.`languageId` = `languages`.`id` 
                                              WHERE `books`.languageId = (SELECT `languageId` FROM `users` WHERE `email` = :email);
                                  ");
        $sth->execute([
            'email' => $_SESSION['user']
        ]);

        $data = $sth->fetchAll();
        if (!$data) {
            return null;
        }

        foreach ($data as $author) {
            if ($author['language'] == 'English') {
                $transliterator = new Transliterator();
                $author['name'] = $transliterator->ukToEn($author['name']);
                $author['surname'] = $transliterator->ukToEn($author['surname']);
            }

            if (!isset($result[$author['id']])) {
                $result[$author['id']] = (new Author())
                    ->setBooks($author['title'])
                    ->setSurname($author['surname'])
                    ->setName($author['name']);
            } else {
                $result[$author['id']]->setBooks($author['title']);
            }
        }

        return $result;
    }

    public function getAuthorListByLanguage($languageId)
    {
        $result = [];

        $sth = $this->pdo->prepare("SELECT `authors`.`name`, `authors`.`surname`, `books`.title, `authors`.id, `languages`.`language` FROM `authors`
                                              INNER JOIN `books` ON `authors`.id = `books`.`authorId`
                                              INNER JOIN `languages` ON `books`.`languageId` = `languages`.`id` 
                                              WHERE `books`.languageId = :languageId;
                                  ");
        $sth->execute([
            'languageId' => $languageId
        ]);

        $data = $sth->fetchAll();
        if (!$data) {
            return null;
        }

        foreach ($data as $author) {
            if ($author['language'] == 'English') {
                $transliterator = new Transliterator();
                $author['name'] = $transliterator->ukToEn($author['name']);
                $author['surname'] = $transliterator->ukToEn($author['surname']);
            }

            if (!isset($result[$author['id']])) {
                $result[$author['id']] = (new Author())
                    ->setBooks($author['title'])
                    ->setSurname($author['surname'])
                    ->setName($author['name']);
            } else {
                $result[$author['id']]->setBooks($author['title']);
            }
        }

        return $result;
    }

}