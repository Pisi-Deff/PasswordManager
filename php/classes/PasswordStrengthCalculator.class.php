<?php

class PasswordStrengthCalculator {
    /**
     * @var array
     */
    protected $cfg;

    /**
     * PasswordStrengthCalculator constructor.
     * @param array $cfg
     */
    public function __construct(array $cfg)
    {
        $this->cfg = $cfg;
    }

    public function validateNewPassword($pass1, $pass2) {
        $errors = array();

        $minLength = $this->cfg['pw_minLength'];
        $maxLength = $this->cfg['pw_maxLength'];
        $minBits = $this->cfg['pw_minEntropyBits'];

        if ($pass1 !== $pass2) {
            $errors[] = 'noMatch';
        }
        if (strlen($pass1) < $minLength) {
            $errors[] = 'tooShort';
        }
        if ($maxLength && strlen($pass1) > $maxLength) {
            $errors[] = 'tooLong';
        }
        if ($this->calculateEntropyBits($pass1) < $minBits) {
            $errors[] = 'lackingEntropy';
        }

        return $errors;
    }

    public function calculateEntropyBits($password) {
        $entropy = 0.0;
        $size = strlen($password);

        foreach (count_chars($password, 1) as $v) {
            $p = $v / $size;
            $entropy -= $p * log($p, 2);
        }

        $entropy = ceil($entropy);

        return $entropy * $size;
    }

    public function decidePasswordStrength($entropyBits) {
        $minEntropy = $this->cfg['pw_minEntropyBits'];
        $strongEntropy = $this->cfg['pw_strongEntropyBits'];

        if ($entropyBits >= $strongEntropy) {
            return 'strong';
        } else if ($entropyBits >= $minEntropy) {
            return 'min';
        }
        return 'bad';
    }
}