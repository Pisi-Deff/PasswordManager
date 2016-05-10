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
    abstract public function create($key, $content);
    /**
     * @param string $key
     * @return array
     */
    abstract public function read($key);
    /**
     * @param string $key
     * @return boolean
     */
    abstract public function exists($key);
}