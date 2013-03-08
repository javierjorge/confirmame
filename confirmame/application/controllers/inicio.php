<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {

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
		$this->data['mensaje'] = "";
		$this->load->view('header');
		$this->load->view('vinicio',$this->data);
		$this->load->view('footer');
	}
	
	public function logIn()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		$this->load->model('Usuario');
		$modelUsuario =  new Usuario();
			
		if($modelUsuario->loadFromEmail($email) == true) {
		if ($modelUsuario->password == $password) {
				if($modelUsuario->activo == 1) {
					$this->load->helper('cookie');
					$this->session->set_userdata('logged', true);
					$this->session->set_userdata('nombreUsuario', $modelUsuario->nombre." ".$modelUsuario->apellido);
					$this->session->set_userdata('idUsuario', $modelUsuario->id);
					
					redirect(base_url().'interno', 'refresh');
				}
				else {
					$this->data['mensaje'] = "Debe validar su mail.";
					$this->load->view('header');
					$this->load->view('vinicio',$this->data);
					$this->load->view('footer');
				}
			}
			else {
				$this->data['mensaje'] = "La contraseña ingresada no es valida.";
				$this->load->view('header');
				$this->load->view('vinicio',$this->data);
				$this->load->view('footer');
			}
		}
		else {
			$this->data['mensaje'] = "El email ingresado no existe.";
			$this->load->view('header');
			$this->load->view('vinicio',$this->data);
			$this->load->view('footer');
		}		
	}
	
	public function registrarse()
	{
		$this->data['mensaje'] = "";
		$this->load->view('header');
		$this->load->view('vregistro',$this->data);
		$this->load->view('footer');
	}
	
	public function registrarse_guardar()
	{
		$nombre = $this->input->post('nombre');
		$apellido = $this->input->post('apellido');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$repassword = $this->input->post('repassword');
		
		if($this->validarEmail($email))
		{
			if($password == $repassword )
			{
				$this->crearNuevoUsuario($nombre, $apellido, $email, $password);
				$this->load->view('header');
				$this->load->view('vregistro_ok');
				$this->load->view('footer');
			}
			else
			{
				$this->data['mensaje'] = "Las contraseñas no coinciden";
				$this->load->view('header');
				$this->load->view('vregistro',$this->data);
				$this->load->view('footer');
			}
		}
		else
		{
			$this->data['mensaje'] = "El formato del mail es incorrecto o ya se encuentra registrado.";
			$this->load->view('header');
			$this->load->view('vregistro',$this->data);
			$this->load->view('footer');
		}
	}
	
	private function validarEmail($email)
	{
		$this->load->model('Usuario');
		$modelUsuario =  new Usuario();
		
		if ($modelUsuario->countByUser($email) > 0) {
			return false;
		}
		else {
			return true;
		}
	}
	
	private function crearNuevoUsuario($nombre, $apellido, $email, $password)
	{
		$this->load->model('Usuario');
		$modelUsuario =  new Usuario();
		
		$modelUsuario->nombre = $nombre;
		$modelUsuario->apellido = $apellido;
		$modelUsuario->email = $email;
		$modelUsuario->password = $password;
		$modelUsuario->activo = false;
		
		$modelUsuario->insert();
		
		
		$this->load->library('Encrypt');
		$idEncriptado = $this->encrypt->encode($modelUsuario->id, 'sendmail32');
		
		$urlConfirmar = " Por favor presione en el siguiente link para <a href='".base_url()."activacion/".$idEncriptado."' >activar el usuario</a>.";
		
		
		// Enviar mail de confirmacion.
		$this->load->library('email');

		$config['mailtype'] = 'html';
		$this->email->initialize($config);

		$this->email->from('alta@eventuar.com.ar', 'Eventuar');
		$this->email->to($modelUsuario->email);  

		$this->email->subject('Confirmar usuario Eventuar.');
		$this->email->message($urlConfirmar); 
		$this->email->send();
		
	}
	
	public function registrarse_confirmar($idconf)
	{
		$code = explode("activacion/",$_SERVER['REQUEST_URI']);
		$code = $code[1];
		
		$this->load->library('Encrypt');
		$idDecodificado = $this->encrypt->decode($code, 'sendmail32');
		
		$this->load->model('Usuario');
		$modelUsuario =  new Usuario();
		$modelUsuario->load($idDecodificado);
		$modelUsuario->activo = true;
		$modelUsuario->update();
		
		$this->load->model('Contacto');
		$modelContacto =  new Contacto();
		$modelContacto->updateMasivo($modelUsuario->email, $modelUsuario->id);
		
		$this->load->helper('cookie');
		$this->session->set_userdata('logged', true);
		$this->session->set_userdata('nombreUsuario', $modelUsuario->nombre." ".$modelUsuario->apellido);
		$this->session->set_userdata('idUsuario', $modelUsuario->id);
		
		redirect(base_url().'interno', 'refresh');
	}
	
	public function contacto()
	{
		$this->load->view('header');
		$this->load->view('vcontacto');
		$this->load->view('footer');
	}
	
	public function contacto_enviar()
	{
		$this->load->view('header');
		$this->load->view('vcontacto');
		$this->load->view('footer');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */