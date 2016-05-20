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
 * The name of the system, the users and passwords of which this application deals with.
 * Used for example in sent emails and titles of pages.
 * 
 * Example: 'Site Name'
 */
$cfg['applicationName'] = 'Site Name';

/**
 * Absolute file system address to the folder where logs will be written into.
 * The folder must exist and the webserver process must have read-write
 * permissions for the folder.
 *
 * If the value is null, then logs will not be written.
 */
$cfg['logsFolder'] = '/home/sitename/logs';



/**************************
 **** Database settings ***
 **************************/

/**
 * The type of the database system.
 *
 * Allowed values: 'postgresql', 'oracle', 'mssql'
 * Note: Oracle and MSSQL support is currently untested.
 */
$cfg['db_type'] = 'postgresql';

/**
 * The hostname of the database server.
 *
 * Examples: 'db.example.com', 'localhost'
 */
$cfg['db_host'] = 'db.example.com';

/**
 * The port of the database server.
 *
 * Set this to null for the default port of the database server type to be used.
 */
$cfg['db_port'] = null;

/**
 * The user with which to login to the database server.
 *
 * Note: This user must have permissions in the database to access either the user table
 * (if db_useDBFunctions is false) or the relevant functions (if db_useDBFunctions is true).
 */
$cfg['db_user'] = '';

/**
 * The password with which to login to the database server
 */
$cfg['db_password'] = '';

/**
 * The name of the database that contains the user table and/or functions.
 */
$cfg['db_database'] = 'application';

/**
 * The name of the table that contains user data - username, email, password hash.
 * If the table is accessible via a schema, then add the schema name in the front of the value
 * and separate it from the table name with a period (.).
 */
$cfg['db_userTable'] = 'users';

/**
 * The column in the user table that contains usernames.
 * Note: If the application uses emails as username, the values of this parameter
 * and the next one should be identical.
 */
$cfg['db_usernameColumn'] = 'username';

/**
 * The column in the user table that contains emails.
 * Note: If the application uses emails as username, the values of this parameter
 * and the previous one should be identical.
 */
$cfg['db_emailColumn'] = 'email';

/**
 * The column in the user table that contains password hashes.
 */
$cfg['db_passwordColumn'] = 'password';

/**
 * The method with which the password will be hashed.
 *
 * Hashing will only be done if data is accessed directly (db_useDBFunctions is false)
 * or if functions are used (db_useDBFunctions is true) and the parameter
 * db_useHashedPasswordForFunctions is true.
 *
 * Use null for horrible ancient legacy systems that don't crypt passwords, which is horrible.
 *
 * Supported values: 'bcrypt', 'sha256', 'sha512', null
 */
$cfg['db_passwordHashMethod'] = 'bcrypt';

/**
 * Name of the function in the database, which is called when a password has been changed.
 * Useful if after changing a password some logic needs to be executed on the database
 * server. For example to wipe user sessions.
 * If the function is accessible via a schema, then add the schema name in the front of the value
 * and separate it from the table name with a period (.).
 *
 * Note: Usage of this function does NOT depend on the value of db_useDBFunctions.
 */
$cfg['db_passwordChangedEventFunction'] = null;

/**
 * Whether to directly access the user data (false) or through functions (true).
 *
 * If set to true, the values of the following parameters will be used
 * for exchanging data with the database:
 *   - db_getUserEmailFunction
 *   - db_changePasswordFunction
 *   - db_userAuthenticateFunction
 *   - db_useHashedPasswordForFunctions
 * 
 * If set to false, the values of the following parameters will be used
 * for exchanging data with the database:
 *   - db_userTable
 *   - db_usernameColumn
 *   - db_emailColumn
 *   - db_passwordColumn
 */
$cfg['db_useDBFunctions'] = false;

/**
 * Name of the function in the database, which is called to retrieve a user's email address.
 * It also acts as a way to check if a user with the provided username exists. If the function returns null, then
 * it is assumed that the user does not exist.
 * If the function is accessible via a schema, then add the schema name in the front of the value
 * and separate it from the table name with a period (.).
 *
 * The single input of the function is the username.
 * The output of the function is the user's email address or null if the user does not exist.
 *
 * Note: Refer to db_useDBFunctions.
 */
