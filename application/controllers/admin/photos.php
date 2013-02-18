<?php
class photos extends CI_Controller {
	
	var $data;

	function __construct() {
		parent::__construct();
		$this->load->database();	
		$this->load->library('form_validation');
		$this->load->helper('html');
		$this->config->load('photos');		
		$this->data['active'] = 'photos';
    
		if (!$this->redux_auth->logged_in()) {
			redirect('admin/account/logout');
		} else {
			$user = $this->redux_auth->getUser();					 
			$this->data['username'] = $user->username;
		}
			
	}
	
	function index() {	
		
		$this->load->library('pagination');
		$this->load->library('table');
			
	    $config['base_url']		= $this->config->item('base_url') . '/admin/photos/page';
   		$config['total_rows'] = $this->photo->count_all();
   		$config['per_page'] = 50;
   		$config['full_tag_open'] = '<p class="pagination">';
   		$config['full_tag_close'] = '</p>';
		$config['uri_segment'] = 4;
			
		$this->pagination->initialize($config);
		
		if ($this->uri->segment(4)) {
			$offset = $this->uri->segment(4);
		} else {
			$offset = 0;
		}
   		//load the model and get results
   		$this->data['photos'] = $this->photo->get_photos($config['per_page'],$offset, true);
			
		$this->load->view('admin/header');
		$this->load->view('admin/menu', $this->data);
		$this->load->view('admin/photos/index', $this->data);
		$this->load->view('admin/footer');
			
	}
	
	function add() {
		
		$this->load->helper('file');
		$this->load->library('image_lib');
		
		$config['image_library'] = 'gd2';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		
		$this->form_validation->set_rules('links', 'Links', 'required');	
		
		if ($this->form_validation->run() == true) {
			$photos = $this->input->post('photos'); 
			$fonte = $this->data['fonte'] = $photo->fonte;
			
			foreach ($photos as $link) {
				if (strpos($link, 'http://') !== false) {
					
					$config['source_image'] = '';
					$config['width'] = '';
					$config['maintain_ratio'] = TRUE;
					$config['thumb_marker'] = '';
					$config['new_image'] = '';
					$config['x_axis'] = 0; 
					$config['y_axis'] = 0;
					
					$lastId = $this->photo->insert_entry($link, rand(0, 10000), $fonte);
					
					$extension = substr($link, -4);
					if ($extension == 'jpeg') {
						$extension = '.jpg';
					}
					// salvo l'immagine
					$file = file_get_contents($link);	
					$filename = $this->config->item('path') . $lastId . $extension;
					write_file($filename, $file, 'a+');
					
					list($width, $height, $type, $attr) = getimagesize($filename);
					
					$config['source_image'] = $filename;
					
					// Se l'immagine è più grande di 800x600 la resizo e salvo
					if ($width > $this->config->item('maxWidth')) {											
						$config['width'] = $this->config->item('maxWidth');
						$config['height'] = $this->config->item('maxHeight');
						$config['maintain_ratio'] = TRUE;
						$config['thumb_marker'] = '_resize';
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						$this->image_lib->clear();
					}
					
					$config['thumb_marker'] = '';
					
					$config['new_image'] = $this->config->item('path') . 'thumbs/' . $lastId . $extension;
					$config['width'] = $this->config->item('width');
					$config['height'] = $this->config->item('height');
					$config['x_axis'] = round($width/2 - $this->config->item('width')/2); 
					$config['y_axis'] = round($height/2 - $this->config->item('height')/2);
					$config['maintain_ratio'] = FALSE;

					$this->image_lib->initialize($config);
					
					if ( ! $this->image_lib->crop()) {
					    echo $this->image_lib->display_errors();
					}
					$this->image_lib->clear();					
				}
			}				
			redirect('/admin/photos');
			
		} else {
			
			$this->load->view('admin/header');
			$this->load->view('admin/menu', $this->data);
			$this->load->view('admin/photos/add');
			$this->load->view('admin/footer');
			
		}		
	}
	
	function delete() {
		
		if ($this->input->post('invio')) {
							
			// Cancellazione logica della foto
			if ($this->input->post('invio') == 'Yes') {
				$idphoto = $this->input->post('id_photo');
				$extension = $this->photo->get_photo_extension($idphoto);

				unlink($this->config->item('path') . $idphoto . $extension);
				unlink($this->config->item('path') . 'thumbs/' . $idphoto . $extension);
				if (file_exists($this->config->item('path') . $idphoto . '_resize' . $extension )) {
					unlink($this->config->item('path') . $idphoto . '_resize' . $extension);
				}
				
				$this->photo->delete($this->input->post('id_photo'));
			}
			redirect('/admin/photos');
			
		} else {
			$this->load->view('admin/header');
			$photo = $this->photo->get_photo($this->uri->segment(5));		
			$this->data['link'] = '/var/files/thumbs/' . $photo->id_photo . substr($photo->link, -4);
			$this->data['id_photo'] = $photo->id_photo;
			$this->load->view('admin/menu', $this->data);
			$this->load->view('admin/photos/delete', $this->data);
			$this->load->view('admin/footer');				
		}
		
	}
	
	
	function edit() {
		
		$this->form_validation->set_rules('links', 'Links', 'required');	
				
		if ($this->form_validation->run() == true) {
			$this->photo->update($this->input->post('id_photo'), $this->input->post('links'), $this->input->post('fonte'));
			redirect('/admin/photos');
		} else {
			$this->load->view('admin/header');
			$photo = $this->photo->get_photo($this->uri->segment(5));			
			$this->data['fonte'] = $photo->fonte;
			$this->data['link'] = $photo->link;
			$this->data['id_photo'] = $photo->id_photo;
			$this->load->view('admin/menu', $this->data);
			$this->load->view('admin/photos/edit', $this->data);
			$this->load->view('admin/footer');			
		}
	}
	
	function htmlextractor() {
		
		$html = str_replace("\n", '', $this->input->post('html'));

		// Estraggo tutti i tag img dall'html
		preg_match_all('/<img[^>]+>/i', $html, $result); 
		
		if (count($result[0]) > 0) {
			$img = array();
			$imgFinal = array();
			$i = 0;
			foreach ($result[0] as $img_tag) {
			    preg_match_all('/(src)=("[^"]*")/i', $img_tag, $img);
			    $imgFinal[] = $img[0][0];
			    $i++;
			}
			$imgFinal = array_unique($imgFinal);
			$ret = "";
			foreach ($imgFinal as $img) {
				$img = str_replace('src="', '', $img);
				$img = str_replace('"', '', $img);
				$ret .= $img . "\n";
			}
			$ret = substr($ret, 0, strlen($ret)-1 );
			$firstResult = $ret;
		} else {
			$firstResult = $this->input->post('html');
		}
		
		// Creo un array di link e prendo le immagini con le misure minime
		$arrLinks = split("\n", $firstResult);
		$links = array();

		$this->data['links'] = $arrLinks;
		$this->load->view('admin/photos/thumbs_printer', $this->data);
		
	}
}