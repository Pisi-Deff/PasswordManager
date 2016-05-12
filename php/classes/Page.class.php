<?php

abstract class Page {
    protected $get;
    protected $post;
    protected $cfg;
    protected $dbActions;

    /**
     * Page constructor.
     * @param array $get
     * @param array $post
     * @param array $cfg
     * @param DatabaseActions $dbActions
     */
    public function __construct($get, $post, $cfg, $dbActions) {
        $this->get = $get;
        $this->post = $post;
        $this->cfg = $cfg;
        $this->dbActions = $dbActions;
    }

    abstract public function render();
}