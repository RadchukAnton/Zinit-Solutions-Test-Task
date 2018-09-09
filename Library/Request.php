<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 08.09.18
 * Time: 12:16
 */
namespace Library;

class Request
{
    private $get;
    private $post;
    private $server;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;

    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function post($key, $default = null)
    {
        return isset($this->post[$key]) ? $this->post[$key] : $default;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        if (!empty($this->server['REQUEST_URI'])) {
            return trim($this->server['REQUEST_URI'], '/');
        }
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */

    public function get($key, $default = null)
    {
        return isset($this->get[$key]) ? $this->get[$key] : $default;
    }

    /**
     * @return bool
     */
    public function isPost() : bool
    {
        return (bool)$this->post;
    }
}
