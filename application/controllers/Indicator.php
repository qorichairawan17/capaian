<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Indicator Controller (Facade / Proxy)
 *
 * Mengarahkan setiap request indicator ke Controller spesifiknya
 * di folder application/controllers/indicator/ untuk memecah class monolithic
 * dan menjaga Single Responsibility Principle (SRP).
 */
class Indicator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function iku_1_1()
    {
        $this->_forward('Iku_1_1', 'index');
    }

    public function export_iku_1_1()
    {
        $this->_forward('Iku_1_1', 'export');
    }

    public function iku_1_2()
    {
        $this->_forward('Iku_1_2', 'index');
    }

    public function iku_1_3()
    {
        $this->_forward('Iku_1_3', 'index');
    }

    public function iku_1_4()
    {
        $this->_forward('Iku_1_4', 'index');
    }

    public function iku_1_5()
    {
        $this->_forward('Iku_1_5', 'index');
    }

    public function iku_1_6()
    {
        $this->_forward('Iku_1_6', 'index');
    }

    public function iku_1_7()
    {
        $this->_forward('Iku_1_7', 'index');
    }

    public function iku_1_8()
    {
        $this->_forward('Iku_1_8', 'index');
    }

    public function iku_1_9()
    {
        $this->_forward('Iku_1_9', 'index');
    }

    public function iku_1_10()
    {
        $this->_forward('Iku_1_10', 'index');
    }

    public function iku_1_11()
    {
        $this->_forward('Iku_1_11', 'index');
    }

    /**
     * Helper privat untuk meneruskan eksekusi ke Controller indikator yang sesuai.
     *
     * @param string $controllerClass
     * @param string $method
     */
    private function _forward($controllerClass, $method)
    {
        require_once APPPATH . 'controllers/indicator/' . $controllerClass . '.php';
        $instance = new $controllerClass();
        $instance->$method();
    }
}
