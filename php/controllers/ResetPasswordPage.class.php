<?php

require_once dirname(__DIR__) . '/templates/resetPasswordPage.tpl.php';

class ResetPasswordPage extends Page {
    public function render() {
        return \tpl\resetPasswordPage();
    }

}