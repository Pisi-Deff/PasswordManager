<?php

abstract class Page {
    private static $messages = array();

    protected $get;
    protected $post;

    public function __construct($get, $post) {
        $this->get = $get;
        $this->post = $post;
        $this->setup();
    }

    public function getMessages() {
        $result = '';
        if (!empty(self::$messages)) {
            foreach (self::$messages as $msg) {
                $result .= $msg->toHTML();
            }
        }
        return $result;
    }

    public static function addMessage($msg) {
        self::$messages[] = $msg;
    }

    abstract public function setup();

    abstract public function render();
}