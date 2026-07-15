<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load libraries & helpers
        $this->load->library('session');
        $this->load->helper('url');

        // Redirect to login if not logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    /**
     * Render the dashboard page
     */
    public function index()
    {
        $data = [
            'title' => 'Home',
            'content_view' => 'dashboard/v_home'
        ];
        $this->load->view('dashboard/layouts/body', $data);
    }
}
