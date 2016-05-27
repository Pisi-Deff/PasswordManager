<?php

require_once dirname(__DIR__) . '/templates/errorPage.tpl.php';
require_once dirname(__DIR__) . '/templates/forgotPasswordPage.tpl.php';
require_once dirname(__DIR__) . '/templates/forgotPasswordMailSentMessage.tpl.php';
require_once dirname(__DIR__) . '/templates/passwordRecoveryEmailSubject.tpl.php';
require_once dirname(__DIR__) . '/templates/passwordRecoveryEmailText.tpl.php';
require_once dirname(__DIR__) . '/templates/passwordRecoveryEmailHTML.tpl.php';

class ForgotPasswordPage extends Page {
    /**
     * @var EmailSenderPHPMailer
     */
    protected $mailer;
    /**
     * @var DataStorage
     */
    protected $recoveryKeyStorage;

    public function __construct($get, $post, $cfg, $dbActions) {
        parent::__construct($get, $post, $cfg, $dbActions);
        
        $emailSettings = array(
            'host' => $cfg['email_host'],
            'port' => $cfg['email_port'],
            'type' => $cfg['email_type'],
            'encryption' => $cfg['email_encryption'],
            'useAuthentication' => $cfg['email_useAuthentication'],
            'authUsername' => $cfg['email_authUsername'],
            'authPassword' => $cfg['email_authPassword']
        );
        
        $this->mailer = new EmailSenderPHPMailer($emailSettings);
        $this->recoveryKeyStorage = new TempFileStorage($this->cfg['instanceIdentifier']);
    }

    public function render() {
        // TODO: add limit checking
        if (isset($this->post['username'])) {
            $username = trim($this->post['username']);

            if (!(strlen($username))) {
                return \tpl\errorPage('Please enter your username');
            }

            $email = $this->dbActions->getUserEmail($username);

            if ($email) {
                $recoveryKey = PasswordRecoveryKey::create(
                    $this->recoveryKeyStorage, $username, $_SERVER['REMOTE_ADDR']);
                $recoveryURL = $this->generateRecoveryURL($recoveryKey);
                $recoveryKey->save($this->recoveryKeyStorage);

                $settings = array(
                    'from' => $this->cfg['email_mailerAddress'],
                    'fromName' => $this->cfg['applicationName'],
                    'to' => $email,
                    'toName' => $username,

                    'subject' => \tpl\passwordRecoveryEmailSubject($this->cfg['applicationName'], $username),
                    'html' => \tpl\passwordRecoveryEmailHTML($this->cfg['applicationName'], $username, $recoveryURL),
                    'text' => \tpl\passwordRecoveryEmailText($this->cfg['applicationName'], $username, $recoveryURL)
                );
                $mail = new Email($settings);

                if ($this->mailer->send($mail)) {
                    Logger::getInstance()->logPasswordResetInit($username);
                    return \tpl\forgotPasswordMailSentMessage();
                } else {
                    return \tpl\errorPage('Failed to send email.');
                }
            } else {
                Logger::getInstance()->logPasswordResetInitFailed($username);
                // user not found... but may as well lie to an attacker
                return \tpl\forgotPasswordMailSentMessage();
            }
        }

        return \tpl\forgotPasswordPage();
    }

    /**
     * @param PasswordRecoveryKey $recoveryKey
     * @return string
     */
    private function generateRecoveryURL($recoveryKey) {
        $usingHTTPS =
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443;

        $url = $usingHTTPS ? 'https://' : 'http://';
        $url .= $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
        $url .= '?page=ResetPassword&key=' . $recoveryKey->getKey();
        
        return $url;
    }

}