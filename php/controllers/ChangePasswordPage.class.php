<?php

require_once dirname(__DIR__) . '/templates/changePasswordPage.tpl.php';
require_once dirname(__DIR__) . '/templates/errorPage.tpl.php';

class ChangePasswordPage extends PageWithNewPasswords {
    public function render() {

        if ($this->isFormInputPresent()) {
            $username = trim($this->post['username']);
            $password = trim($this->post['password']);

            if ($this->dbActions->authenticateUser($username, $password)) {
                $pwErrors = $this->isNewPasswordSuitable();
                if (!count($pwErrors)) {
                    $newPass = $this->getNewPass();
                    $success = $this->dbActions->changeUserPassword($username, $newPass);
                    if ($success) {
                        Logger::getInstance()->logPasswordChanged($username);
                        return \tpl\passwordSuccessfullyChangedMessage();
                    } else {
                        return \tpl\errorPage('Unable to change password');
                    }
                } else {
                    return \tpl\errorPage('New password does not match strength rules');
                }
            } else {
                Logger::getInstance()->logPasswordChangeFailed($username);
                return \tpl\errorPage('Invalid username and/or current password');
            }
        }
        
        return \tpl\changePasswordPage($this->cfg['pw_minLength'],
            $this->cfg['pw_maxLength'], $this->cfg['pw_minEntropyBits']);
    }

    private function isFormInputPresent() {
        return
            isset($this->post['username'])
            && isset($this->post['password'])
            && isset($this->post['newpass1'])
            && isset($this->post['newpass2']);
    }
}