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

    public function _create($key, $content) {
        $content = json_encode($content);
        $fileName = $this->makeFilePath($key);
        $success = file_put_contents($fileName, $content) !== false;
        chmod($fileName, 0600); // RW for owner
        return $success;
    }

    public function _read($key) {
        $fileName = $this->makeFilePath($key);
        
        if (file_exists($fileName)) {
            $content = file_get_contents($fileName);
            if ($content !== false && strlen($content) > 0) {
                return json_decode($content, true);
            }
        }

        return null;
    }

    public function _exists($key) {
        $fileName = $this->makeFilePath($key);
        return is_readable($fileName);
    }

    public function _delete($key)
    {
        $fileName = $this->makeFilePath($key);
        return unlink($fileName);
    }

    private function makeFilePath($key) {
        return $this->folder . \APPID . '_' . $this->prefix . '_' . $key;
    }
}