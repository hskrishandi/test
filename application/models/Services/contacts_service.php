<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Contacts_service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Contacts_repository');
        $this->load->library('email');
    }

    /**
     * Create a contactus
     *
     * @param type $param
     * @return $value
     *
     * @author Leon
     */
    public function createContact($email, $name, $affiliation = "", $subject, $message)
    {
        if ($this->Contacts_repository->saveContact($email, $name, $affiliation, $subject, $message)) {
            if ($this->sendContactUsEmailToAdmin($email, $name, $affiliation, $subject, $message)) {
                return $this->sendFeedbackToUser($email, $name, $subject);
            } else {
                return array(406 => "Oops! Something went wrong.");;
            }
        } else {
            return array(406 => "Oops! Something went wrong.");
        }
    }

    /**
     * Send Contact us email to admin
     *
     * @param $email, $name, $affiliation, $subject, $message
     * @return bool
     *
     * @author Leon
     */
    private function sendContactUsEmailToAdmin($email, $name, $affiliation, $subject, $message)
    {
        $config['mailtype']='html';
        $this->email->initialize($config);
        $this->email->from($email, $name);
        // TODO: change admin email
        // $this->email->to('mchan@ust.hk, eelnzhang@ust.hk');
        $this->email->to('hliangae@connect.ust.hk');
        $this->email->subject("[i-MOS]" . $subject);
        $this->email->message($message . "<br /><br /> Message from $name, $affiliation");
        if (!$this->email->send()) {
            log_message('error', 'Send contact failed: failed to send contact email. ' . $email);
            return false;
        } else {
            return true;
        }
    }

    /**
     * Send feedback email to user
     *
     * @param $email, $name, $subject
     * @return bool
     *
     * @author Leon
     */
    private function sendFeedbackToUser($email, $name, $subject)
    {
        $config['mailtype']='html';
        $this->email->initialize($config);
        $this->email->from("info@i-mos.org", 'i-MOS');
        $this->email->to($email);
        $this->email->subject("[i-MOS]Thank you for contacting us");
        $msg = "Dear $name, <br /> <br />
                Thanks for contacting us! This is an automatic reply.<br /><br />
                Your subject: <br />
                \"$subject\" <br />
                has been received.<br /><br />
                Best Regards,<br />
                i-MOS Team";
        $this->email->message($msg);
        if (!$this->email->send()) {
            log_message('error', 'Send Feedback failed: failed to send feedback email. ' . $email);
            return false;
        } else {
            return true;
        }
    }
}