$cfg['db_getUserEmailFunction'] = null;

/**
 * Name of the function in the database, which is called to change a user's password.
 * If the function is accessible via a schema, then add the schema name in the front of the value
 * and separate it from the table name with a period (.).
 *
 * The first input of the function is the username.
 * The second input of the function is the new password.
 * The function does not have an output.
 *
 * Note: Refer to db_useDBFunctions.
 */
$cfg['db_changePasswordFunction'] = null;

/**
 * Name of the function in the database, which is called to authenticate a user.
 * If the function is accessible via a schema, then add the schema name in the front of the value
 * and separate it from the table name with a period (.).
 *
 * The first input of the function is the username.
 * The second input of the function is the new password.
 * The output of the function is true if the username and password match
 * an existing user and false otherwise.
 *
 * Note: Refer to db_useDBFunctions.
 */
$cfg['db_userAuthenticateFunction'] = null;

/**
 * Should the password be hashed before passing it to the functions defined by
 * db_changePasswordFunction and db_userAuthenticateFunction?
 *
 * If the value is true, the password will be hashed with the method defined
 * with the db_passwordHashMethod parameter.
 */
$cfg['db_useHashedPasswordForFunctions'] = true;



/*********************************
 **** Password strength rules ****
 *********************************/

/**
 * The minimal number of characters that the new password must have.
 *
 * Suggested value: 10
 */
$cfg['pw_minLength'] = 10;

/**
 * The maximal number of characters that the new password may have. If the value
 * is 0, then no maximal limit will be enforced.
 *
 * May be necessary with some hash algorithms that limit input length.
 */
$cfg['pw_maxLength'] = 0;

/**
 * The minimal amount of entropy in bits that the new password must have.
 * Calculated with Shannon's entropy formula.
 *
 * Suggested value: 60
 */
$cfg['pw_minEntropyBits'] = 80;

/**
 * The amount of entropy in bits that is considered to be strong.
 *
 * Suggested value: 100
 */
$cfg['pw_strongEntropyBits'] = 100;



/***********************************
 **** Password generation rules ****
 ***********************************/

/**
 * An absolute file system address to the file to be used as a
 * dictionary for password generation.
 *
 * The structure of the file:
 *   - one word per line
 *   - only lower case characters and dashes
 *
 * Example: '/home/sitename/dictionary.txt'
 */
$cfg['pwgen_dictionaryFilePath'] = '/home/sitename/dictionary.txt';

/**
 * How many words from the dictionary to use for password generation?
 *
 * Suggested value: 4
 */
$cfg['pwgen_wordsNumber'] = 4;



/**************************
 **** Email settings ******
 **************************/

/**
 * The hostname of the mail server to use.
 */
$cfg['email_host'] = 'mail.example.com';

/**
 * The port of the mail server to use.
 * If left as null, the default port will be used.
 */
$cfg['email_port'] = null;

/**
 * The type of the mail server.
 * Allowed values: 'smtp', 'pop3'
 */
$cfg['email_type'] = 'smtp';

/**
 * Whether to authenticate with the mail server.
 */
$cfg['email_useAuthentication'] = true;

/**
 * The username to use to authenticate with the mail server.
 */
$cfg['email_authUsername'] = '';

/**
 * The password to use to authenticate with the mail server.
 */
$cfg['email_authPassword'] = '';

/**
 * The encryption to use while communicating with the mail server.
 * If the value is null, then no encryption will be used.
 *
 * Note: if the server does not support the defined encryption type,
 * sending mails may fail without logged errors.
 *
 * Allowed values: 'tls', 'ssl', null
 */
$cfg['email_encryption'] = null;

/**
 * The email address to use as the sender address for outgoing emails.
 */
$cfg['email_mailerAddress'] = 'passwords@example.com';