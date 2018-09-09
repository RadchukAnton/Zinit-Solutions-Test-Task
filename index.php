<?php
/*/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 08.09.18
 * Time: 12:14
 */
error_reporting(E_ALL);
require_once 'vendor/autoload.php';


use Library\Request;
use Library\Config;
use Library\Router;

const DS   = DIRECTORY_SEPARATOR;
const ROOT = __DIR__ . DS;
const VIEW_DIR = ROOT . 'View' . DS;
const LIB_DIR = ROOT . 'Library' . DS;
const CONFIG_PATH = ROOT . 'Config' . DS;
const SALT = '5c58ec7d01c19e47195ed1fcf0ff076f';

spl_autoload_register(function ($className) {
    $file = ROOT . str_replace('\\', DS, $className).'.php';
    if(!file_exists($file)) {
        throw new \Exception("{$file}  not found", 500);
    }

    require($file);
});

try{
    session_start();
    Config::set('db_user', 'root');
    Config::set('db_pass', '');
    Config::set('db_name', 'test_task_db');
    Config::set('db_host', '127.0.0.1');

    $request = new Request();
    $router = new Router($request);
    $content = $router->init();

}catch (\Exception $e){
    echo $e->getMessage();
}

require VIEW_DIR . 'layout.php';



