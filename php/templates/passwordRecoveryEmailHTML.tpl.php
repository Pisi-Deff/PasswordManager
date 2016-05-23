<?php
namespace tpl;

require_once('emailHTMLBase.tpl.php');

function passwordRecoveryEmailHTML($siteName, $username, $recoveryURL) {
    $baseContent = <<<ENDTPL
    
    <p>Hello,</p>
    
    <p>
        A password recovery request was submitted on behalf of your user ${username}.
        Follow the link below to reset your password:
        <br />
        <a href="{$recoveryURL}">{$recoveryURL}</a>
    </p>
    
    <p>
        Please note that this link is only valid for 1 hour.
    </p>
    
    <p>
        If you did not submit this request, please ignore this email.
        Unless you follow the above link and set a new password, your current password will not be changed.
    </p>
    
    <p>
        NOTE: This is an automated e-mail. Please do not reply to it.
    </p>
    
    <p>
        Kind Regards,<br />
        {$siteName}
    </p>
    
ENDTPL;

    return emailHTMLBase($baseContent);
}
