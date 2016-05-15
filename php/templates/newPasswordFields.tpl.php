<?php
namespace tpl;

require_once('passwordField.tpl.php');

function newPasswordFields($minLength, $maxLength, $minEntropy) {

    $newPassField1 = passwordField("New password", "newpass1");
    $newPassField2 = passwordField("Repeat new password", "newpass2");

    $passwordRules = passwordRule('new passwords match', 'match');
    $passwordRules .= passwordRule('is at least ' . $minLength . ' characters long', 'tooShort');
    if ($maxLength) {
        $passwordRules .= passwordRule('is up to ' . $maxLength . ' characters long', 'tooLong');
    }
    $passwordRules .= passwordRule('has a strength of at least ' . $minEntropy . ' bits', 'lackingEntropy');

    return <<<ENDTPL
    
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            {$newPassField1}
            
            <div class="form-group">
                <label class="control-label">
                    Strength:
                    <strong>
                        <span class="pwStrengthLabel pwStrengthLabelBad shown"
                                data-strength="bad">Bad</span>
                        <span class="pwStrengthLabel pwStrengthLabelOk"
                                data-strength="min">Okay</span>
                        <span class="pwStrengthLabel pwStrengthLabelGood"
                                data-strength="strong">Good</span>
                    </strong>
                </label>
                <br />
                <small>
                    <span class="pwStrengthBits">0</span>
                    <span> estimated bits of entropy</span>
                    <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip"
                        data-placement="top" title="An estimation of entropy based on Shannon entropy"></span>
                </small>
                <small class="dictionaryEntropyBlock">
                    <span class="pwStrengthBitsDictionary">0</span>
                    <span> bits of entropy against dictionary attack </span>
                    <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip"
                        data-placement="top"
                        title="Based on the size of the dictionary and the number of words picked"></span>
                </small>
            </div>
            
            
            <div class="form-group text-center">
                <button type="button" class="genPassBtn btn btn-default"
                    data-loading-text="Generating...">Generate strong password</button>
            </div>
            
            {$newPassField2}
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="well">
                <h4>The new password must match the following rules:</h4>
                
                <div class="pwStrengthItems">
                    {$passwordRules}
                </div>
            </div>
        </div>
    </div>
    
ENDTPL;
}

function passwordRule($text, $id) {
    return <<<ENDTPL

    <div class="pwStrengthItem invalid" data-id="{$id}">
        <span class="glyphicon glyphicon-remove"></span>
        <span class="glyphicon glyphicon-ok"></span>
        <span>{$text}</span>
    </div>

ENDTPL;
}
