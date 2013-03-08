<?php 

class Invitacion extends CI_Model {

	var $id;
	var $id_evento;
	var $id_contacto;
	var $confirma;
	var $cantidad_enviadas;
	
    function __construct()
    {
        parent::__construct();
        
        $this->id = 0;
        $this->id_evento = 0;
        $this->id_contacto = 0;
        $this->confirma = 0;
        $this->cantidad_enviadas = 0;
    }
    
	function fillToObject($queryRow)
	{
		$this->id = $queryRow->id;
        $this->id_evento = $queryRow->id_evento;
        $this->id_contacto = $queryRow->id_contacto;
		$this->confirma = $queryRow->confirma;
        $this->cantidad_enviadas = $queryRow->cantidad_enviadas;
	}
	
	function load($id){
		$obj = array(
		                  'id'=> $id
	                     );
		$query = $this->db->get_where('invitacion',$obj);
		
		if($query->num_rows() == 1){
			$this->fillToObject($query->row());
		}
		
		return ($query->num_rows() == 1)? true : false;
	}
	
	
	function insert()
    {
		$this->db->insert('invitacion', $this);
		$this->id = $this->db->insert_id();
		return $this->db->affected_rows(); 
    }

    function update()
    {
        $this->db->update('invitacion', $this, array('id' => $this->id));
		return $this->db->affected_rows(); 
    }
	
	function getAll()
	{
		$query = $this->db->query('select * from invitacion');
        return $query->result();
	}
	
	function getMisInvitaciones($id_usuario)
	{
		$query = $this->db->query('select evento.id as id_evento, invitacion.id, evento.nombre, evento.fecha, evento.hora_desde, evento.hora_hasta, invitacion.confirma from invitacion inner join evento on evento.id = invitacion.id_evento inner join contacto on invitacion.id_contacto = contacto.id where contacto.id_usuario = '.$id_usuario.';');
        return $query->result();
	}
	
	function getMisInvitacionesPorEvento($id_evento)
	{
		$query = $this->db->query('select invitacion.id, contacto.nombre, contacto.apellido, contacto.email, invitacion.confirma, invitacion.cantidad_enviadas from invitacion inner join contacto on invitacion.id_contacto = contacto.id where invitacion.id_evento = '.$id_evento.';');
        return $query->result();
	}
	
	
	function getInvitacionesPorEvento($id_evento)
	{
		$query = $this->db->query('select * from invitacion inner join contacto on invitacion.id_contacto = contacto.id where invitacion.id_evento = '.$id_evento.';');
        return $query->result();
	}
	
	
}
?>