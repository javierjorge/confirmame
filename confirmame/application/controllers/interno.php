<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Interno extends CI_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if($this->validarLogIn()) {
			$this->load->model('Evento');
			$modelEvento =  new Evento();
			$vListEventos = $modelEvento->getMisEventos($this->session->userdata["idUsuario"]);
			
			$this->load->model('Invitacion');
			$modelInvitacion =  new Invitacion();
			$vListInvitaciones = $modelInvitacion->getMisInvitaciones($this->session->userdata["idUsuario"]);
	
			$this->data['nombre'] = $this->session->userdata["nombreUsuario"];
			$this->data['vListEventos'] = $vListEventos;
			$this->data['vListInvitaciones'] = $vListInvitaciones;
			$this->load->view('header_interno');
			$this->load->view('vinicio_interno', $this->data);
			$this->load->view('footer_interno');
		}
		else {
			redirect(base_url(), 'refresh');
		}
	}
	
	private function validarLogIn()
	{
		if (isset($this->session->userdata['logged'])) { 
			return true;
		}	
		else {
			return false;
		}
	}
	
	public function crear_evento()
	{
		$this->data['mensaje'] = "";
		$this->data['nombre'] = $this->session->userdata["nombreUsuario"];
		$this->load->view('header_interno');
		$this->load->view('vcrearevento_interno',$this->data);
		$this->load->view('footer_interno');
	}
	
	public function crear_evento_guardar()
	{
		$this->load->model('Evento');
		$modelEvento =  new Evento();
		$modelEvento->id_usuario = $this->session->userdata["idUsuario"];  // modificar
		$modelEvento->nombre = $this->input->post('nombre');
		$modelEvento->descripcion = $this->input->post('descripcion');
		$modelEvento->fecha = $this->input->post('fecha');
		$modelEvento->hora_desde = $this->input->post('hora_desde');
		$modelEvento->hora_hasta = $this->input->post('hora_hasta');
		$modelEvento->fecha_venc = $this->input->post('fecha_venc');
		$modelEvento->cancelado = 0;
		
		$modelEvento->insert();
		
		$this->editar_evento_invitados($modelEvento->id);
	}
	
	public function editar_evento_invitados($idEvento)
	{
		$this->load->model('Invitacion');
		$modelInvitacion =  new Invitacion();
		$vListInvitaciones = $modelInvitacion->getMisInvitacionesPorEvento($idEvento);
		
		$this->data['id_evento'] = $idEvento;
		$this->data['nombre'] = $this->session->userdata["nombreUsuario"];
		$this->data['vListInvitaciones'] = $vListInvitaciones;
		
		$this->load->model('Contacto');
		$modelContacto =  new Contacto();
		$vListContactos = $modelContacto->getContactosUsuarioNoInvitados($this->session->userdata["idUsuario"], $idEvento);
		$this->data['vListContactos'] = $vListContactos;
			
		$this->load->view('header_interno');
		$this->load->view('vasignarinvitados_interno',$this->data);
		$this->load->view('footer_interno');
	}
	
	public function evento_guardar_invitados()
	{
		$id_evento = $this->input->post('id_evento');
		
		$this->verEvento($id_evento);
	}
	
	public function invitar_gente($id_evento)
	{
		$this->load->model('Evento');
		if($this->validarLogIn()) {
			$modelEvento =  new Evento();
			if($modelEvento->load($id_evento)) {
				if($modelEvento->id_usuario == $this->session->userdata["idUsuario"]) {
					
					// proceso la info
					
					$this->load->model('Contacto');
					$modelContacto =  new Contacto();
					$id_contacto = 0;
					
					if($modelContacto->validarFromEmail($this->input->post('email'), $this->session->userdata["idUsuario"]) == 0) {
						$modelContacto->id_usuario = 0;  
						$modelContacto->id_contacto_de_usuario = $this->session->userdata["idUsuario"];
						$modelContacto->email = $this->input->post('email');
						$modelContacto->nombre = $this->input->post('nombre');
						$modelContacto->apellido = $this->input->post('apellido');
						
						$this->load->model('Usuario');
						$modelUsuario =  new Usuario();
						if($modelUsuario->loadFromEmail($modelContacto->email) == true) {
							$modelContacto->id_usuario = $modelUsuario->id;
						}
						
						$modelContacto->insert();
						$id_contacto = $modelContacto->id;
					}
					
					$this->load->model('Invitacion');
					$modelInvitacion =  new Invitacion();
					
					$modelInvitacion->id_evento = $id_evento;
					$modelInvitacion->id_contacto = $id_contacto;
					
					$modelInvitacion->insert();
					
					$this->load->library('Encrypt');
					$idEncriptado = $this->encrypt->encode($modelInvitacion->id, 'sendmail32');
					
					$invitacion = 'Fue invitado a participar de un evento en tal <a href="'.base_url().'aceptar/'.$idEncriptado.'">confirma</a> o <a href="'.base_url().'noaceptar/'.$idEncriptado.'">no confirma</a> su presencia.';
								
					$this->load->library('email');
			
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
			
					$this->email->from('invitacion@eventuar.com.ar', 'Eventuar');
					$this->email->to($modelContacto->email);  
			
					$this->email->subject($this->session->userdata["nombreUsuario"].' lo esta invitando');
					$this->email->message($invitacion); 
					$this->email->send();
					
					$this->editar_evento_invitados($id_evento);
					
					
				}
			}
			else {
				$this->index();
			}
		}
		else {
			redirect(base_url(), 'refresh');
		}
	}
	
	public function invitar_contacto($id_evento, $id_contacto)
	{
		$this->load->model('Evento');
		if($this->validarLogIn()) {
			$modelEvento =  new Evento();
			if($modelEvento->load($id_evento)) {
				if($modelEvento->id_usuario == $this->session->userdata["idUsuario"]) {
					
					// proceso la info
					
					$this->load->model('Invitacion');
					$modelInvitacion =  new Invitacion();
					
					$modelInvitacion->id_evento = $id_evento;
					$modelInvitacion->id_contacto = $id_contacto;
					
					$modelInvitacion->insert();
					
					$this->load->model('Contacto');
					$modelContacto =  new Contacto();
					$modelContacto->load($id_contacto);
					
					$this->load->library('Encrypt');
					$idEncriptado = $this->encrypt->encode($modelInvitacion->id, 'sendmail32');
					
					$invitacion = 'Fue invitado a participar de un evento en tal <a href="'.base_url().'aceptar/'.$idEncriptado.'">confirma</a> o <a href="'.base_url().'noaceptar/'.$idEncriptado.'">no confirma</a> su presencia.';
								
					$this->load->library('email');
			
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
			
					$this->email->from('invitacion@eventuar.com.ar', 'Eventuar');
					$this->email->to($modelContacto->email);  
			
					$this->email->subject($this->session->userdata["nombreUsuario"].' lo esta invitando');
					$this->email->message($invitacion); 
					$this->email->send();
					
					$this->editar_evento_invitados($id_evento);
					
				
				}
			}
			else {
				$this->index();
			}
		}
		else {
			redirect(base_url(), 'refresh');
		}
	}
	
	public function reenviar_invitacion($id_invitacion)
	{
		$this->load->model('Evento');
		$this->load->model('Invitacion');
					
		if($this->validarLogIn()) {
			$modelInvitacion =  new Invitacion();
			$modelInvitacion->load($id_invitacion);
			$modelEvento =  new Evento();
			if($modelEvento->load($modelInvitacion->id_evento)) {
				if($modelEvento->id_usuario == $this->session->userdata["idUsuario"]) {
					
					// proceso la info
					
					$modelInvitacion->cantidad_enviadas = $modelInvitacion->cantidad_enviadas +1;
					$modelInvitacion->update();
					
					
					$this->load->model('Contacto');
					$modelContacto =  new Contacto();
					$modelContacto->load($modelInvitacion->id_contacto);
					
					$this->load->library('Encrypt');
					$idEncriptado = $this->encrypt->encode($modelInvitacion->id, 'sendmail32');
					
					$invitacion = 'Fue invitado a participar de un evento en tal <a href="'.base_url().'aceptar/'.$idEncriptado.'">confirma</a> o <a href="'.base_url().'noaceptar/'.$idEncriptado.'">no confirma</a> su presencia.';
								
					$this->load->library('email');
			
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
			
					$this->email->from('invitacion@eventuar.com.ar', 'Eventuar');
					$this->email->to($modelContacto->email);  
			
					$this->email->subject($this->session->userdata["nombreUsuario"].' lo esta invitando');
					$this->email->message($invitacion); 
					$this->email->send();
					
					$this->verEvento($modelInvitacion->id_evento);
					
				
				}
			}
			else {
				$this->index();
			}
		}
		else {
			redirect(base_url(), 'refresh');
		}
	}
	
	public function verEvento($id_evento)
	{
		$this->load->model('Evento');
		//$this->load->model('Invitacion');
		//$this->load->model('Contacto');
		
		if($this->validarLogIn()) {
			if($this->validarVista($id_evento, $this->session->userdata["idUsuario"]))
			{
				$modelEvento =  new Evento();
				if($modelEvento->load($id_evento)) {
					$this->load->model('Invitacion');
					$modelInvitacion =  new Invitacion();
					$vListInvitaciones = $modelInvitacion->getMisInvitacionesPorEvento($modelEvento->id);
					
					
					if($modelEvento->id_usuario == $this->session->userdata["idUsuario"]) {
						$this->data['envMail'] = 1;
					} else {
						$this->data['envMail'] = 0;
					}
					
					
					$this->data['nombre'] = $this->session->userdata["nombreUsuario"];
					$this->data['evento'] = $modelEvento;
					$this->data['vListInvitaciones'] = $vListInvitaciones;
					
					$this->load->view('header_interno');
					$this->load->view('vverevento_interno',$this->data);
					$this->load->view('footer_interno');
					
				}
				else {
					$this->index();
				}
			}
			else {
				$this->index();
			}	
		}
		else {
			redirect(base_url(), 'refresh');
		}
	}
	
	public function modificarEvento($id_evento)
	{
		$this->load->model('Evento');
		$modelEvento =  new Evento();
		
		if($this->validarLogIn()) {
			if($modelEvento->load($id_evento)) {
				if($modelEvento->id_usuario == $this->session->userdata["idUsuario"]) {
					$this->data['evento'] = $modelEvento;
					$this->data['nombre'] = $this->session->userdata["nombreUsuario"];
					
					$this->load->view('header_interno');
					$this->load->view('vmodificarevento_interno',$this->data);
					$this->load->view('footer_interno');
				}
				else 
				{
					$this->index();
				}	
			}	
			else {
				$this->index();
			}
		}
		else {
			redirect(base_url(), 'refresh');
		}
	}
	
	public function modificar_evento_guardar()
	{
		$this->load->model('Evento');
		$modelEvento =  new Evento();
		if($modelEvento->load($this->input->post('id_evento')))
		{
			$modelEvento->nombre = $this->input->post('nombre');
			$modelEvento->descripcion = $this->input->post('descripcion');
			$modelEvento->fecha = $this->input->post('fecha');
			$modelEvento->hora_desde = $this->input->post('hora_desde');
			$modelEvento->hora_hasta = $this->input->post('hora_hasta');
			$modelEvento->fecha_venc = $this->input->post('fecha_venc');
			
			$modelEvento->update();
		}
		
		$this->index();
	}
	
	private function validarVista($id_evento, $id_usuario) {
		return true;
	}
	
	public function cancelarEvento($id_evento) {
		$this->load->model('Evento');
		$modelEvento =  new Evento();
		
		
		if($this->validarLogIn()) {
			if($modelEvento->load($id_evento)) {
				if($modelEvento->id_usuario == $this->session->userdata["idUsuario"]) {
					$modelEvento->cancelado = 1;
					$modelEvento->update();
				}	
			}	
		}
		else {
			redirect(base_url(), 'refresh');
		}
		
		
		$this->index();
	}
	
	public function activarEvento($id_evento) {
		$this->load->model('Evento');
		$modelEvento =  new Evento();
		
		
		if($this->validarLogIn()) {
			if($modelEvento->load($id_evento)) {
				if($modelEvento->id_usuario == $this->session->userdata["idUsuario"]) {
					$modelEvento->cancelado = 0;
					$modelEvento->update();
				}	
			}	
		}
		else {
			redirect(base_url(), 'refresh');
		}
		
		
		$this->index();
	}
	
	public function voyEvento($id_invitacion) {
		$this->load->model('Invitacion');
		$modelInvitacion =  new Invitacion();
		
		
		if($this->validarLogIn()) {
			if($modelInvitacion->load($id_invitacion)) {
				$this->load->model('Contacto');
				$modelContacto =  new Contacto();
				if($modelContacto->load($modelInvitacion->id_contacto))
				{
					if($modelContacto->id_usuario == $this->session->userdata["idUsuario"]) {
						$modelInvitacion->confirma = 1;
						$modelInvitacion->update();
					}
				}	
			}	
		}
		else {
			redirect(base_url(), 'refresh');
		}
		
		
		$this->index();
	}
	
	public function noVoyEvento($id_invitacion) {
		$this->load->model('Invitacion');
		$modelInvitacion =  new Invitacion();
		
		
		if($this->validarLogIn()) {
			if($modelInvitacion->load($id_invitacion)) {
				$this->load->model('Contacto');
				$modelContacto =  new Contacto();
				if($modelContacto->load($modelInvitacion->id_contacto))
				{
					if($modelContacto->id_usuario == $this->session->userdata["idUsuario"]) {
						$modelInvitacion->confirma = 2;
						$modelInvitacion->update();
					}
				}	
			}	
		}
		else {
			redirect(base_url(), 'refresh');
		}
		
		
		$this->index();
	}
	
	
	
	public function contacto()
	{
		$this->load->model('Contacto');
		$modelContacto =  new Contacto();
		$vListContactos = $modelContacto->getContactosUsuario($this->session->userdata["idUsuario"]);
		
		$this->data['nombre'] = $this->session->userdata["nombreUsuario"];
		$this->data['vListContactos'] = $vListContactos;
		$this->load->view('header_interno');
		$this->load->view('vcontacto_interno', $this->data);
		$this->load->view('footer_interno');
		
	}
	
	public function crear_contacto()
	{
		$this->data['mensaje'] = "";
		$this->data['nombre'] = $this->session->userdata["nombreUsuario"];
		$this->load->view('header_interno');
		$this->load->view('vcrearcontacto_interno',$this->data);
		$this->load->view('footer_interno');
	}
	
	public function crear_contacto_guardar()
	{
		$this->load->model('Contacto');
		$modelContacto =  new Contacto();
		
		if($modelContacto->validarFromEmail($this->input->post('email'), $this->session->userdata["idUsuario"]) == 0) {
			$modelContacto->id_usuario = 0;  
			$modelContacto->id_contacto_de_usuario = $this->session->userdata["idUsuario"];
			$modelContacto->email = $this->input->post('email');
			$modelContacto->nombre = $this->input->post('nombre');
			$modelContacto->apellido = $this->input->post('apellido');
			
			$this->load->model('Usuario');
			$modelUsuario =  new Usuario();
			if($modelUsuario->loadFromEmail($modelContacto->email) == true) {
				$modelContacto->id_usuario = $modelUsuario->id;
			}
			
			$modelContacto->insert();
		}
		
		$this->contacto();
	}
	
	public function invitar_registrarse_contacto($id_contacto)
	{
		$this->load->model('Evento');
		$modelEvento =  new Evento();
		
		
		if($this->validarLogIn()) {
			$this->load->model('Contacto');
			$modelContacto =  new Contacto();
			if($modelContacto->load($id_contacto) == 1) {
				if($modelContacto->id_contacto_de_usuario == $this->session->userdata["idUsuario"] && $modelContacto->invitaciones <4)
				{
					$modelContacto->invitaciones = $modelContacto->invitaciones+1;
					$modelContacto->update();
					
					$invitacion = $this->session->userdata["nombreUsuario"].' lo invito a registarse en <a href="'.base_url().'">ihope</a>.';
					
					$this->load->library('email');

					$config['mailtype'] = 'html';
					$this->email->initialize($config);
			
					$this->email->from('invitacion@eventuar.com.ar', 'Eventuar');
					$this->email->to($modelContacto->email);  
			
					$this->email->subject($this->session->userdata["nombreUsuario"].' lo esta invitando a registrase');
					$this->email->message($invitacion); 
					$this->email->send();
					
					$this->contacto();
				}
				else 
				{
					$this->contacto();
				}
			}
			else {
				$this->contacto();
			}
		}
		else {
			redirect(base_url(), 'refresh');
		}
	}
	
	public function salir()
	{
		$this->session->set_userdata('logged', null);
		$this->session->sess_destroy();
		redirect(base_url(), 'refresh');
	}
	
	public function aceptar_invitacion($id_invitacion)
	{
		$code = explode("aceptar/",$_SERVER['REQUEST_URI']);
		$code = $code[1];
		
		$this->load->library('Encrypt');
		$idDecodificado = $this->encrypt->decode($code, 'sendmail32');
		
		$this->load->model('Invitacion');
		$modelInvitacion =  new Invitacion();
		if($modelInvitacion->load($idDecodificado)) {
			$modelInvitacion->confirma = 1;
			$modelInvitacion->update();
		}
		
		$this->load->view('header');
		$this->load->view('vinvitacion_confirmada');
		$this->load->view('footer');
		
		
	}
	
	public function no_aceptar_invitacion($id_invitacion)
	{
		$code = explode("noaceptar/",$_SERVER['REQUEST_URI']);
		$code = $code[1];
		
		$this->load->library('Encrypt');
		$idDecodificado = $this->encrypt->decode($code, 'sendmail32');
		
		$this->load->model('Invitacion');
		$modelInvitacion =  new Invitacion();
		if($modelInvitacion->load($idDecodificado)) {
			$modelInvitacion->confirma = 2;
			$modelInvitacion->update();
		}
		
		$this->load->view('header');
		$this->load->view('vinvitacion_no_confirmada');
		$this->load->view('footer');
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */