<?php
class Account extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->database();		
		$this->load->library('form_validation');
		$this->load->helper('html');		
	}
	
	function login() {
		
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
			
		if ($this->form_validation->run() == true) {
			$redux = $this->redux_auth->login(
				$this->input->post('email'), 
				$this->input->post('password')
			);
			
			if ($redux == "NOT_ACTIVATED" || $redux == "BANNED" || $redux == "false") {
				redirect('/admin/account/login');
			} else {
				redirect('/admin/photos');
			}
			
		} else {
			if ($this->redux_auth->logged_in()) {
				redirect('/admin/photos/');
			}
			$this->load->view('admin/header');
			$this->load->view('admin/account/login');
			$this->load->view('admin/footer');
		}
	}
	
	function register () {
				
		$this->form_validation->set_rules('username', 	'Username', 		'required');
		$this->form_validation->set_rules('password', 	'Password', 		'required');
		$this->form_validation->set_rules('password2',	'Repeat Password',	'required');
		$this->form_validation->set_rules('email', 		'Email address',    'required|valid_email');
		$this->form_validation->set_rules('question', 	'Secret Question',	'required');
		$this->form_validation->set_rules('answer', 	'Secret Answer',	'required');
		
		if ($this->form_validation->run()) {
			
			// Validation Passed
			$redux = $this->redux_auth->register(
				$this->input->post('username'),
				$this->input->post('password'),
				$this->input->post('email'),
				$this->input->post('question'),
				$this->input->post('answer')
			);
			
			// The reason we put the method into a variable is so we can deal
			// with the different return messages.
			
			// I use a switch statement to deal with the different return
			// messages produced by the registration method.
			die("Non ti puoi registrare!");
			
			switch ($redux) {
				case 'REGISTRATION_SUCCESS':
				case 'REGISTRATION_SUCCESS_EMAIL':
					redirect('/admin/account/registration_complete', 'location');
				break;
				case false:
					redirect('/admin/account/register', 'location');
				break;
			}
		} else {
			$this->load->view('admin/header');
			$this->load->view('admin/account/register');
			$this->load->view('admin/footer');
		}	
	}

	public function registration_complete() {
		$this->load->view('admin/header');
		$this->load->view('admin/account/registration_complete');
		$this->load->view('admin/footer');
	}
	
	public function logout() {
		$this->redux_auth->logout();
		redirect('/admin/account/login');
	}

}
