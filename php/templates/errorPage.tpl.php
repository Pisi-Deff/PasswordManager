<?php
namespace tpl;

require_once('centerContent.tpl.php');

function errorPage($error) {
    $title = 'Error';

    $centerContent = <<<ENDTPL
    
    <div class="row">
        <div class="col-xs-12 text-danger">
            {$error}
        </div>
        
    </div>
    <br />
    <div class="row">
        <div class="col-xs-12 backBtn">
            <a href="javascript:history.go(-1);">Click here to return to the previous page.</a>
        </div>
    </div>
    
ENDTPL;

    return centerContent($title, $centerContent);
}
