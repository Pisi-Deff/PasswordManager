<?php
namespace tpl;

require_once('centerContent.tpl.php');
require_once('newPasswordFields.tpl.php');

function resetPasswordPage($username, $minLength, $maxLength, $minEntropy) {
    $title = 'Reset Password';

    $newPassFields = newPasswordFields($minLength, $maxLength, $minEntropy);
    
    $centerContent = <<<ENDTPL
    
    <form method="POST" autocomplete="off">
        <span>By filling out this form, you will be able to reset your password to a new one.</span>
        <br />
        
        <h3>Resetting password for: {$username}</h3>
        
        {$newPassFields}
        
        <div class="row">
            <div class="col-xs-12 col-sm-6 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
    
ENDTPL;

    return centerContent($title, $centerContent);
}
