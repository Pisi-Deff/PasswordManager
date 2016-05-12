<?php

class DatabaseActions {
    protected $cfg;
    protected $db;
    protected $pwHasher;

    /**
     * DatabaseActions constructor.
     * @param DatabaseConnection $db
     * @param array $cfg
     */
    public function __construct($cfg) {
        $this->cfg = $cfg;
        $this->db = new DatabaseConnection(
            $cfg['db_type'],
            $cfg['db_host'],
            $cfg['db_port'],
            $cfg['db_user'],
            $cfg['db_password'],
            $cfg['db_database']
        );
        $this->pwHasher = new PasswordHasher($cfg['db_passwordHashMethod']);
    }

    private function getConnection() {
        return $this->db->connect();
    }


    public function getUserEmail($username) {
        if ($this->cfg['db_useDBFunctions'] === true) {
            return $this->getUserEmailViaFunction($username);
        }
        return $this->getUserEmailDirectly($username);
    }

    private function getUserEmailDirectly($username) {
        if (!(self::stringHasValue($this->cfg['db_userTable'])
            && self::stringHasValue($this->cfg['db_emailColumn'])
            && self::stringHasValue($this->cfg['db_usernameColumn'])
        )) {
            // TODO: raise error
            return null;
        }

        $stmt = $this->getConnection()->createQueryBuilder()
            ->select($this->cfg['db_emailColumn'])
            ->from($this->cfg['db_userTable'])
            ->where($this->cfg['db_usernameColumn'] . ' = ?')
            ->setParameter(0, $username)
            ->execute();
        $email = $stmt->fetchColumn();

        return $email;
    }

    private function getUserEmailViaFunction($username) {
        if (!self::stringHasValue($this->cfg['db_getUserEmailFunction'])) {
            // TODO: raise error
            return null;
        }

        $sql = 'SELECT ' . $this->cfg['db_getUserEmailFunction'] . '(:username) FROM DUAL';
        $stmt = $this->getConnection()->executeQuery(
            $sql, array('username' => $username), array(PDO::PARAM_STR));

        $email = $stmt->fetchColumn();
        return $email;
    }


    public function authenticateUser($username, $password) {
        if ($this->cfg['db_useDBFunctions'] === true) {
            return $this->authenticateUserViaFunction($username, $password);
        }
        return $this->authenticateUserDirectly($username, $password);
    }

    private function authenticateUserDirectly($username, $password) {
        if (!(self::stringHasValue($this->cfg['db_userTable'])
            && self::stringHasValue($this->cfg['db_passwordColumn'])
            && self::stringHasValue($this->cfg['db_usernameColumn'])
        )) {
            // TODO: raise error
            return false;
        }

        $stmt = $this->getConnection()->createQueryBuilder()
            ->select($this->cfg['db_passwordColumn'])
            ->from($this->cfg['db_userTable'])
            ->where($this->cfg['db_usernameColumn'] . ' = ?')
            ->setParameter(0, $username)
            ->execute();
        $hash = $stmt->fetchColumn();
        var_dump($hash);

        return $this->pwHasher->checkPassword($password, $hash);
    }

    private function authenticateUserViaFunction($username, $password) {
        if (!self::stringHasValue($this->cfg['db_userAuthenticateFunction'])) {
            // TODO: raise error
            return false;
        }

        if ($this->cfg['db_useHashedPasswordForFunctions'] === true) {
            $password = $this->pwHasher->hashPassword($password);
        }

        $sql = 'SELECT ' . $this->cfg['db_userAuthenticateFunction'] . '(:username, :password) FROM DUAL';
        $stmt = $this->getConnection()->executeQuery(
            $sql, array(
                'username' => $username,
                'password' => $password
            ), array(
                'username' => PDO::PARAM_STR,
                'password' => PDO::PARAM_STR
            ));
        $result = $stmt->fetchColumn();

        return $result;
    }


    public function changeUserPassword($username, $newPassword) {
        if ($this->cfg['db_useDBFunctions'] === true) {
            return $this->changeUserPasswordViaFunction($username, $newPassword);
        }
        return $this->changeUserPasswordDirectly($username, $newPassword);
    }

    private function changeUserPasswordDirectly($username, $newPassword) {
        if (!(self::stringHasValue($this->cfg['db_userTable'])
                && self::stringHasValue($this->cfg['db_passwordColumn'])
                && self::stringHasValue($this->cfg['db_usernameColumn'])
            )) {
            // TODO: raise error
            return false;
        }

        $newHash = $this->pwHasher->hashPassword($newPassword);

        $affectedRows = $this->getConnection()->createQueryBuilder()
            ->update($this->cfg['db_userTable'])
            ->set($this->cfg['db_passwordColumn'], ':newHash')
            ->where($this->cfg['db_usernameColumn'] . ' = :username')
            ->setParameter('newHash', $newHash)
            ->setParameter('username', $username)
            ->execute();

        return $affectedRows > 0;
    }

    private function changeUserPasswordViaFunction($username, $newPassword) {
        if (!self::stringHasValue($this->cfg['db_changePasswordFunction'])) {
            // TODO: raise error
            return false;
        }

        if ($this->cfg['db_useHashedPasswordForFunctions'] === true) {
            $newPassword = $this->pwHasher->hashPassword($newPassword);
        }

        $sql = 'SELECT ' . $this->cfg['db_changePasswordFunction'] . '(:username, :password) FROM DUAL';
        $stmt = $this->getConnection()->executeQuery(
            $sql, array(
            'username' => $username,
            'password' => $newPassword
        ), array(
            'username' => PDO::PARAM_STR,
            'password' => PDO::PARAM_STR
        ));
        $result = $stmt->fetchColumn();

        return $result;
    }


    public function raisePasswordChangedEvent($username) {
        if (!self::stringHasValue($this->cfg['db_passwordChangedEventFunction'])) {
            return;
        }

        $sql = 'SELECT ' . $this->cfg['db_passwordChangedEventFunction'] . '(:username) FROM DUAL';
        $this->getConnection()->executeQuery(
            $sql, array(
            'username' => $username
        ), array(
            'username' => PDO::PARAM_STR
        ));
    }

    private static function stringHasValue($str) {
        return !($str === null || !strlen(trim($str)));
    }
}