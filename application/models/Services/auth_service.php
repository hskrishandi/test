<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * This is a auth service.
 */
class Auth_service extends Base_service
{

    /**
     * Logined user
     *
     * @var array
     */
    private $user = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Auth_repository');
        $this->load->library('Password');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('url');
    }

    /**
     * login.
     *
     * @param $email, $password
     *
     * @return login result
     *
     * @author Leon
     */
    public function login($email, $inputPassword)
    {
        $users = $this->Auth_repository->fetchAuthUserByEmail($email);
        $result = array();
        switch (count($users)) {
            case 0:
                // Not registered
                $result = array(401 => "Email and password are not matched.");
                break;
            default:
                // Registered user
                $this->user = current($users);
                // Using the Password library to check password
                $password = new Password($this->user->password);
                if ($password->isMatch($inputPassword)) {
                    // if password is match
                    if ($this->user->isactivated == '1') {
                        // auth success
                        // create a new session base on the auth user id
                        $this->session->set_userdata(array('id' => $this->user->id));
                        // get the session_id, this is token for the api
                        $token = $this->session->userdata['session_id'];
                        // destroy the session
                        $this->session->sess_destroy();
                        // save the token for user in database
                        $this->Auth_repository->saveToken($this->user->id, $token);
                        // return the token
                        $result = array('token' => $token);
                    } else {
                        // account not activated
                        $result = array(401 => "Account not activated.");
                    }
                } else {
                    // if password is not match
                    $result = array(401 => "Email and password are not matched.");
                }
                break;
            // FIXME: Allow same email exists in database, not a good approach
            /*
            default:
                // Multiple user email, error
                $result = array(401 => "Account error.");
                break;
            */
        }
        return $result;
    }

    /**
     * Logout
     *
     * @param $email
     * @return logout result
     *
     * @author Leon
     */
    public function logout()
    {
        // logout is required login, when checking isLogin using 'isLogin()',
        // the auth user would be set if auth, hence we only need
        // to use the id of auth user to logout
        $result = $this->user != null ? $this->Auth_repository->discardToken($this->user->id) : false;
        return $result;
    }

    /**
     * Check whether the user is logined.
     *
     * @param $token
     * @return bool
     *
     * @author Leon
     */
    public function isLogin($token)
    {
        if (!$this->user) {
            $users = $this->Auth_repository->fetchAuthUserByToken($token);
            if (count($users) > 0) {
                // Save the user info
                $this->user = current($users);
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
        // TODO: Should check whether this token is expired, need to add one
        // column 'update_at' in users table, check the time
        // and compare with now
        return false;
    }

    /**
     * Get logined user
     *
     * @return logined user
     *
     * @author Leon
     */
    public function getLoginedUser()
    {
        $returnUser = clone($this->user);
        unset($returnUser->password);
        return $returnUser;
    }

    /**
     * Register
     *
     * @param register data
     * @return bool
     *
     * @author Leon
     */
    public function register($data)
    {
        // Check the email if registered
        if ($this->isRegisteredEmail($data['email'])) {
            log_message('error', 'Register failed: The E-MAIL ADDRESS is ready registered. ' . $data['email']);
            return array(406 => 'The E-MAIL ADDRESS is already registered. Please enter another E-MAIL address. If you forgot the password of this account, please request new password.');
        }

        unset($data['retypepassword']);
        $password = new Password($data['password']);
        // Encrypt plain text password
        $data['password'] = $password->encrypt();
        // Create user and get user id.
        $id = $this->Auth_repository->createUser($data);
        if ($id) {
            // Create activation with uuid
            $uuid = uniqid();
            $success = $this->Auth_repository->createActivation($uuid, $id);
            if ($success) {
                // Send activation email
                $this->sendActivationEmail($data['email'], $data['last_name'], $data['first_name'], $uuid);
            } else {
                log_message('error', 'Register failed: failed to create activation' . $data['email']);
                return false;
            }
        } else {
            log_message('error', 'Register failed: failed to create user. ' . $data['email']);
            return false;
        }
        return true;
    }

    /**
     * Is registered email
     *
     * @param email
     * @return bool
     *
     * @author Leon
     */
    private function isRegisteredEmail($email)
    {
        $user = $this->Auth_repository->fetchUserByEmail($email);
        if (count($user) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Send activation email
     *
     * @param email, lastname, firstname, uuid
     * @return bool
     *
     * @author Leon
     */
    private function sendActivationEmail($email, $lastname, $firstname, $uuid)
    {
        $config['mailtype']='html';
        $this->email->initialize($config);
        $this->email->from("info@i-mos.org", 'i-MOS');
        $this->email->to($email);
        $this->email->subject("[i-MOS]Account Activation");
        $url = base_url('/auth/activate/') . "/$uuid";
        $msg = "Dear $firstname $lastname, <br /> <br />
                Thank you for registering with i-MOS. Please click the following link to activate your account: <br />
                $url<br /><br />
                Best Regards,<br />
                i-MOS Team";
        $this->email->message($msg);
        if (!$this->email->send()) {
            log_message('error', 'Register failed: failed to send activation email ' . $email);
        }
    }

    /**
     * Activate account
     *
     * @param $uuid
     * @return bool
     *
     * @author Leon
     */
    public function activateAccount($uuid)
    {
        // Get user by uuid
        $user = $this->Auth_repository->fetchActivation($uuid);
        // If user exists in activation
        if (count($user) > 0) {
            // Update the user to activated
            $success = $this->Auth_repository->activateAccount(current($user)->id);
            if ($success) {
                // Delete the the activation
                $this->Auth_repository->deleteActivation($uuid);
                return array(200 => "Congratulations, your account is activated!");
            } else {
                return array(406 => "Oops! Something went wrong while activating your account, please contact us.");
            }
        } else {
            return array(406 => "Oops! The link is invalid, please contact us.");
        }
    }

    /**
     * Reset password
     *
     * @param $email
     * @return bool
     *
     * @author Leon
     */
    public function resetPassword($email)
    {
        $user = $this->Auth_repository->fetchUserByEmail($email);
        if (count($user) > 0) {
            // Create new password class
            $password = new Password();
            // Generate password, length is 8
            $password->generate(8);
            // Update password, the password is encrypted
            $user = current($user);
            $success = $this->Auth_repository->updatePassword($user->id, $password->encrypt());
            if ($success) {
                // Send email
                $this->sendResetPasswordEmail($email, $user->displayname, $password->pass);
                return array(200 => "Congratulations, your password is reset, please check the email.");
            } else {
                return array(406 => "Oops! Something went wrong while reseting your password, please contact us.");
            }
        } else {
            return array(406 => "Oops! Something went wrong while reseting your password, please contact us.");
        }
    }

    /**
     * Send reset password email
     *
     * @param $email $name, $password
     * @return bool
     *
     * @author Leon
     */
    private function sendResetPasswordEmail($email, $name, $password)
    {
        $config['mailtype']='html';
        $this->email->initialize($config);
        $this->email->from("info@i-mos.org", 'i-MOS');
        $this->email->to($email);
        $this->email->subject("[i-MOS]New Password");
        $msg = "Dear $name, <br />
                <br />
                The new password of your i-MOS account is given below: <br />
                <br />
                Email: $email <br />
                Password: $password <br />
                <br />
                Please change your password as soon as possible.<br />
                <br />
                Best Regards,<br />
                i-MOS Team";
        $this->email->message($msg);
        if (!$this->email->send()) {
            log_message('error', 'Reset password failed: failed to send reset password email. ' . $email);
        }
    }

    /**
     * Change password
     *
     * @param $oldPassword, $newPassword
     * @return change status
     *
     * @author Leon
     */
    public function updatePassword($oldPassword, $newPassword)
    {
        log_message('ERROR', $this->user->password);
        $password = new Password($this->user->password);
        if ($this->user && $password->isMatch($oldPassword)) {
            $encryptedNewPassword = $password->encrypt($newPassword);
            if ($this->Auth_repository->updatePassword($this->user->id, $encryptedNewPassword)) {
                return true;
            } else {
                log_message('error', 'Failed to update password to database.');
                return array(406 => "Oops! Something went wrong while updating password, please contact us.");
            }
        } else {
            return array(406 => "Password not match.");
        }
        return true;
    }
}
