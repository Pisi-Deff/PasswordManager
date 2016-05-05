<?php

class Email {
    protected $from;
    protected $fromName;
    protected $to;
    protected $toName;

    protected $subject;
    protected $html;
    protected $text;

    /**
     * Email constructor.
     *
     * The settings variable should contain the following keys:
     * * from - the email address of the sender
     * * fromName - the name of the sender
     * * to - the email address of the recipient
     * * toName - the name of the recipient
     * * subject - subject of the email
     * * html - html version of the email body
     * * text - plaintext version of the email body
     *
     * @param $settings
     */
    public function __construct($settings) {
        $this->from = $settings['from'];
        $this->fromName = $settings['fromName'];
        $this->to = $settings['to'];
        $this->toName = $settings['toName'];

        $this->subject = $settings['subject'];
        $this->html = $settings['html'];
        $this->text = $settings['text'];
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getFromName()
    {
        return $this->fromName;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getToName()
    {
        return $this->toName;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getHTML()
    {
        return $this->html;
    }

    public function getText()
    {
        return $this->text;
    }
}