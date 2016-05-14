<?php
namespace tpl;

require_once('centerContent.tpl.php');

function passwordSuccessfullyChangedMessage() {
    $title = 'Password Changed';

    $centerContent = <<<ENDTPL
    
    <div>Your password has been successfully changed.</div>
    
ENDTPL;

    return centerContent($title, $centerContent);
}
