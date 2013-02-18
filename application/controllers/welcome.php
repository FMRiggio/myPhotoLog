<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	var $data;
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->helper('html');
		$this->config->load('photos');
		$this->load->library('session');
	}
	
	public function index() {
		
		$photos = $this->photo->get_photos(25, 0);

		$dati = array(
                   'limit'  => 5,
                   'offset' => 25
               );

		$this->session->set_userdata($dati);

		$this->data['photos'] = $photos;
		
		$this->load->view('header');
		$this->load->view('index', $this->data);
		$this->load->view('footer');
	}
	
	public function retrieve_offset() {
		echo ($this->session->userdata('offset') + 5);
	}
	
	public function caricamento() {		
		$limit = 5;
		$offset = $this->session->userdata('offset') + $limit;
		$photos = $this->photo->get_photos($limit, $offset, true);
		
		$dati = array(
                   'limit'  => $limit,
                   'offset' => $offset
               );

		$this->session->set_userdata($dati);
		$this->load->view('carica_foto', array('photos' => $photos, 'offset' => $offset));
	}
	
	public function fbshare() {
		$idphoto = $this->uri->segment(3);		
		$this->load->model('photo');
		$photo = $this->photo->get_photo($idphoto);
		$extension = substr($photo->link, -4);
		if ($extension == 'jpeg') {
			$extension = '.jpg';
		}			
		
		$dati['link_img'] = $this->config->item('base_url') . 'var/files/' . $photo->id_photo . $extension;
		$this->load->view('fbshare', $dati);
	}
	
	public function fonte() {
		$idphoto = $this->uri->segment(3);		
		$this->load->model('photo');
		$photo = $this->photo->get_photo($idphoto);
		redirect($photo->fonte);
		return;
	}	
}