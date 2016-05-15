<?php

abstract class PageWithNewPasswords extends Page {
    /**
     * @var PasswordStrengthCalculator
     */
    protected $passwordEntropyCalculator;

    public function __construct($get, $post, $cfg, $dbActions)
    {
        parent::__construct($get, $post, $cfg, $dbActions);
        $this->passwordEntropyCalculator = new PasswordStrengthCalculator($cfg);
    }

    protected function getNewPass() {
        return trim($this->post['newpass1']);
    }

    protected function isNewPasswordSuitable() {
        $newPass1 = trim($this->post['newpass1']);
        $newPass2 = trim($this->post['newpass2']);

        return $this->passwordEntropyCalculator->validateNewPassword($newPass1, $newPass2);
    }
}