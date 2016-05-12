<?php

require_once dirname(__DIR__) . '/../3rd_party/random_compat/lib/random.php';

define('HASH_BCRYPT_ROUNDS', 12);
define('HASH_SHA256_ROUNDS', 200000);
define('HASH_SHA512_ROUNDS', 200000);

class PasswordHasher {
    private static $supportedAlgorithms = array('bcrypt', 'sha256', 'sha512');

    protected $hashMethod;

    /**
     * PasswordHasher constructor.
     * @param string $hashMethod
     */
    public function __construct($hashMethod)
    {
        if (!self::isHashMethodSupported($hashMethod)) {
            die('Hash method not supported: ' . $hashMethod);
        }
        $this->hashMethod = $hashMethod;
    }

    public static function isHashMethodSupported($hashMethod) {
        return in_array($hashMethod, self::$supportedAlgorithms);
    }

    /**
     * Checks whether the provided password matches the provided hash.
     *
     * Note: this function does not use the $hashMethod. Instead, it uses whatever hash method
     * was used to hash the provided hashString.
     *
     * @param $password
     * @param $hashString
     * @return bool
     */
    public function checkPassword($password, $hashString) {
        $newHash = crypt($password, $hashString);
        return hash_equals($hashString, $newHash);
    }

    public function hashPassword($password) {
        return crypt($password, $this->generateSaltString());
    }

    public function generateSaltString() {
        // doesn't matter if it's longer than the algorithm expects, will just be trimmed.
        $salt = bin2hex(random_bytes(32));
        switch ($this->hashMethod) {
            case 'bcrypt':
                $rounds = str_pad(HASH_BCRYPT_ROUNDS, 2, '0', STR_PAD_LEFT);
                $type = '$2y$';
                if (PHP_VERSION_ID < 50307) {
                    $type = "$2a$";
                }
                return $type . $rounds . '$' . $salt . '$';
            case 'sha256':
                return '$5$rounds=' . HASH_SHA256_ROUNDS . '$' . $salt . '$';
            case 'sha512':
                return '$6$rounds=' . HASH_SHA512_ROUNDS . '$' . $salt . '$';
        }
    }
}

if(!function_exists('hash_equals')) {
    function hash_equals($str1, $str2) {
        if (strlen($str1) != strlen($str2)) {
            return false;
        } else {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--) {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
    }
}