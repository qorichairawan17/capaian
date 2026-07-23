<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserManagement extends CI_Controller
{
    private $getAllUsersUseCase;
    private $createUserUseCase;
    private $updateUserUseCase;
    private $deleteUserUseCase;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        // Redirect to login if not logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        // Dependency Resolution (Clean Architecture)
        $this->userRepository = $this->resolveUserRepository();
        $this->getAllUsersUseCase  = new \App\UseCases\GetAllUsersUseCase($this->userRepository);
        $this->createUserUseCase  = new \App\UseCases\CreateUserUseCase($this->userRepository);
        $this->updateUserUseCase  = new \App\UseCases\UpdateUserUseCase($this->userRepository);
        $this->deleteUserUseCase  = new \App\UseCases\DeleteUserUseCase($this->userRepository);
    }

    /**
     * Render the user management page
     */
    public function index()
    {
        // Execute use case to get all users
        $response = $this->getAllUsersUseCase->execute();

        $data = [
            'title'        => 'Kelola Akun Pengguna',
            'content_view' => 'dashboard/user/v_user_management',
            'extra_css'    => [
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/css/user_management.css?v=' . time()
            ],
            'extra_js'     => [
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ],
            'users'         => $response->getUsers(),
            'totalCount'    => $response->getTotalCount(),
            'adminCount'    => $response->getAdminCount(),
            'operatorCount' => $response->getOperatorCount()
        ];

        $this->load->view('dashboard/layouts/body', $data);
    }

    /**
     * Handle create user (POST)
     */
    public function create()
    {
        // Validate form
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('name', 'Nama', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|max_length[100]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,operator]');

        if ($this->form_validation->run() === FALSE) {
            $this->sendJsonResponse(false, strip_tags(validation_errors()), 422);
            return;
        }

        // Map to DTO
        $request = new \App\UseCases\DTO\CreateUserRequest(
            $this->input->post('username', TRUE),
            $this->input->post('password'),
            $this->input->post('name', TRUE),
            $this->input->post('email', TRUE),
            $this->input->post('role', TRUE)
        );

        // Execute use case
        $response = $this->createUserUseCase->execute($request);

        if ($response->isSuccess()) {
            $this->sendJsonResponse(true, 'Pengguna berhasil ditambahkan.');
        } else {
            $this->sendJsonResponse(false, $response->getError(), 422);
        }
    }

    /**
     * Handle update user (POST)
     */
    public function update()
    {
        // Validate form
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'ID', 'required|integer');
        $this->form_validation->set_rules('name', 'Nama', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|max_length[100]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,operator]');

        // Password is optional on update
        $password = $this->input->post('password');
        if (!empty($password)) {
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
        }

        if ($this->form_validation->run() === FALSE) {
            $this->sendJsonResponse(false, strip_tags(validation_errors()), 422);
            return;
        }

        // Map to DTO
        $request = new \App\UseCases\DTO\UpdateUserRequest(
            (int) $this->input->post('id'),
            $this->input->post('name', TRUE),
            $this->input->post('email', TRUE),
            $this->input->post('role', TRUE),
            !empty($password) ? $password : null
        );

        // Execute use case
        $response = $this->updateUserUseCase->execute($request);

        if ($response->isSuccess()) {
            $this->sendJsonResponse(true, 'Pengguna berhasil diperbarui.');
        } else {
            $this->sendJsonResponse(false, $response->getError(), 422);
        }
    }

    /**
     * Handle delete user (POST)
     *
     * @param int $id
     */
    public function delete($id = null)
    {
        if (empty($id) || !is_numeric($id)) {
            $this->sendJsonResponse(false, 'ID pengguna tidak valid.', 400);
            return;
        }

        // Prevent self-deletion
        if ((int) $id === (int) $this->session->userdata('user_id')) {
            $this->sendJsonResponse(false, 'Anda tidak dapat menghapus akun Anda sendiri.', 403);
            return;
        }

        // Execute use case
        $response = $this->deleteUserUseCase->execute((int) $id);

        if ($response->isSuccess()) {
            $this->sendJsonResponse(true, 'Pengguna berhasil dihapus.');
        } else {
            $this->sendJsonResponse(false, $response->getError(), 422);
        }
    }

    /**
     * AJAX endpoint: get single user by ID (for edit modal)
     *
     * @param int $id
     */
    public function get($id = null)
    {
        if (empty($id) || !is_numeric($id)) {
            $this->sendJsonResponse(false, 'ID pengguna tidak valid.', 400);
            return;
        }

        $user = $this->userRepository->findById((int) $id);
        if (!$user) {
            $this->sendJsonResponse(false, 'Pengguna tidak ditemukan.', 404);
            return;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'data'    => [
                    'id'       => $user->getId(),
                    'username' => $user->getUsername(),
                    'name'     => $user->getName(),
                    'email'    => $user->getEmail(),
                    'role'     => $user->getRole()
                ]
            ]));
    }

    /**
     * AJAX endpoint: get all users as JSON (for DataTable refresh)
     */
    public function get_all()
    {
        $response = $this->getAllUsersUseCase->execute();

        if (!$response->isSuccess()) {
            $this->sendJsonResponse(false, $response->getError(), 500);
            return;
        }

        $usersArray = [];
        foreach ($response->getUsers() as $user) {
            $usersArray[] = [
                'id'         => $user->getId(),
                'username'   => $user->getUsername(),
                'name'       => $user->getName(),
                'email'      => $user->getEmail(),
                'role'       => $user->getRole(),
                'created_at' => $user->getCreatedAt()
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success'       => true,
                'data'          => $usersArray,
                'totalCount'    => $response->getTotalCount(),
                'adminCount'    => $response->getAdminCount(),
                'operatorCount' => $response->getOperatorCount()
            ]));
    }

    /**
     * Helper: send JSON response
     *
     * @param bool   $success
     * @param string $message
     * @param int    $statusCode
     */
    private function sendJsonResponse($success, $message, $statusCode = 200)
    {
        $this->output
            ->set_status_header($statusCode)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => $success,
                'message' => $message
            ]));
    }

    /**
     * Resolve UserRepository implementation based on database config availability
     */
    private function resolveUserRepository()
    {
        $dbConfigured = FALSE;

        if (file_exists(APPPATH . 'config/database.php')) {
            include APPPATH . 'config/database.php';

            $activeGroup = isset($active_group) ? $active_group : 'default';
            if (isset($db[$activeGroup]['database']) && !empty($db[$activeGroup]['database'])) {
                $dbConfigured = TRUE;
            }
        }

        if ($dbConfigured) {
            return new \App\Infrastructure\Repositories\DbUserRepository();
        } else {
            return new \App\Infrastructure\Repositories\MockUserRepository();
        }
    }
}
