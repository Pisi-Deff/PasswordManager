<?php
namespace tpl;

function textField($label, $name, $value = "", $type = "text", $placeholder = null) {
    if ($placeholder === null) {
        $placeholder = $label;
    }

    return <<<ENDTPL
    
    <div class="form-group">
        <label for="{$name}" class="control-label">{$label}</label>
        <input id="{$name}" class="form-control" type="{$type}"
                name="{$name}" value="{$value}" placeholder="{$placeholder}" />
    </div>
    
ENDTPL;
}
