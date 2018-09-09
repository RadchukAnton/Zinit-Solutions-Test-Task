<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 09.09.18
 * Time: 12:36
 */
namespace Model\Repository;

use Library\DbConnection;
use Model\Entities\User;

class UserRepository
{
    private $PDO;

    public function __construct()
    {
        $this->PDO = DbConnection::getInstance()->getPdo();
    }

    /**
     * @param $email
     * @return User|null
     */
    public function findOneByEmail($email): ?User
    {
        $sth = $this->PDO->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $sth->execute([
            'email' => $email
        ]);

        $data = $sth->fetch($this->PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        return  (new User())
            ->setId($data['id'])
            ->setEmail($data['email'])
            ->setPassword($data['password']);
    }

    /**
     * @param $email
     * @param $password
     * @return User|null
     */
    public function userCreate($email, $password): ?User
    {
        $sth = $this->PDO->prepare("INSERT INTO `users` (`email`, `password`, `languageId`) VALUES (:email, :password, 1);");

        if ($sth->execute(['email' => $email, 'password' => crypt($password , SALT)])) {
            return (new User())
                ->setId($this->PDO->lastInsertId())
                ->setPassword($password)
                ->setEmail($email);
        }

        return null;
    }

    /**
     * @param $email
     * @param $languageId
     * @return bool
     */
    public function updateUserLanguage($email, $languageId): bool
    {
        var_dump($email, $languageId);
        $sth = $this->PDO->prepare("UPDATE `users` SET `languageId` = :languageId WHERE `email` = :email;");
        if ($sth->execute(['email' => $email, 'languageId' => $languageId])) {
            return true;
        }

        return false;
    }
}
