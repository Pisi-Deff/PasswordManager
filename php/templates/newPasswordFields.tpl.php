<?php
namespace tpl;

function newPasswordFields() {

    $newPassField1 = textField("New password", "newpass1", "", "password");
    $newPassField2 = textField("Repeat new password", "newpass2", "", "password");

    return <<<ENDTPL
    
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            {$newPassField1}
            
            <div class="form-group">
                <label class="control-label">Password strength:</label>
                <br />
                <strong>
                    <span class="pwStrengthLabel pwStrengthLabelBad">Bad</span>
                    <span class="pwStrengthLabel pwStrengthLabelOk">Okay</span>
                    <span class="pwStrengthLabel pwStrengthLabelGood">Good</span>
                </strong>
                <span>(</span>
                <span class="pwStrengthBits"></span>
                <span> bits of entropy</span>
                <span class="glyphicon glyphicon-question-sign"></span>
                <span>)</span>
            </div>
            
            <div class="form-group text-center">
                <button type="button" class="btn btn-default">Generate strong password</button>
            </div>
            
            {$newPassField2}
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="well">
                <h4>The new password must match the following rules:</h4>
                
                <div class="pwStrengthItems">
                    <span class="text-danger">X is at least 10 characters long</span>
                </div>
            </div>
        </div>
    </div>
    
ENDTPL;
}
