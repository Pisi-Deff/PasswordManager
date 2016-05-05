<?php

require '../../3rd_party/PHPMailer/PHPMailerAutoload.php';

class EmailSenderPHPMailer implements EmailSender {
    /**
     * @param Email $mail
     * @return bool|string
     */
    public function send($mail)
    {
        $mailer = new PHPMailer;
        //$mailer->SMTPDebug = 3; // Enable verbose debug output

        $mailer->Host = 'onyx.ttu.ee';
        $mailer->Port = 25;

        if (true) { // type smtp
            $mailer->isSMTP();

            //$mailer->SMTPSecure = 'tls'; // 'tls'/`ssl`

            if (true) { // do auth
                $mailer->SMTPAuth = false;
                //$mailer->Username = 'user@example.com';
                //$mailer->Password = 'secret';
            }
        }

        $mailer->setFrom($mail->getFrom(), $mail->getFromName());
        $mailer->addAddress($mail->getTo(), $mail->getToName());

        $mailer->isHTML(true);

        $mailer->Subject = $mail->getSubject();
        $mailer->Body    = $mail->getHTML();
        $mailer->AltBody = $mail->getText();

        if (!$mailer->send()) {
            return 'Mailer Error: ' . $mailer->ErrorInfo;
        }

        return true;
    }

}