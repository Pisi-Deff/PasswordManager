<?php

class TempFileStorage extends DataStorage {
    protected $folder;
    protected $prefix;

    /**
     * TempFileStorage constructor.
     * @param string $prefix
     */
    public function __construct($prefix)
    {
        parent::__construct($prefix);
        $this->folder = sys_get_temp_dir() . DIRECTORY_SEPARATOR;
    }

    public function create($name, $content) {
        $content = json_encode($content);
        $fileName = $this->makeFilePath($name);
        file_put_contents($fileName, $content);
    }

    public function read($name) {
        $fileName = $this->makeFilePath($name);
        $content = file_get_contents($fileName);
        if ($content !== false && strlen($content) > 0) {
            return json_decode($content, true);
        }

        return null;
    }

    public function exists($name) {
        $fileName = $this->makeFilePath($name);
        return is_readable($fileName);
    }

    private function makeFilePath($name) {
        return $this->folder . \APPID . '_' . $this->prefix . '_' . $name;
    }
}