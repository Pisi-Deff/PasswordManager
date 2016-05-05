<?php
namespace tpl;

require_once('emailHTMLBase.tpl.php');

function passwordRecoveryEmailHTML($username, $recoveryURL) {
    $siteName = ""; // TODO: from cfg

    $baseContent = <<<ENDTPL
    
    <p>Hello ${username},</p>
    
    <p>
        A password recovery request was submitted on behalf of your user.
        Follow the link below to reset your password:
        <a href="{$recoveryURL}">{$recoveryURL}</a>
    </p>
    
    <p>
        If you did not submit this request, please ignore this email.
        Unless you follow the above link and set a new password, your current password will not be changed.
    </p>
    
    <p>
        Kind Regards,
        {$siteName}
    </p>
    
ENDTPL;

    return emailHTMLBase($baseContent);
}
