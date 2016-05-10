<?php
namespace tpl;

require_once('centerContent.tpl.php');

function errorPage($error) {
    $title = 'Error';

    $centerContent = <<<ENDTPL
    
    <div class="row">
        <div class="col-xs-12 col-sm-6 text-center text-danger">
            {$error}
        </div>
    </div>
    
ENDTPL;

    return centerContent($title, $centerContent);
}
