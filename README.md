# Password Manager

##### A Standalone Self Service Web Application for Changing Passwords in Existing Applications

Keep getting requests from users to reset their password because they forgot them?

Have an application that does not have password reset functionality?

**Password Manager** may be the solution!

## Features
 * Lets users change and reset their passwords without the involvement of administrators.
 * Users have to go to a link sent to their email address to reset their forgotten passwords.
 * Generate strong passwords with the press of a button.
 * Enforce minimal password strength for new passwords.

# Requirements

* PHP 5.3.2+ on the webserver.
* Your application stores emails and password hashes in the database. And optionally usernames as well.
* Your application either uses bcrypt, sha256, or sha512 to hash passwords or does hashing in the database.
* The PHP module for the database you wish to use must be installed on the webserver.
* Access to a mail server for sending emails.

# Installation

* Download the latest version of the application from the GitHub repository.
* Edit the *config.php* file included with the application and fill in your configuration.
* If using functions for database interactions, create them in the database.
* Upload the application's files to the webserver.
* Optional but suggested: move the config.php file outside of the webserver's public directory and store the path to it in the *configlink.php* file.

# License

Password Manager is released under the MIT license.
