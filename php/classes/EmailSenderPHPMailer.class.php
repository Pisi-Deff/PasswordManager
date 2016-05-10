<?php

require_once './EmailSender.class.php';
require_once '../../3rd_party/PHPMailer/PHPMailerAutoload.php';

class EmailSenderPHPMailer extends EmailSender {

    /**
     * @param Email $mail
     * @return bool|string
     */
    public function send($mail)
    {
        $mailer = new PHPMailer;
        //$mailer->SMTPDebug = 3; // Enable verbose debug output

        $mailer->Host = $this->emailSettings['host'];
        if ($this->emailSettings['port']) {
            $mailer->Port = $this->emailSettings['port'];
        }

        if ($this->emailSettings['type'] === 'smtp') {
            $mailer->isSMTP();
            if ($this->emailSettings['encryption']) {
                $mailer->SMTPSecure = $this->emailSettings['encryption'];
            }

            if ($this->emailSettings['useAuthentication']) {
                $mailer->SMTPAuth = true;
                $mailer->Username = $this->emailSettings['authUsername'];
                $mailer->Password = $this->emailSettings['authPassword'];
            }
        }

        $mailer->setFrom($mail->getFrom(), $mail->getFromName());
        $mailer->addAddress($mail->getTo(), $mail->getToName());

        $mailer->isHTML(true);

        $mailer->Subject = $mail->getSubject();
        $mailer->Body    = $mail->getHTML();
        $mailer->AltBody = $mail->getText();

        if (!$mailer->send()) {
            // TODO: log error
            return 'Mailer Error: ' . $mailer->ErrorInfo;
        }

        return true;
    }

}