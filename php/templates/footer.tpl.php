<?php
namespace tpl;

function footer() {
    $ver = \VERSION;

    return <<<ENDTPL
    
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-6">
                    <small>Powered by magic</small>
                </div>
                <div class="col-xs-6 text-right">
                    <small>Password Manager {$ver}</small>
                </div>
            </div>
        </div>
    </div>
    
ENDTPL;
}
