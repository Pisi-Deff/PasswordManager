<?php

abstract class Page {
    protected $get;
    protected $post;
    protected $cfg;

    public function __construct($get, $post, $cfg) {
        $this->get = $get;
        $this->post = $post;
        $this->cfg = $cfg;
    }

    abstract public function render();
}