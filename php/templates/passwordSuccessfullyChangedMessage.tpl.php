<?php
namespace tpl;

require_once('centerContent.tpl.php');

function passwordSuccessfullyChangedMessage() {
    $title = 'Password Changed';

    $centerContent = <<<ENDTPL
    
    <p>Your password has been successfully changed.</p>
    <p>You may now return to the site and log in with your new password.</p>
    
ENDTPL;

    return centerContent($title, $centerContent);
}
