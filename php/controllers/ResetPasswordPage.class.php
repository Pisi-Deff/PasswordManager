<?php

require_once dirname(__DIR__) . '/templates/resetPasswordPage.tpl.php';
require_once dirname(__DIR__) . '/templates/passwordSuccessfullyChangedMessage.tpl.php';

define('RECOVERY_KEY_MAX_AGE', 1 * 24 * 60 * 60); // 1 day

class ResetPasswordPage extends PageWithNewPasswords {

    /**
     * @var DataStorage
     */
    protected $recoveryKeyStorage;
    
    public function __construct($get, $post, $cfg, $dbActions)
    {
        parent::__construct($get, $post, $cfg, $dbActions);
        $this->recoveryKeyStorage = new TempFileStorage($this->cfg['instanceIdentifier']);
    }

    public function render() {
        session_start();

        if (!isset($this->get['key'])) {
            return \tpl\errorPage('Invalid password recovery key.'); // TODO: better error
        }

        $sessionKey = \APPID . '_' . $this->cfg['instanceIdentifier'] . '_recoveryKey';
        $key = $this->get['key'];
        $recoveryKey = null;

        if (isset($_SESSION[$sessionKey])) {
            $recoveryKey = $_SESSION[$sessionKey];
        } else {
            $recoveryKey = PasswordRecoveryKey::load($this->recoveryKeyStorage, $key);
        }

        if ($recoveryKey === null
            || $recoveryKey->getKey() !== $key
            || $recoveryKey->getTimestamp() + RECOVERY_KEY_MAX_AGE < time()) {

            $_SESSION[$sessionKey] = null;
            
            return \tpl\errorPage('Password recovery key has expired or is invalid.'); // TODO: better error
        }

        if ($recoveryKey->getIp() !== $_SERVER['REMOTE_ADDR']) { // TODO: have this as a config setting
            $_SESSION[$sessionKey] = null;
            
            return \tpl\errorPage('Current IP does not match the one that the password recovery request was initiated with.'); // TODO: better error
        }

        if ($this->isFormInputPresent()) {
            if ($this->isNewPasswordSuitable()) {
                $newPass = $this->getNewPass();
                $success = $this->dbActions->changeUserPassword($recoveryKey->getUsername(), $newPass);
                if ($success) {
                    $recoveryKey->delete($this->recoveryKeyStorage);
                    $_SESSION[$sessionKey] = null;
                    
                    return \tpl\passwordSuccessfullyChangedMessage();
                } else {
                    // TODO: error
                }
            }
        } else {
            $_SESSION[$sessionKey] = $recoveryKey;
        }

        return \tpl\resetPasswordPage($recoveryKey->getUsername());
    }

    private function isFormInputPresent() {
        return
            isset($this->post['newpass1'])
            && isset($this->post['newpass2']);
    }

}