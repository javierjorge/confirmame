<?php 

class Posibles_usuarios extends CI_Model {

	var $id;
	var $email;
	
    function __construct()
    {
        parent::__construct();
        
        $this->id = 0;
        $this->email = "";
    }
    
	function fillToObject($queryRow)
	{
		$this->id = $queryRow->id;
		$this->email = $queryRow->email;
	}
	
	function load($id){
		$obj = array(
		                  'id'=> $id
	                     );
		$query = $this->db->get_where('posibles_usuarios',$obj);
		
		if($query->num_rows() == 1){
			$this->fillToObject($query->row());
		}
		
		return ($query->num_rows() == 1)? true : false;
	}
	
	
	function insert()
    {
		$this->db->insert('posibles_usuarios', $this);
		$this->id = $this->db->insert_id();
		return $this->db->affected_rows(); 
    }

    function update()
    {
        $this->db->update('posibles_usuarios', $this, array('id' => $this->id));
		return $this->db->affected_rows(); 
    }
	
	function getAll()
	{
		$query = $this->db->query('select * from posibles_usuarios');
        return $query->result();
	}
	
	
}
?>