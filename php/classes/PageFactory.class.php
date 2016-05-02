<?php

class PageFactory {
    protected $defaultPageName;

    public function __construct($defaultPageName)
    {
        $this->defaultPageName = $defaultPageName;
    }

    /**
     * @param $get
     * @param $post
     * @return Page
     */
    public function getPage($get, $post) {
        $page = null;
        $pageName = null;

        if (!empty($get['page'])) {
            $pageName = $get['page'] . 'Page';
        }

        if ($pageName !== null && class_exists($pageName)) {
            $page = new $pageName($get, $post);
        }
        if ($page === null) {
            $page = new $this->defaultPageName($get, $post);
        }

        return $page;
    }
}
