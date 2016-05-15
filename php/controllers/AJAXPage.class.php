<?php

class AJAXPage extends Page {
    /**
     * @var PasswordGenerator
     */
    protected $passGenerator;
    /**
     * @var PasswordStrengthCalculator
     */
    protected $passStrength;

    public function __construct($get, $post, $cfg, $dbActions) {
        parent::__construct($get, $post, $cfg, $dbActions);

        $this->passGenerator = new PasswordGenerator($cfg);
        $this->passStrength = new PasswordStrengthCalculator($cfg);
    }

    public function render() {
        header('Content-Type: application/json');
        
        if (!isset($this->get['action']) || !strlen($this->get['action'])) {
            return 'null';
        }

        $action = $this->get['action'];
        $response = array();

        switch ($action) {
            case 'genpass':
                $response['password'] = $this->passGenerator->generate();
                $response['dictEntropyBits'] = $this->passGenerator->getEntropy();
                $response['entropyBits'] =
                    $this->passStrength->calculateEntropyBits($response['password']);
                $response['strength'] =
                    $this->passStrength->decidePasswordStrength($response['entropyBits']);
                $response['matchErrors'] =
                    $this->passStrength->validateNewPassword($response['password'], '');
                break;
            case 'checkpass':
                $password = $this->post['password'];
                $response['entropyBits'] =
                    $this->passStrength->calculateEntropyBits($password);
                $response['strength'] =
                    $this->passStrength->decidePasswordStrength($response['entropyBits']);
                $response['matchErrors'] =
                    $this->passStrength->validateNewPassword($password, '');
                break;
        }

        return json_encode($response);
    }
}