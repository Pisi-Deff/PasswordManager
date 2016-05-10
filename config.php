<?php

if (!defined('PASSWORD_MANAGER')){
    exit('You should not be here.');
}
$cfg = array();



/**************************
 **** Generic settings ****
 **************************/

/**
 * Unique identifier for this instance of Password Manager.
 * Needed when multiple instances of this application are running on the same
 * web server to avoid the separate instances interfering with eachother's data.
 *
 * The value has to be a string of only alphanumeric characters and may be case-insensitive
 * depending on the host operating system.
 * The value may be used as part of filenames, so it should not be too long to avoid
 * file system limitations. Around 10 characters would be fine.
 * Example: 'sitename'
 */
$cfg['instanceIdentifier'] = 'sitename';

/**
 *
 */
$cfg['applicationName'] = 'Site Name';



/**************************
 **** Database settings ***
 **************************/

/**
 *
 */
$cfg['db_type'] = 'pgsql';

/**
 *
 */
$cfg['db_host'] = 'db.example.com';

/**
 *
 */
$cfg['db_port'] = null;

/**
 *
 */
$cfg['db_user'] = '';

/**
 *
 */
$cfg['db_password'] = '';

/**
 *
 */
$cfg['db_database'] = 'application';

/**
 *
 */
$cfg['db_userTable'] = 'users';

/**
 *
 */
$cfg['db_usernameColumn'] = 'username';

/**
 *
 */
$cfg['db_emailColumn'] = 'email';

/**
 *
 */
$cfg['db_passwordColumn'] = 'password';

/**
 *
 */
$cfg['db_passwordHashMethod'] = 'bcrypt';

/**
 *
 */
$cfg['db_passwordChangedEventFunction'] = null;

/**
 *
 */
$cfg['db_useDBFunctions'] = false;

/**
 *
 */
$cfg['db_getUserEmailFunction'] = null;

/**
 *
 */
$cfg['db_changePasswordFunction'] = null;

/**
 *
 */
$cfg['db_userAuthenticateFunction'] = null;

/**
 *
 */
$cfg['db_useHashedPasswordForFunctions'] = true;



/**************************
 **** Password settings ***
 **************************/

/**
 *
 */
$cfg['pw_minLength'] = 10;

/**
 *
 */
$cfg['pw_maxLength'] = 0;

/**
 *
 */
$cfg['pw_minEntropyBits'] = 80;



/**************************
 **** Email settings ******
 **************************/

/**
 *
 */
$cfg['email_host'] = 'mail.example.com';

/**
 *
 */
$cfg['email_port'] = null;

/**
 *
 */
$cfg['email_type'] = 'smtp';

/**
 *
 */
$cfg['email_useAuthentication'] = false;

/**
 *
 */
$cfg['email_authUsername'] = '';

/**
 *
 */
$cfg['email_authPassword'] = '';

/**
 *
 */
$cfg['email_encryption'] = 'tls';

/**
 *
 */
$cfg['email_mailerAddress'] = 'passwords@example.com';