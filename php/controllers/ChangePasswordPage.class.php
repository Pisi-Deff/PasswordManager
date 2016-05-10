<?php

require_once dirname(__DIR__) . '/templates/changePasswordPage.tpl.php';

class ChangePasswordPage extends Page {
    public function render() {
        return \tpl\changePasswordPage();
    }
}