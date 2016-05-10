<?php

require_once '../../3rd_party/random_compat/lib/random.php';

class PasswordRecoveryKey {
    protected $key;
    protected $username;
    protected $ip;
    protected $timestamp;

    /**
     * Constructor is private to avoid being used from outside the class.
     *
     * Instead, use static functions
     * PasswordRecoveryKey::loadFromFile
     * or PasswordRecoveryKey::create
     */
    private function __construct() {}

    public function getKey()
    {
        return $this->key;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param DataStorage $dataStorage
     */
    protected function generateKey($dataStorage) {
        do {
            $this->key = self::generateRandomString(64);
        } while ($dataStorage->exists($this->key));
        // We ignore existing keys without even checking if they've timed out
        // because if they're present at all, it means they were recently in use.
        // TODO: add a max attempts count to avoid potential infinite loop
    }

    /**
     * @param DataStorage $dataStorage
     */
    public function save($dataStorage) {
        $content = array(
            'key' => $this->key,
            'username' => $this->username,
            'ip' => $this->ip,
            'timestamp' => $this->timestamp
        );
        return $dataStorage->create($this->key, $content);
    }

    /**
     * @param DataStorage $dataStorage
     * @param string $key
     */
    public static function load($dataStorage, $key) {
        $storedKey = $dataStorage->read($key);
        if ($storedKey === null) {
            return null;
        }
        
        $recKey = new PasswordRecoveryKey();

        $recKey->username = $storedKey['username'];
        $recKey->ip = $storedKey['ip'];
        $recKey->timestamp = $storedKey['timestamp'];
        $recKey->key = $key;

        return $recKey;
    }

    /**
     * @param DataStorage $dataStorage
     * @param string $username
     * @param string $ip
     */
    public static function create($dataStorage, $username, $ip) {
        $recKey = new PasswordRecoveryKey();

        $recKey->username = $username;
        $recKey->ip = $ip;
        $recKey->timestamp = time();
        $recKey->generateKey($dataStorage);

        return $recKey;
    }

    private static function generateRandomString(
        $length, $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_')
    {
        $string = '';
        $max = mb_strlen($chars, '8bit') - 1;
        for ($i = 0; $i <= $length; $i++) {
            $string .= $chars[random_int(0, $max)];
        }
        return $string;
    }
}