<?php

class Logger {

    protected static $instance;

    protected $uniqueID;
    protected $folder;

    /**
     * Logger constructor.
     * @param string $folder
     * @param string $uniqueID
     */
    private function __construct($uniqueID, $folder) {
        $this->uniqueID = $uniqueID;
        $this->folder = $folder;
    }

    public function log($message) {
        if ($this->folder == null) {
            return;
        }

        $message = date("\nH:i:s (T)") . '|' . $_SERVER['REMOTE_ADDR'] . '|> ' . $message;

        $filename = $this->folder . DIRECTORY_SEPARATOR
            . $this->uniqueID . '_' . date("Y-m-d") . '.log';
        file_put_contents($filename, $message, FILE_APPEND);
    }

    public function logPasswordChanged($username) {
        $this->log('User "' . $username . '" successfully changed their password.');
    }

    public function logPasswordChangeFailed($username) {
        $this->log('Failed password change attempt due to invalid password and/or username with username "' . $username . '".');
    }

    public function logPasswordResetInit($username) {
        $this->log('Password reset initiated for user "' . $username . '".');
    }

    public function logPasswordResetInitFailed($username) {
        $this->log('Password reset attempted for unknown user "' . $username . '".');
    }

    public function logPasswordResetFinished($username) {
        $this->log('Password reset successfully finished for user "' . $username . '".');
    }

    public function logPasswordResetInvalidKey() {
        $this->log('Attempt to reset password with invalid key.');
    }

    public function logDatabaseError($errMsg) {
        $this->log('Database error: ' . $errMsg);
    }

    public function logEmailError($errMsg) {
        $this->log('Mail error: ' . $errMsg);
    }

    /**
     * @param Exception $e
     */
    public function logUnhandledException($e) {
        $this->log('Unhandled exception: ' . $e->getMessage());
    }

    public static function init($cfg) {
        self::$instance = new Logger(
            $cfg['instanceIdentifier'], $cfg['logsFolder']);

        return self::$instance;
    }

    /**
     * @return Logger
     */
    public static function getInstance() {
        return self::$instance;
    }
}