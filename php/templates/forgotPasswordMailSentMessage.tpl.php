<?php
namespace tpl;

require_once('centerContent.tpl.php');

function forgotPasswordMailSentMessage() {
    $title = 'Forgot Password';

    $centerContent = <<<ENDTPL
    
    <div>An email with instructions has been sent to the email address attached to your account.</div>
    
ENDTPL;

    return centerContent($title, $centerContent);
}
