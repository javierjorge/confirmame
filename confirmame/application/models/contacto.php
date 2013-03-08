<?php 

class Contacto extends CI_Model {

	var $id;
	var $id_usuario;
	var $id_contacto_de_usuario;
	var $email;
	var $nombre;
	var $apellido;
	var $invitaciones;
	
    function __construct()
    {
        parent::__construct();
        
        $this->id = 0;
        $this->id_usuario = 0;
        $this->id_contacto_de_usuario = 0;
        $this->nombre = "";
        $this->apellido = "";
        $this->email = "";
        $this->invitaciones = 0;
    }
    
	function fillToObject($queryRow)
	{
		$this->id = $queryRow->id;
        $this->id_usuario = $queryRow->id_usuario;
        $this->id_contacto_de_usuario = $queryRow->id_contacto_de_usuario;
		$this->nombre = $queryRow->nombre;
		$this->apellido = $queryRow->apellido;
		$this->email = $queryRow->email;
        $this->invitaciones = $queryRow->invitaciones;
	}
	
	function load($id){
		$obj = array(
		                  'id'=> $id
	                     );
		$query = $this->db->get_where('contacto',$obj);
		
		if($query->num_rows() == 1){
			$this->fillToObject($query->row());
		}
		
		return ($query->num_rows() == 1)? true : false;
	}
	
	function validarFromEmail($email, $id_contacto_de_usuario) {
		$obj = array(
		                  'email'=> $email, 
						  'id_contacto_de_usuario' => $id_contacto_de_usuario
	                     );
		$query = $this->db->get_where('contacto',$obj);
		
		if($query->num_rows() == 1){
			$this->fillToObject($query->row());
		}
			
		return ($query->num_rows() > 0)? true : false;
	}
	
	
	function insert()
    {
		$this->db->insert('contacto', $this);
		$this->id = $this->db->insert_id();
		return $this->db->affected_rows(); 
    }

    function update()
    {
        $this->db->update('contacto', $this, array('id' => $this->id));
		return $this->db->affected_rows(); 
    }
	
	function getContactosUsuario($id_usuario)
	{
		$query = $this->db->query('select * from contacto where id_contacto_de_usuario = '.$id_usuario.';');
        return $query->result();
	}
	
	function getContactosUsuarioNoInvitados($id_usuario, $id_evento)
	{
		$query = $this->db->query('select * from contacto where id_contacto_de_usuario = '.$id_usuario.' and id not in (select id_contacto from invitacion where id_evento = '.$id_evento.')');
        return $query->result();
	}
	
	function getAll()
	{
		$query = $this->db->query('select * from contacto');
        return $query->result();
	}
	
	function updateMasivo($email, $id_usuario)
	{
		$data = array(
               'id_usuario' => $id_usuario,
            );

		$this->db->where('email', $email);
		$this->db->update('contacto', $data); 
		
		// Produces:
		// UPDATE mytable 
		// SET title = '{$title}', name = '{$name}', date = '{$date}'
		// WHERE id = $id
		//$query = $this->db->query('update contacto set id_usuario = '.$id_usuario.' where email = \''.$email.'\';');
        //return $query->result();
	}
	
	
	
	
}
?>