This file provides examples for the definitions of the database functions that the application uses (if configured to).
You will almost certainly need to adjust these examples to suit your system's specific needs.

## PostgreSQL

##### db_passwordChangedEventFunction

```sql
CREATE OR REPLACE FUNCTION fn_pwChangeEvent
    (username TEXT)
    RETURNS VOID
    AS $$
        DELETE FROM sessions s
            WHERE s.user_id = (
                SELECT u.id FROM users u
                    WHERE u.username = $1
            )
    $$
    LANGUAGE SQL
    SECURITY DEFINER;
```

##### db_getUserEmailFunction

```sql
CREATE OR REPLACE FUNCTION fn_getUserEmail
    (username TEXT)
    RETURNS TEXT
    AS $$
        SELECT u.email FROM users u
            WHERE u.username = $1
    $$
    LANGUAGE SQL
    SECURITY DEFINER;
```

##### db_changePasswordFunction

```sql
CREATE OR REPLACE FUNCTION fn_setPass
    (username TEXT, password TEXT)
    RETURNS VOID
    AS $$
        UPDATE users u
            SET u.password = $2
            WHERE u.username = $1
    $$
    LANGUAGE SQL
    SECURITY DEFINER;
```

##### db_userAuthenticateFunction

```sql
CREATE OR REPLACE FUNCTION fn_userAuth
    (username TEXT, password TEXT)
    RETURNS BOOLEAN
    AS $$
        SELECT u.password = $2 FROM users u
            WHERE u.username = $1
    $$
    LANGUAGE SQL
    SECURITY DEFINER;
```

##### db_getUserPasswordHashFunction

```sql
CREATE OR REPLACE FUNCTION fn_getUserPassHash
    (username TEXT)
    RETURNS TEXT
    AS $$
        SELECT u.pwhash FROM users u
            WHERE u.username = $1
    $$
    LANGUAGE SQL
    SECURITY DEFINER;
```

## MySQL

##### db_passwordChangedEventFunction

```sql
CREATE FUNCTION fn_pwChangeEvent
    (username VARCHAR(400))
    RETURNS BOOL
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    BEGIN
        DELETE FROM sessions s
          WHERE s.user_id = (
            SELECT u.id FROM users u
              WHERE u.username = username
          )
        RETURN 1;
    END
```

##### db_getUserEmailFunction

```sql
CREATE FUNCTION fn_getEmail
    (username VARCHAR(400))
    RETURNS VARCHAR(400)
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    BEGIN
        DECLARE mail VARCHAR(400);
        SET mail = NULL;
        SELECT u.email INTO mail
            FROM users AS u
            WHERE u.username = username;
        RETURN mail;
    END
```

##### db_changePasswordFunction

```sql
CREATE FUNCTION fn_changePass
    (username VARCHAR(400), newpw VARCHAR(400))
    RETURNS BOOL
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    BEGIN
        UPDATE users u
            SET u.pwhash = newpw
            WHERE u.username = username;
        RETURN 1;
    END
```

##### db_userAuthenticateFunction

```sql
CREATE FUNCTION fn_authUser
    (username VARCHAR(400), password VARCHAR(400))
    RETURNS BOOL
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    BEGIN
        DECLARE legit BOOL;
        SET legit = 0;
        SELECT u.pwhash = password INTO legit
            FROM users AS u
            WHERE u.username = username;
        RETURN legit;
    END
```

##### db_getUserPasswordHashFunction

```sql
CREATE FUNCTION fn_getPwHash
    (username VARCHAR(400))
    RETURNS VARCHAR(400)
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    BEGIN
        DECLARE pwhash VARCHAR(400);
        SET pwhash = NULL;
        SELECT u.pwhash INTO pwhash
            FROM users AS u
            WHERE u.username = username;
        RETURN pwhash;
    END
```