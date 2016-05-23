<?php
namespace tpl;

function passwordRecoveryEmailText($siteName, $username, $recoveryURL) {
    return <<<ENDTPL
    
Hello,

A password recovery request was submitted on behalf of your user ${username}.
Follow the link below to reset your password:
{$recoveryURL}

Please note that this link is only valid for 1 hour.

If you did not submit this request, please ignore this email.
Unless you follow the above link and set a new password, your current password will not be changed.

NOTE: This is an automated e-mail. Please do not reply to it.

Kind Regards,
{$siteName}
    
ENDTPL;
}
