<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 08.09.18
 * Time: 20:16
 */

namespace Library;


/**
 * Class Controller
 * @package Library
 */
class Controller
{
    use AuthChecker;

    /**
     * @var $request Request
     */
    protected $request;

    /**
     * @param mixed $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @param $view
     * @param array $args
     * @return false|string
     * @throws \Exception
     */
    protected function render($view, array $args = [])
    {
        extract($args);
        $classname = str_replace(['Controller', '\\'], '',static::class);
        $file = VIEW_DIR . $classname . DS . $view .'.php';
        if(!file_exists($file)){
            throw new \Exception("Template {$file} not found");
        }

        ob_start();
        require $file;
        return ob_get_clean();
    }

}