<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    private $loginUseCase;
    private $isMockMode = FALSE;

    public function __construct()
    {
        parent::__construct();
        
        // Load libraries needed
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');

        // Resolve dependencies (Clean Architecture)
        $userRepository = $this->resolveUserRepository();
        $this->loginUseCase = new \App\UseCases\LoginUseCase($userRepository);
    }

    /**
     * Render the login page
     */
    public function index()
    {
        // If already logged in, redirect to home
        if ($this->session->userdata('logged_in')) {
            redirect('welcome');
        }

        $data['is_mock'] = $this->isMockMode;
        $this->load->view('login/v_login', $data);
    }

    /**
     * Handle login submission
     */
    public function login()
    {
        // If already logged in, redirect to home
        if ($this->session->userdata('logged_in')) {
            redirect('welcome');
        }

        // Set form validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            // Validation failed, reload view
            $data['is_mock'] = $this->isMockMode;
            $this->load->view('login/v_login', $data);
        } else {
            // Map request to DTO
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $loginRequest = new \App\UseCases\DTO\LoginRequest($username, $password);

            // Execute Use Case
            $response = $this->loginUseCase->execute($loginRequest);

            if ($response->isSuccess()) {
                // Set session data
                $user = $response->getUser();
                $sessionData = [
                    'user_id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($sessionData);

                // Set flash message
                $this->session->set_flashdata('success', 'Welcome back, ' . $user->getName() . '!');
                redirect('welcome');
            } else {
                // Login failed, set flash error message
                $this->session->set_flashdata('error', $response->getError());
                redirect('auth');
            }
        }
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }

    /**
     * Resolve UserRepository implementation based on database config availability
     */
    private function resolveUserRepository()
    {
        $dbConfigured = FALSE;
        
        if (file_exists(APPPATH . 'config/database.php')) {
            // Safely check database configuration without attempting connection
            include APPPATH . 'config/database.php';
            
            $activeGroup = isset($active_group) ? $active_group : 'default';
            if (isset($db[$activeGroup]['database']) && !empty($db[$activeGroup]['database'])) {
                $dbConfigured = TRUE;
            }
        }

        if ($dbConfigured) {
            return new \App\Infrastructure\Repositories\DbUserRepository();
        } else {
            $this->isMockMode = TRUE;
            return new \App\Infrastructure\Repositories\MockUserRepository();
        }
    }
}
