<?php
namespace tpl;

function passwordRecoveryEmailText($username, $recoveryURL) {
    $siteName = ""; // TODO: from cfg

    return <<<ENDTPL
    
Hello ${username},

A password recovery request was submitted on behalf of your user.
Follow the link below to reset your password:
{$recoveryURL}

If you did not submit this request, please ignore this email.
Unless you follow the above link and set a new password, your current password will not be changed.

Kind Regards,
{$siteName}
    
ENDTPL;
}
