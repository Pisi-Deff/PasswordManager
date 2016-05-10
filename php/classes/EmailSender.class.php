<?php

abstract class EmailSender {

    protected $emailSettings;

    /**
     * EmailSender constructor.
     * @param array $emailSettings
     */
    public function __construct($emailSettings)
    {
        $this->emailSettings = $emailSettings;
    }


    /**
     * @param Email $mail
     * @return bool|string
     */
    abstract public function send($mail);
}