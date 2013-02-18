<?php
class Photo extends CI_Model {

	var $fonte = '';
    var $link    = '';
    var $ordine   = '';
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    
    function get_last_entries($total = 10)
    {
    	$q  = "   SELECT *"
		    . "     FROM photos"
		    . " ordine BY ordine ASC"
		    . "    LIMIT " . $total;
		    
		$query = $this->db->query($q);
		return $query->result();
    }

    
    function insert_entry($link, $ordine = '', $fonte = '')
    {
        $this->link     = $link;
        $this->ordine   = (isset($ordine) ? $ordine : 0);
        $this->fonte    = (isset($fonte) ? $fonte : '');
        $result = $this->db->insert('photos', $this);        
        return $this->db->insert_id();
    }

    
    function update($id_photo, $link, $fonte = '')
    {
       	$data = array(
            'link'  => $link
        );
        if ($fonte != '') {
        	$data['fonte'] = $fonte;
        }
		$this->db->where('id_photo', $id_photo);
		$this->db->update('photos', $data); 
    }
    
    function delete($id_photo)
    {
		$this->db->where('id_photo', $id_photo);
		$this->db->delete('photos'); 
    }    
    
    function count_all() {
		return $this->db->count_all('photos');
    }
    
	function get_photos($num, $offset, $withordine = false) {
		$q  = "SELECT *"
		    . "  FROM photos";
		if ($withordine) {
			$q .= " ORDER BY ordine ASC";
		} else {
			$q .= " ORDER BY rand()";
		}
		
		if ($offset) {
			$q .= " LIMIT " . $offset . ", " . $num; 		
		} else {
			$q .= " LIMIT " . $num;
		}
		
		$query = $this->db->query($q);
		return $query->result();
	}
    
	function get_photo($idPhoto) {
		$q  = "SELECT *"
		    . "  FROM photos"
		    . " WHERE id_photo = " . $idPhoto;
		$query = $this->db->query($q);
		return $query->row();
	} 	
	
    
	function get_photo_extension($idPhoto) {
		$q  = "SELECT *"
		    . "  FROM photos"
		    . " WHERE id_photo = " . $idPhoto;
		$query = $this->db->query($q);
		$result = $query->row();		
		$extension = substr($result->link, -4); 
		return $extension;
	} 		
}