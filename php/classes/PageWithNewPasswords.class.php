<?php

abstract class PageWithNewPasswords extends Page {
    /**
     * @var PasswordEntropyCalculator
     */
    protected $passwordEntropyCalculator;

    public function __construct($get, $post, $cfg, $dbActions)
    {
        parent::__construct($get, $post, $cfg, $dbActions);
        $this->passwordEntropyCalculator = new PasswordEntropyCalculator();
    }

    protected function getNewPass() {
        return trim($this->post['newpass1']);
    }

    protected function isNewPasswordSuitable() {
        $newPass1 = trim($this->post['newpass1']);
        $newPass2 = trim($this->post['newpass2']);

        $minLength = $this->cfg['pw_minLength'];
        $maxLength = $this->cfg['pw_maxLength'];
        $minBits = $this->cfg['pw_minEntropyBits'];

        return $newPass1 === $newPass2
        &&
        (strlen($newPass1) >= $minLength)
        &&
        ($maxLength === 0 || strlen($newPass1) <= $maxLength)
        &&
        ($minBits === 0 || $this->passwordEntropyCalculator->calculate($newPass1) > $minBits);
    }
}