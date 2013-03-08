<?php 

class Usuario extends CI_Model {

	var $id;
	var $nombre;
	var $apellido;
	var $email;
	var $password;
	var $activo;
	
    function __construct()
    {
        parent::__construct();
        
        $this->id = 0;
        $this->nombre = "";
        $this->apellido = "";
        $this->email = "";
        $this->password = "";
        $this->activo = false;
    }
    
	function fillToObject($queryRow)
	{
		$this->id = $queryRow->id;
		$this->nombre = $queryRow->nombre;
		$this->apellido = $queryRow->apellido;
		$this->email = $queryRow->email;
		$this->password = $queryRow->password;
		$this->activo = $queryRow->activo;
	}
	
	function load($id){
		$obj = array(
		                  'id'=> $id
	                     );
		$query = $this->db->get_where('usuario',$obj);
		
		if($query->num_rows() == 1){
			$this->fillToObject($query->row());
		}
		
		return ($query->num_rows() == 1)? true : false;
	}
	
	function loadFromEmail($email){
		$obj = array(
		                  'email'=> $email
	                     );
		$query = $this->db->get_where('usuario',$obj);
		
		if($query->num_rows() == 1){
			$this->fillToObject($query->row());
		}
		
		return ($query->num_rows() == 1)? true : false;
	}
	
	function login($mail, $password)
	{
		$obj = array('email'=> $nombre, 'password' => $password);
		$query = $this->db->get_where('usuario',$obj);
		
		if($query->num_rows() == 1){
			$this->fillToObject($query->row());
		}
		
		return ($query->num_rows() == 1)? true : false;
	}
	
	function insert()
    {
		$this->db->insert('usuario', $this);
		$this->id = $this->db->insert_id();
		return $this->db->affected_rows(); 
    }

    function update()
    {
        $this->db->update('usuario', $this, array('id' => $this->id));
		return $this->db->affected_rows(); 
    }
	
	function getAll()
	{
		$query = $this->db->query('select * from usuario');
        return $query->result();
	}
	
	function countByUser($mail)
	{
		$query = $this->db->query('select count(id) as cantidad from usuario where email = \''.$mail.'\'');
        return $query->row()->cantidad;
	}
	
	
}
?>