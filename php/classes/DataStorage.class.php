<?php

abstract class DataStorage {

    protected $prefix;

    /**
     * DataStorage constructor.
     * @param string $prefix
     */
    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @param string $key Must be alphanumeric without whitespace.
     * @param mixed $content Content to be stored. Must be serializable into json.
     * @return boolean
     */
    public function create($key, $content) {
        if ($this->isValidKey($key)) {
            return $this->_create($key, $content);
        }
        return false;
    }

    /**
     * @param string $key
     * @return array
     */
    public function read($key) {
        if ($this->isValidKey($key)) {
            return $this->_read($key);
        }
        return null;
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function exists($key) {
        if ($this->isValidKey($key)) {
            return $this->_exists($key);
        }
        return false;
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function delete($key) {
        if ($this->isValidKey($key) && $this->_exists($key)) {
            return $this->_delete($key);
        }
        return false;
    }

    /**
     * @param string $key Must be alphanumeric without whitespace.
     * @param mixed $content Content to be stored. Must be serializable into json.
     * @return boolean
     */
    abstract protected function _create($key, $content);
    /**
     * @param string $key
     * @return array
     */
    abstract protected function _read($key);
    /**
     * @param string $key
     * @return boolean
     */
    abstract protected function _exists($key);
    /**
     * @param string $key
     * @return boolean
     */
    abstract protected function _delete($key);

    /**
     * @param string $key
     * @return boolean
     */
    protected function isValidKey($key) {
        return preg_match("/^[a-zA-Z0-9_-]+$/", $key) === 1;
    }
}