<?php
namespace tpl;

function passwordField($label, $name, $placeholder = null) {
    if ($placeholder === null) {
        $placeholder = $label;
    }

    return <<<ENDTPL
    
    <div class="form-group">
        <label for="{$name}" class="control-label">{$label}</label>
        <div class="input-group">
            <input id="{$name}" class="form-control" type="password"
                    name="{$name}" placeholder="{$placeholder}" />
            <span class="passwordMaskBtn masked input-group-addon">
                <span class="glyphicon glyphicon-eye-open"></span>
                <span class="glyphicon glyphicon-eye-close"></span>
            </span>
        </div>
    </div>
    
ENDTPL;
}
