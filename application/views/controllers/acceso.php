<?php
class Acceso extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');
	}
	
	function index()
	{
		$data = array();
		if ($this->agent->browser() == 'Internet Explorer' && $this->agent->version() < 9){
			$data['ie_browser_warning'] = TRUE;
		}else{
			$data['ie_browser_warning'] = FALSE;
		}
		if($this->Employee->is_logged_in()){
			redirect('home');
		}else{
			$this->form_validation->set_rules('location_id', 'lang:login_location_id', 'trim|required|xss_clean');
			$this->form_validation->set_rules('username', 'lang:login_username', 'trim|required|xss_clean|callback_employee_location_check|callback_login_check');
			$this->form_validation->set_rules('password', 'lang:login_password', 'trim|required|xss_clean');
    	    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if($this->form_validation->run() == FALSE){
				$data['location_id'] 	= $this->input->post('location_id') ? $this->input->post('location_id') : '';
				$data['username'] 		= $this->input->post('username') ? $this->input->post('username') : '';
				$this->load->view('acceso/login',$data);
			}else{
				redirect('home');
			}
		}
	}
	
	function login_check($username){
		$password = $this->input->post("password");
		$location_id = $this->input->post("location_id");
		if(!$this->Employee->login($username, $password, $location_id)){
			$this->form_validation->set_message('login_check', lang('login_invalid_username_and_password'));
			return false;
		}
		return true;		
	}
	
	function employee_location_check($username){		
		$employee_id = $this->Employee->get_employee_id($username);
		if ($employee_id){
			$employee_location_count = count($this->Employee->get_authenticated_location_ids($employee_id));
			if ($employee_location_count < 1){
				$this->form_validation->set_message('employee_location_check', lang('login_employee_is_not_assigned_to_any_locations'));
				return false;
			}
		}
		//Didn't find an employee, we can pass validation
		return true;
	}
	
	function cambiar_usuario(){
		
		if($this->input->post('password')){
			if(!$this->Employee->login($this->input->post('username'),$this->input->post('password'))){
				echo json_encode(array('success'=>false,'message'=>lang('login_invalid_username_and_password')));
			}else{
				//Unset location in case the user doesn't have access to currently set location
				$this->session->unset_userdata('employee_current_location_id');
				echo json_encode(array('success'=>true));
			}
		}else{
			foreach($this->Employee->get_all()->result_array() as $row){
				$employees[$row['username']] = $row['first_name'] .' '. $row['last_name'];
			}
			$data['employees']=$employees;
			$this->load->view('acceso/cambiar_usuario',$data);
		}
	}
	
	function recuperar_clave(){
		$this->load->view('acceso/recuperar_clave');
	}
	
	function recuperar_clave_paso_dos(){	
		if($this->input->post('username_or_email')){
			$employee = $this->Employee->get_employee_by_username_or_email($this->input->post('username_or_email'));
			if ($employee){
				$data = array();
				$data['employee'] = $employee;
			    $data['reset_key'] = base64url_encode($this->encrypt->encode($employee->person_id.'|'.(time() + (2 * 24 * 60 * 60))));
			
				$this->load->library('email');
				$config['mailtype'] = 'html';
				$this->email->initialize($config);
				$this->email->from('no-reply@tradesoft.cl', $this->config->item('company'));
				$this->email->to($employee->email); 

				$this->email->subject(lang('login_reset_password'));
				$this->email->message($this->load->view("acceso/recuperar_clave_form_mail",$data, true));	
				$this->email->send();
			
				$data['success']=lang('login_password_reset_has_been_sent');
				$this->load->view('acceso/recuperar_clave',$data);
			}else{
				$data['error']=lang('login_username_or_email_does_not_exist');
				$this->load->view('acceso/recuperar_clave',$data);
			}
		}else{
			$data['error']= lang('common_field_cannot_be_empty');
			$this->load->view('acceso/recuperar_clave',$data);
		}
	}
	
	function recuperar_clave_nueva($key=false){
		if ($key){
			$data = array();
		    list($employee_id, $expire) = explode('|', $this->encrypt->decode(base64url_decode($key)));			
			if ($employee_id && $expire && $expire > time()){
				$employee = $this->Employee->get_info($employee_id);
				$data['username'] = $employee->username;
				$data['key'] = $key;
				$this->load->view('acceso/recuperar_clave_nueva', $data);			
			}
		}
	}
	
	function recuperar_clave_paso_tres($key=false){
		if ($key){
	    	list($employee_id, $expire) = explode('|', $this->encrypt->decode(base64url_decode($key)));
			
			if ($employee_id && $expire && $expire > time()){
				$password = $this->input->post('password');
				$confirm_password = $this->input->post('confirm_password');
				
				if (($password == $confirm_password) && strlen($password) >=8){
					if ($this->Employee->update_employee_password($employee_id, md5($password))){
						$data['success'] = 'Su clave ha sido actualizada.';
						$this->load->view('acceso/login', $data);	
					}
				}else{
					$data = array();
					$employee = $this->Employee->get_info($employee_id);
					$data['username'] = $employee->username;
					$data['key'] = $key;
					$data['error_message'] = lang('login_passwords_must_match_and_be_at_least_8_characters');
					$this->load->view('acceso/recuperar_clave_nueva', $data);
				}
			}
		}
	}
}
?>