<?php
namespace tpl;

function passwordRecoveryEmailSubject($siteName, $username) {
    return "Password recovery for user ${username} at ${siteName}";
}
