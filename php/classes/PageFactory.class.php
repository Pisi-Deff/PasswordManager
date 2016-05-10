<?php

class PageFactory {
    protected $defaultPageName;

    public function __construct($defaultPageName)
    {
        $this->defaultPageName = $defaultPageName;
    }

    /**
     * @param array $get
     * @param array $post
     * @param array $cfg
     * @return Page
     */
    public function getPage($get, $post, $cfg) {
        $pageName = null;

        if (!empty($get['page'])) {
            $pageName = $get['page'] . 'Page';
        }

        if ($pageName === null || !class_exists($pageName)) {
            $pageName = $this->defaultPageName;
        }

        return new $pageName($get, $post, $cfg);
    }
}
