<?php

require_once dirname(__DIR__) . '/templates/changePasswordPage.tpl.php';
require_once dirname(__DIR__) . '/templates/passwordSuccessfullyChangedMessage.tpl.php';
require_once dirname(__DIR__) . '/templates/errorPage.tpl.php';

class ChangePasswordPage extends PageWithNewPasswords {
    public function render() {

        if ($this->isFormInputPresent()) {
            $username = trim($this->post['username']);
            $password = trim($this->post['password']);

            $pwErrors = $this->isNewPasswordSuitable();
            if (!count($pwErrors)) {
                if ($this->dbActions->authenticateUser($username, $password)) {
                    $newPass = $this->getNewPass();
                    $success = $this->dbActions->changeUserPassword($username, $newPass);
                    if ($success) {
                        Logger::getInstance()->logPasswordChanged($username);
                        return \tpl\passwordSuccessfullyChangedMessage();
                    } else {
                        return \tpl\errorPage('Unable to change password');
                    }
                } else {
                    Logger::getInstance()->logPasswordChangeFailed($username);
                    // lie to potential attacker
                    return \tpl\passwordSuccessfullyChangedMessage();
                }
            } else {
                return \tpl\errorPage('New password does not match strength rules');
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