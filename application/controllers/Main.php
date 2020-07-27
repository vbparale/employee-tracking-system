<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    public function __construct()
    {

        parent::__construct();

        $this->load->library('session');
    }


	public function index()
	{
        if (!isset($this->session->LOGIN_ID)) {
            redirect(base_url('login'));
        }

        $data = array(
            'dhc' => "",
            'hdf' => "",
            'da' => "",
            'vl' => "",
            'rprts' => "",
            'admin' => "",
            'title' => "Employee Tracking System"
        );
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/footer');
    }
    
    public function dhc()
    {
        if (!isset($this->session->LOGIN_ID)) {
            redirect(base_url('login'));
        }

        if(!isset($this->session->module['EHC'])) {
            if ($this->session->ROLE_ID == 6){
                redirect(base_url('vl'));
            }
        }

        $data = array(
            'dhc' => "active",
            'hdf' => "",
            'da' => "",
            'vl' => "",
            'rprts' => "",
            'admin' => "",
            'title' => "Employee Tracking System | Daily Health Check"
        );
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/dhc');
        $this->load->view('templates/footer');
        $this->load->view('pages/dhc_scripts');
    }

    public function hdf()
    {
        if (!isset($this->session->LOGIN_ID)) {
            redirect(base_url('login'));
        }

        if(!isset($this->session->module['HDF'])) {
            redirect(base_url(''));
        }

        $data = array(
            'dhc' => "",
            'hdf' => "active",
            'da' => "",
            'vl' => "",
            'rprts' => "",
            'admin' => "",
            'title' => "Employee Tracking System | Health Declaration Form"
        );
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/hdf');
    }

    public function da()
    {
        if (!isset($this->session->LOGIN_ID)) {
            redirect(base_url('login'));
        }

        if(!isset($this->session->module['DA'])) {
            redirect(base_url(''));
        }

        $data = array(
            'dhc' => "",
            'hdf' => "",
            'da' => "active",
            'vl' => "",
            'rprts' => "",
            'admin' => "",
            'title' => "Employee Tracking System | Daily Activity"
        );
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/daily_activity');
        $this->load->view('templates/footer');
    }

   public function vl()
    {
        if (!isset($this->session->LOGIN_ID)) {
            redirect(base_url('login'));
        }

        if(!isset($this->session->module['VL'])) {
            redirect(base_url(''));
        }

		// load model
		$this->load->model('visitor_model');
        $this->load->helper('form');

        $data = array(
            'dhc' => "",
            'hdf' => "",
            'da' => "",
            'vl' => "active",
            'rprts' => "",
            'admin' => "",
            'title' => "Employee Tracking System | Visitor's Log"
        );
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/vl');
        $this->load->view('templates/footer');
    }

    public function rprts()
    {
        if (!isset($this->session->LOGIN_ID)) {
            redirect(base_url('login'));
        }

        if(!isset($this->session->module['RP'])) {
            redirect(base_url(''));
        }

        $data = array(
            'dhc' => "",
            'hdf' => "",
            'da' => "",
            'vl' => "",
            'rprts' => "active",
            'admin' => "",
            'title' => "Employee Tracking System | Reports"
        );
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/rprts');
        $this->load->view('templates/footer');
    }

    public function login()
    {
        if (isset($this->session->LOGIN_ID)) {
            redirect(base_url('dhc'));
        }

        $data = array(
            'title' => "Employee Tracking System | Login"
        );
        $this->load->view('pages/login', $data);
    }
}