<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    private $getStatusUseCase;
    private $runMigrationUseCase;
    private $rollbackMigrationUseCase;

    public function __construct()
    {
        parent::__construct();

        // Load helpers & libraries needed for the presentation layer
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');

        // Resolve dependencies (Clean Architecture)
        $repository = new \App\Infrastructure\Repositories\DbMigrationRepository();
        
        $this->getStatusUseCase = new \App\UseCases\GetMigrationStatusUseCase($repository);
        $this->runMigrationUseCase = new \App\UseCases\RunMigrationUseCase($repository);
        $this->rollbackMigrationUseCase = new \App\UseCases\RollbackMigrationUseCase($repository);
    }

    /**
     * Display migration status dashboard
     */
    public function index()
    {
        $status = $this->getStatusUseCase->execute();
        
        $data['status'] = $status;
        $data['success_message'] = $this->session->flashdata('success');
        $data['error_message'] = $this->session->flashdata('error');

        // Render views
        $this->load->view('migrate/v_migrate', $data);
    }

    /**
     * Run all pending migrations to latest version
     */
    public function latest()
    {
        // Only accept POST requests
        if ($this->input->method() !== 'post') {
            redirect('migrate');
        }

        $response = $this->runMigrationUseCase->execute();

        if ($response->success) {
            $this->session->set_flashdata('success', $response->message);
        } else {
            $this->session->set_flashdata('error', $response->message);
        }

        redirect('migrate');
    }

    /**
     * Migrate or rollback to a specific version
     */
    public function version()
    {
        // Only accept POST requests
        if ($this->input->method() !== 'post') {
            redirect('migrate');
        }

        $version = $this->input->post('version');

        if ($version === null || $version === '') {
            $this->session->set_flashdata('error', 'Target version is required.');
            redirect('migrate');
        }

        $response = $this->rollbackMigrationUseCase->execute($version);

        if ($response->success) {
            $this->session->set_flashdata('success', $response->message);
        } else {
            $this->session->set_flashdata('error', $response->message);
        }

        redirect('migrate');
    }
}
