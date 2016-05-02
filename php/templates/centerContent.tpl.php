<?php
namespace tpl;

require_once('base.tpl.php');
require_once('footer.tpl.php');

function centerContent($title, $content) {
    $footer = footer();

    $baseContent = <<<ENDTPL
    
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <br /><br /><br />
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h1>{$title}</h1>
    
                        {$content}
                    </div>
                </div>
                
                {$footer}
            </div>
        </div>
    </div>
    
ENDTPL;

    return base($title, $baseContent);
}
