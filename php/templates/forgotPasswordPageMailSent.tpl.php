<?php
namespace tpl;

require_once('centerContent.tpl.php');
require_once('textField.tpl.php');

function forgotPasswordPageMailSent() {
    $title = 'Forgot Password';

    $centerContent = <<<ENDTPL
    
    <form method="POST">
        <div>
            An email with instructions has been sent to the email address attached to your account.
        </div>
    </form>
    
    <br />
    
ENDTPL;

    return centerContent($title, $centerContent);
}
