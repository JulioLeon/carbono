<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_info();
	}
	public function index()
	{
		if($this->session->userdata('logged_in')==1){ redirect(base_url().'dashboard','refresh');	}
		$data = $this->data;
		$this->load->view('login',$data);
	}

	 //  agregando seleccion de sucursal
	 
	  public function loadsucu()
	  {
		$this->load->model('login_model');//Model
		$query = $this->login_model->loadsucursal();
		echo "<option value=''>[------ Seleccione sucursal ------]</option>";
		foreach ($query as $row) {
			echo "<option value='".$row->id_sucursal."->".$row->nom_suc."'>".$row->nom_suc."</option>";
		}
		
	  }


	  public function verify()
	  {
		  // $this->form_validation->set_rules('username','Username','required');
		  // $this->form_validation->set_rules('pass','Password','required');
		  // $this->form_validation->set_rules('sucursal','sucursal','required');
		  // if($this->form_validation->run()==FALSE){
		  // // $this->form_validation->set_rules('sucursal','sucursal','required');
		  // 	$this->session->set_flashdata('failed', 'Porfavor se requiere seleccionar todos los campos!');
		  // 	redirect('login');
		  // }
		  // else{
  
			  $username=$this->input->post('username');
			  $password=$this->input->post('pass');
			  $sucursal=$this->input->post('sucursal');
			  $partes = explode("->",$sucursal);
			  
			  $this->load->model('login_model');//Model
			  if($this->login_model->verify_credentials($username,$password))
			  {
				  //Model->Method
				   // inicio mis cambios para al acceso de sucursal
			  
				  if($this->session->userdata('role_id')!=1)
				  {

					  if ($partes[1]==""  ) {
						
						session_destroy();
						redirect('Login');
                     
					  }
					  else{
						  $data = array 
						  (
						  'idsucursal'     => $partes[0],  // ID DE SUCURSAL
						  'sucursal'     => $partes[1], // NOMBRE DE LA SURCURSA ESTO SE VE AL INICIAR COMO VENDEDOR
						  );
						  $this->session->set_userdata($data);
						 
						  redirect(base_url().'dashboard');
					  }
				   }else{
					  $this->session->set_userdata("sucursal")=="";
					  redirect(base_url().'dashboard');
				   }
			  }else{
				$this->session->set_flashdata('failed', 'Usuario / contraseña invalida.');
			  redirect('login');
			  }
  
  
  
				  
			  
			  // else{
			  // 	$this->session->set_flashdata('failed', 'Usuario / contraseña invalida.');
			  // 	redirect('login');
			  // }			
		  
	  }
	public function forgot_password(){
		if($this->session->userdata('logged_in')==1){ redirect(base_url().'dashboard','refresh');	}
		$data = $this->data;
		$this->load->view('forgot-password',$data);
	}
	public function send_otp(){		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('failed', 'Invalid Email!');
			redirect(base_url().'login/forgot_password');
		}
		else{
			$email=$this->input->post('email');
			$this->load->model('login_model');//Model
			if($this->login_model->verify_email_send_otp($email)){//Model->Method
				redirect(base_url().'login/otp');
			}
			else{
				$this->session->set_flashdata('failed', 'Invalid Email!!');
				redirect(base_url().'login/forgot_password');
			}			
		}
	}
	public function otp(){
		if($this->session->userdata('logged_in')==1){ redirect(base_url().'dashboard','refresh');	}
		$data = $this->data;
		$this->load->view('otp',$data);
	}
	public function verify_otp(){
		$this->form_validation->set_rules('otp', 'OTP', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('failed', 'Invalid OTP!');
			redirect(base_url().'login/otp');
		}
		else{
			$otp=$this->input->post('otp');
			$email=$this->input->post('email');
			
			if($this->session->userdata('email')==$email && $this->session->userdata('otp')==$otp){
				$data=$this->data;
				$data['email']=$email;
				$data['otp']=$otp;
				
				$this->load->view("change-login-password",$data);
			}
			else{
				$this->session->set_flashdata('failed', 'Invalid OTP!!');
				redirect(base_url().'login/otp');
			}			
		}
	}
	public function change_password(){

		$this->form_validation->set_rules('otp', 'OTP', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required');
		
		//print_r($_POST);exit;
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('failed', 'Please Enter Correct Passwords!');
			redirect(base_url().'login/verify_otp');
		}
		else{
			$otp=$this->input->post('otp');
			$email=$this->input->post('email');
			$password=$this->input->post('password');
			$cpassword=$this->input->post('cpassword');
			$this->load->model('login_model');//Model
			if($password==$cpassword && $this->session->userdata('email')==$email && $this->session->userdata('otp')==$otp){
				if($this->login_model->change_password($password,$email)){//Model->Method
					$data = $this->data;
					$array_items = array('email','otp');
					$this->session->unset_userdata($array_items);
					$this->session->set_flashdata('success', 'Password Changed Successfully!');
					redirect(base_url().'login','refresh');
				}
				else{
					$this->session->set_flashdata('failed', 'Please Enter Correct Passwords!');
					redirect(base_url().'login/verify_otp');
				}			
			}
		}

	}
	

}
