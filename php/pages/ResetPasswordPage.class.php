<?php

require_once dirname(__DIR__) . '/templates/resetPasswordPage.tpl.php';

class ResetPasswordPage extends Page {
    public function setup()
    {
        // TODO: Implement setup() method.
    }

    public function render() {
        return \tpl\resetPasswordPage();
    }

}