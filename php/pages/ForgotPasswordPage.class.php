<?php

require_once dirname(__DIR__) . '/templates/forgotPasswordPage.tpl.php';

class ForgotPasswordPage extends Page {
    public function setup()
    {
        // TODO: Implement setup() method.
    }

    public function render() {
        return \tpl\forgotPasswordPage();
    }

}