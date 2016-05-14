<?php

require_once dirname(__DIR__) . '/templates/changePasswordPage.tpl.php';

class ChangePasswordPage extends PageWithNewPasswords {
    public function render() {

        if ($this->isFormInputPresent()) {
            $username = trim($this->post['username']);
            $password = trim($this->post['password']);

            if ($this->dbActions->authenticateUser($username, $password)) {
                if ($this->isNewPasswordSuitable()) {
                    $newPass = $this->getNewPass();
                    $success = $this->dbActions->changeUserPassword($username, $newPass);
                    if ($success) {
                        return \tpl\passwordSuccessfullyChangedMessage();
                    } else {
                        // TODO: error
                    }
                } else {
                    // TODO: error
                }
            } else {
                // TODO: error
            }
        }
        
        return \tpl\changePasswordPage();
    }

    private function isFormInputPresent() {
        return
            isset($this->post['username'])
            && isset($this->post['password'])
            && isset($this->post['newpass1'])
            && isset($this->post['newpass2']);
    }
}