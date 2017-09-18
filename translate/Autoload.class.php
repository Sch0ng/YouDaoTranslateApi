<?php

class Autoload
{
    const DIRECTORY_SEPARATOR = '/';
    private $base_path = '';

    public function __construct($base_path = '')
    {
        $this->base_path = $base_path;
        spl_autoload_register([$this, 'autoload']);
    }

    public static function register($base_path = '')
    {
        static $singleton = null;
        is_null($singleton) && $singleton = new self($base_path);
    }

    private function autoload($namespace)
    {
        $file_path = $this->getFile($namespace);

        if (file_exists($file_path)) {
            $this->requireOnce($file_path);
        } else {
            echo '文件：'.$file_path . '不存在' . PHP_EOL;
        }
    }

    private function getFile($namespace)
    {
        $base_path = $this->base_path;
        $namespace = explode('\\', $namespace);
        array_shift($namespace);
        $class_name = array_pop($namespace);

        if (empty($namespace)) {
            $path = $base_path;
        } else {
            $path = $base_path . self::DIRECTORY_SEPARATOR . implode(self::DIRECTORY_SEPARATOR, $namespace);
        }
        $file_path = $path . self::DIRECTORY_SEPARATOR . $class_name . '.class.php';
        return $file_path;
    }

    private function requireOnce($file_path)
    {
        static $files = [];
        if (!isset($files[$file_path])) {
            require $file_path;
            $files[$file_path] = 1;
        }
    }
}