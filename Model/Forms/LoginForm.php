<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 09.09.18
 * Time: 13:10
 */
namespace Model\Forms;

/**
 * Class LoginForm
 * @package Model\Forms
 */
class LoginForm
{
    public $email;
    public $password;

    public function __construct($email, $password)
    {
        $this->email = $this->secure($email);
        $this->password = $this->secure($password);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function secure($data)
    {
       strip_tags($data);
       htmlentities($data, ENT_QUOTES, "UTF-8");
       htmlspecialchars($data, ENT_QUOTES);

       return $data;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isValid()
    {
        if (!empty($this->email) && !empty($this->password) && $this->csfrProtection() && $this->isEmail($this->email)) {
            return true;
        }

        return false;
    }

    /**
     * @param $email
     * @return mixed
     */
    public function isEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL );
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function csfrProtection(): bool
    {
        if (empty($_SESSION['key'])) {
            $_SESSION['key'] = bin2hex(random_bytes(32));
        }

        $csrf = hash_hmac('sha256', 'test', $_SESSION['key']);
        $_SESSION['csrf'] = $csrf;

        if (isset($_POST['submit'])) {
            if (hash_equals($csrf, $_POST['csrf'])) {
                return true;
            } else {
                return false;
            }
        }
    }
}