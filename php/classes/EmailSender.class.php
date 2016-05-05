<?php

interface EmailSender {
    /**
     * @param Email $mail
     * 
     * @return bool|string
     */
    public function send($mail);
}