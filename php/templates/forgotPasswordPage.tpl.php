<?php
namespace tpl;

require_once('centerContent.tpl.php');
require_once('textField.tpl.php');

function forgotPasswordPage() {
    $title = 'Forgot Password';

    $userField = textField("Username", "username", "");

    $centerContent = <<<ENDTPL
    
    <form method="POST">
        <div>
            This form can be used to reset your password if you've lost it.
            Enter your username in the field below.
            After submission, you will be sent an email with a link that will let you set a new password.
        </div>
        
        <br />
        
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                {$userField}
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
    
    <br />
    
ENDTPL;

    return centerContent($title, $centerContent);
}
