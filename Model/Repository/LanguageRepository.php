<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 09.09.18
 * Time: 21:21
 */

namespace Model\Repository;

use Library\DbConnection;

class LanguageRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DbConnection::getInstance()->getPdo();
    }

    /**
     * @return null|string
     */
    public function changeLanguage(): ?string
    {
        $sth = $this->pdo->prepare("SELECT languages.id FROM languages WHERE languages.id <> (SELECT `users`.`languageId` FROM `users` WHERE `email` = :email) limit 1;");
        $sth->execute([
            'email' => $_SESSION['user']
        ]);

        $data = $sth->fetch($this->pdo::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $data['id'];
    }
}