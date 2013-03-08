<?php 

class Evento extends CI_Model {

	var $id;
	var $id_usuario;
	var $nombre;
	var $descripcion;
	var $fecha;
	var $hora_desde;
	var $hora_hasta;
	var $fecha_venc;
	var $cancelado;
	
    function __construct()
    {
        parent::__construct();
        
        $this->id = 0;
		$this->id_usuario = 0;
        $this->nombre = "";
        $this->descripcion = "";
        $this->fecha = "";
        $this->hora_desde = "";
        $this->hora_hasta = "";
        $this->fecha_venc = "";
        $this->cancelado = 0;
    }
    
	function fillToObject($queryRow)
	{
		$this->id = $queryRow->id;
		$this->id_usuario = $queryRow->id_usuario;
        $this->nombre = $queryRow->nombre;
        $this->descripcion = $queryRow->descripcion;
        $this->fecha = $queryRow->fecha;
        $this->hora_desde = $queryRow->hora_desde;
        $this->hora_hasta = $queryRow->hora_hasta;
        $this->fecha_venc = $queryRow->fecha_venc;
        $this->cancelado = $queryRow->cancelado;
	}
	
	function load($id){
		$obj = array(
		                  'id'=> $id
	                     );
		$query = $this->db->get_where('evento',$obj);
		
		if($query->num_rows() == 1){
			$this->fillToObject($query->row());
		}
		
		return ($query->num_rows() == 1)? true : false;
	}
	
	
	function insert()
    {
		$this->db->insert('evento', $this);
		$this->id = $this->db->insert_id();
		return $this->db->affected_rows(); 
    }

    function update()
    {
        $this->db->update('evento', $this, array('id' => $this->id));
		return $this->db->affected_rows(); 
    }
	
	function getMisEventos($id_usuario)
	{
		$query = $this->db->query('select * from evento where id_usuario = '.$id_usuario);
        return $query->result();
	}
	
	function getAll()
	{
		$query = $this->db->query('select * from evento');
        return $query->result();
	}
	
	
}
?>