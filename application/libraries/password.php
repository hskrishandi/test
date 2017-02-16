<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Password
{
    // Don't rename this, this name will be used in password.inc.
    // And this variable holds plain text password,
    // use encrypt function to get the
    // encrypted password.
    public $pass;

    public function __construct($password = null)
    {
        require_once dirname(__FILE__) . '/bootstrap.inc';
        require_once dirname(__FILE__) . '/password.inc';
        // For generating secure random password
        require_once dirname(__FILE__) . '/random_compat/lib/random.php';
        $this->pass = $password;
    }

    /**
     * Check if the two passwords are match
     *
     * @param $encrypted
     * @return bool
     *
     * @author Leon
     */
    public function isMatch($plain, $encrypted = null)
    {
        if ($encrypted != null) {
            $this->pass = $encrypted;
        }
        return user_check_password($plain, $this);
    }

    /**
     * Encrypt password
     *
     * @param plain text password
     * @return encrypted password
     *
     * @author Leon
     */
    public function encrypt($password = null)
    {
        if ($password != null) {
            $this->pass = $password;
        }
        return _password_crypt('sha512', $this->pass, _password_generate_salt(DRUPAL_HASH_COUNT));
    }

    /**
     * Generate strong random passowrd
     *
     * @param $length - should be even number like 6, 8, 10...
     * @return $password
     *
     * @author Leon
     */
    public function generate($length)
    {
        $randomBytes = null;
        try {
            // Generate random string using random_compact library
            $randomBytes = random_bytes($length / 2);
        } catch (TypeError $e) {
            // Well, it's an integer, so this IS unexpected.
            log_message('error', $e);
        } catch (Error $e) {
            // This is also unexpected because 0 and 255 are both reasonable integers.
            log_message('error', $e);
        } catch (Exception $e) {
            // If you get this message, the CSPRNG failed hard.
            log_message('error', $e);
        }
        if ($randomBytes) {
            // Change string to hex code
            $this->pass = bin2hex($randomBytes);
        }
        return $this->pass;
    }
}
