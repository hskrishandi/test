<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('template_inheritance');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->helper('credits_helper');
        $this->load->helper('recaptchalib_helper');
        $this->load->model('Account_model');
        $this->load->library('form_validation');

        $this->config->load('account_create_form');
        $this->config->load('account_info_update');
    }

    /**
     * Home Page for this controller.
     *
     * Maps to the following URL
     * 		http://www.i-mos.org/resources
     *	- or -
     * 		http://www.i-mos.org/resources/index
     */
    public function index()
    {
        $data = null;
    }
    public function create()
    {
        if ($this->_islogin() === false) {
            $data = null;
            $this->load->view('account/account_create', $data);
        } else {
            redirect('/');
        }
    }
    public function create_submit()
    {
        $data = null;
        $form = $this->config->item('account_create_form');
        $this->form_validation->set_rules($form);
        $data_vaild = $this->form_validation->run();
        $privatekey = '6LfKDtASAAAAAJ4tsQC3heEYHWofPt8oFpx19IKd';
        $resp = recaptcha_check_answer($privatekey,
                                $_SERVER['REMOTE_ADDR'],
                                $_POST['recaptcha_challenge_field'],
                                $_POST['recaptcha_response_field']);
        if (!$resp->is_valid) {
            // What happens when the CAPTCHA was entered incorrectly
                 $data['err'] = array('verification' => 'Verification code wrong. Please enter again.');
            $this->load->view('account/account_create', $data);
        } else {
            if ($data_vaild) {
                foreach ($form as $item) {
                    $form_data[$item['field']] = $this->db->escape_str($this->input->post($item['field']));
                }

                $this->Account_model->createUser($form_data);
                $_SESSION['referer'] = base_url($this->uri->uri_string());
                $this->load->view('account/account_create_done', $data);
            } else {
                $this->load->view('account/account_create', $data);
            }
        }
    }

    public function create_done()
    {
        $data = null;
        echo $_SESSION['referer'];
        if (isset($_SESSION['referer']) && ($_SESSION['referer'] == '/account/create' || $_SESSION['referer'] == '/account/create_submit')) {
            $this->load->view('account/account_create_done', $data);
            unset($_SESSION['referer']);
        } else {
            show_error('The page cannot be accessed.', 203);
        }
    }

    public function email_check($str)
    {
        if ($this->Account_model->isEmailDup($str)) {
            $this->form_validation->set_message('email_check', 'The E-MAIL ADDRESS is ready registered. Please enter another E-MAIL. If you forgot the password of this account, please click here to request new password.');

            return false;
        } else {
            return true;
        }
    }

    public function activate($page)
    {
        $page = $this->db->escape_str($page);
        $flag = $this->Account_model->activate($page);
        if ($flag) {
            $this->load->view('account/account_activate_done');
        } else {
            show_error('The page cannot be accessed.', 203);
        }
    }

    public function login_block()
    {
        if ($this->_islogin() !== false) {
            $this->load->view('account/login_block_logined', array('user' => $this->_islogin()));
        } else {
            $this->load->view('account/login_block_form');
        }
    }

    public function login()
    {
        $email = $this->input->post('email');
        $pwd = $this->input->post('pwd');
        echo $this->Account_model->login($email, $pwd);
    }

    public function loginForm()
    {
        $email = $this->input->post('email');
        $pwd = $this->input->post('pwd');
        $loginResult = $this->Account_model->login($email, $pwd);
        if ($loginResult == "noactive") {
            redirect('/account/authErr');
        } elseif ($loginResult == "noaccpass") {
            redirect('/account/authErr');
        } else {
            redirect('/');
        }
    }

    public function reAuth()
    {
        $email = $this->input->post('email');
        $pwd = $this->input->post('pwd');
        $userinfo = $this->_islogin();
        if ($userinfo  === false) {
            $msg = $this->Account_model->login($email, $pwd);
            if ($msg === 'ok') {
                $this->session->set_userdata('relogined', '1');
            }
            echo $msg;
        } else {
            if ($userinfo->email  == $email && $this->Account_model->_isPassVaild($userinfo->password, $pwd)) {
                echo 'ok';
                $this->session->set_userdata('relogined', '1');
            } else {
                echo 'noaccpass';
            }
        }
    }

    public function _islogin()
    {
        return $this->Account_model->islogin();
    }

    /**
     * Use for checking login.
     *
     * @return login username
     *
     * @author Leon
     */
    public function isLogin()
    {
        $userinfo = $this->_islogin();
        $username = "";
        if ($userinfo != false) {
            $username = $userinfo->displayname;
        } else {
            $username = "";
        }
        echo $username;
    }

    public function logout()
    {
        $this->Account_model->logout();
    }

    public function infoUpdate()
    {
        $relogined = $this->session->userdata('relogined');
        $submited = $this->input->post('submited');
        $data1['title'] = 'Account Update';

        if ($relogined == 1) {
            $data = null;
            $data['userinfo'] = $this->_islogin();
            $form = $this->config->item('account_info_update_form');
            $this->form_validation->set_rules($form);
            $data_vaild = $this->form_validation->run();
            $this->session->unset_userdata('relogined');
            $this->load->view('account/info_update', $data);
        } elseif ($submited == '1') {
            $filename_uuid = $this->_islogin()->photo_path;
            if ($filename_uuid == '') {
                $filename_uuid = uniqid();
            }
            //define the image resizer
            $config['upload_path'] = './uploads/user_photo/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '4000';
            $config['file_name'] = $filename_uuid;
            $config['overwrite'] = true;
            $form_data = null;
            $this->load->library('upload', $config);
            if ($this->_islogin() !== false) {
                $data = null;
                $data['userinfo'] = $this->_islogin();
                $form = $this->config->item('account_info_update_form');
                $this->form_validation->set_rules($form);
                $data_vaild = $this->form_validation->run();

                if ($data_vaild) {
                    foreach ($form as $item) {
                        $form_data[$item['field']] = $this->db->escape_str($this->input->post($item['field']));
                    }
                    $form_data['photo_ext'] = $this->_islogin()->photo_ext;
                    if ($_FILES['photo']['error'] !== 4) {
                        if (!$this->upload->do_upload('photo')) {
                            $data['photo_err'] = $this->upload->display_errors();
                        } else {
                            $msg = $this->upload->data();
                            if ($msg['is_image'] == true) {
                                $form_data['photo_path'] = $filename_uuid;
                                $form_data['photo_ext'] = $msg['file_ext'];
                            //$config['create_thumb'] = TRUE;
                            $config['source_image'] = './uploads/user_photo/'.$filename_uuid.$msg['file_ext'];
                                $config['new_image'] = './uploads/user_photo/'.$filename_uuid.'_n'.$msg['file_ext'];
                                $config['width'] = 100;
                                $config['height'] = 100;
                                $config['maintain_ratio'] = true;
                                $this->load->library('image_lib', $config);
                                if (!$this->image_lib->resize()) {
                                    echo $this->image_lib->display_errors();
                                }
                            } else {
                                $data['photo_value'] = 'Please select the JPEG/GIF/PNG file.';
                            }
                        }
                    } else {
                        unset($form_data['photo_path']);
                    }

                    $this->Account_model->info_update($form_data);
                }
                $data['userinfo'] = $this->_islogin();
                $this->load->view('account/info_update', $data);
            } else {
                echo 'submited and no logined';
                $this->load->view('account/login_account_management.php', $data1);
            }
        } else {
            $this->load->view('account/login_account_management.php', $data1);
        }
    }

    public function changePass()
    {
        $this->load->view('account/changePass');
    }
    public function passey($password)
    {
        echo _password_crypt('sha512', $password, _password_generate_salt(DRUPAL_HASH_COUNT));
    }
    public function changePass_en()
    {
        $email = $this->input->post('email');
        $old_pass = $this->input->post('oldpass');
        $new_pass = $this->input->post('newpass');
        $result = $this->Account_model->changePass($email, $old_pass, $new_pass);
        if ($result) {
            echo 'ok';
        } else {
            echo 'noaccpass';
        }
    }
    public function authErr()
    {
        if ($this->Account_model->islogin() === false) {
            $data['logined'] = false;
            $this->load->view('account/auth_err', $data);
        } else {
            $data['logined'] = true;
            $this->load->view('account/auth_err', $data);
        }
    }
    public function authErrLoad()
    {
        $uri = $this->session->userdata('refer');
        redirect('/'.$uri);
    }

    public function newPass()
    {
        $this->load->view('account/newPass');
    }
    public function newPass_en()
    {
        $email = $this->input->post('email');
        $this->Account_model->newPass($email);
    }
}
/* End of file resources.php */
/* Location: ./application/controllers/resources.php */
