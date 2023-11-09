<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Auth Class
 */
class Auth extends CI_Controller
{
    /**
     * Construct functions
     * 
     * @return void
     */
    public function __construct()
    {
        // Load the parent construct
        parent::__construct();

        // Load the libraries
        $this->load->library(['session', 'form_validation']);

        // Load the helpers
        $this->load->helper(['url', 'string', 'cookie']);

        // Load the models
        $this->load->model(['Users_model']);
    }

    /**
     * Login - Default for this controller
     * 
     * @return void
     */
    public function index()
    {
        // $this->checkAuth();

        $data = [
            'page' => [
                'title' => 'Login'
            ]
        ];

        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('remember', 'Remember Me', 'trim|integer');

        if ($this->form_validation->run() === false) {
            $this->load->view('login', $data);
        } else {
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);
            $remember = $this->input->post('remember', true);

			$checkUser = $this->Users_model->getCheckUser(
				[ 
					'username' => $username,
					'password' => $password,//md5($password) //$password//

				]
				);

            if ($checkUser) {
					$user = $checkUser[0];
					$this->session->set_userdata('username', isset($user['po_username'])?$user['po_username']:'');
					$this->session->set_userdata('empid', $user['UserID']);
					$this->session->set_userdata('fullname', $user['f_name'].' '.$user['m_name'].' '.$user['l_name']);
					$this->session->set_userdata('designationname', $user['designationname']);
                    $this->session->set_userdata('position_type', $user['position_type']);
                    $this->session->set_userdata('designation', $user['designation']);
                    $this->session->set_userdata('department', $user['department']);
                    $this->session->set_userdata('designationID', $user['designationID']);
                    $this->session->set_userdata('departmentname', $user['departmentname']);
                    $this->session->set_userdata('email', $user['email']);
                    $this->session->set_userdata('birthdate', isset($user['Birthdate'])?$user['Birthdate']:'');
                    $this->session->set_userdata('branch', $user['branch']);
                    $this->session->set_userdata('site', $user['cgsi_site']);
                    $this->session->set_userdata('pass_tag', $user['pass_tag']);
                    

                    if ($remember == '1') {
						$rememberToken = '';
                        set_cookie([
                            'name'   => '_auth',
                            'value'  => $rememberToken,
                            'expire' => (60 * 60 * 24 * 7)
                        ]);
                    }

                    $this->session->set_flashdata('success_message', 'Welcome, ' . $checkUser[0]['po_username'] . '.');
                    redirect('/profile');
            } else {
                $this->session->set_flashdata('error_message', 'Invalid Username or Password');
                redirect('login', 'refresh');
            }
        }
    }
    
    /**
     * Register
     * 
     * @return void
     */
    public function register()
    {
        $this->checkAuth();

        $data = [
            'page' => [
                'title' => 'Register'
            ]
        ];

        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[6]|max_length[30]|alpha_numeric|is_unique[users.username]');
        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[6]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|min_length[6]|matches[password1]');

        if ($this->form_validation->run() === false) {
            $this->load->view('register', $data);
        } else {
            $username = $this->input->post('username', true);
            $password = $this->input->post('password1', true);

            $createUser = $this->Users_model->insertUser($username, $password);
            if ($createUser) {
                $this->session->set_flashdata('success_message', 'Congratulations! your account has been created, please login.');
                redirect('login');
            } else {
                $this->session->set_flashdata('error_message', 'An error occurred! Please try again later.');
                redirect('register', 'refresh');
            }
        }
    }
    
    public function tenure_checker()
    {
        $data = [
            'page' => [
                'title' => 'Register'
            ],
            'getProbeEmployee' => $this->Users_model->getProbeEmployee()
        ];

        $this->load->view('cgsi_tenurity_checker', $data);
    }

    public function get_direct_head() {
        $data = $this->Users_model->getDirectHeadEmail($_POST);
        if($data) {
            echo json_encode(array('success'=> true, 'data' => $data));
        }
    }

    /**
     * Logout
     * 
     * @return void
     */
    public function logout()
    {
        $rememberToken = get_cookie('_auth', true);
        if ($rememberToken) {
            $checkUser = $this->Users_model->getUserByField([
                'remember_token' => $rememberToken
            ], true);

            if ($checkUser) {
                $this->Users_model->updateUser($checkUser->id, [
                    'remember_token' => null
                ]);
            }

            delete_cookie('_auth');
        }

        if ($this->session->empid) {
            $this->Users_model->updateOTP($this->session->empid,[]);
        }
        

        if ($this->session->has_userdata('username')) {
            $this->session->unset_userdata('username');
        }

        $this->session->set_flashdata('success_message', 'You have logged out.');
        redirect('login');
    }
    
    private function checkAuth()
    {
        if ($this->session->has_userdata('username')) {
            redirect('/');
            die;
        } else {
            $rememberToken = get_cookie('_auth', true);
            if ($rememberToken) {
                $checkUser = $this->Users_model->getUserByField([
                    'remember_token' => $rememberToken
                ], true);

                if ($checkUser) {
                    $this->session->set_userdata('username', $checkUser->username);
                    $this->session->set_flashdata('success_message', 'Welcome back, ' . $checkUser->username . '.');
                    redirect('/');
                    die;
                }
            }
        }
    }
}
