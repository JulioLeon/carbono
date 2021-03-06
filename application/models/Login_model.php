<?php

/**
 * Author: Askarali Makanadar
 * Date: 05-11-2018
 */
class Login_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	//load sucursales 
    public function loadsucursal()
	{
		$opc = 1;
		$query = $this->db->query("CALL SP_SUCURSAL($opc,'','','','','',@outsucursal);");
		return $query->result();
		
	}




	public function verify_credentials($username,$password)
	{
		//Filtering XSS and html escape from user inputs 
		$username=$this->security->xss_clean(html_escape($username));
		$password=$this->security->xss_clean(html_escape($password));
				
		$query=$this->db->query("select a.id,a.username,a.role_id,b.role_name from db_users a, db_roles b where b.id=a.role_id and  a.username='$username' and a.password='".md5($password)."' and a.status=1");
		if($query->num_rows()==1){

			$logdata = array('inv_username'  => $query->row()->username,
				        	 'inv_userid'  => $query->row()->id,
				        	 'logged_in' => TRUE,
				        	 'role_id' => $query->row()->role_id,
				        	 'role_name' => trim($query->row()->role_name),
				        	);
			$this->session->set_userdata($logdata);
			$this->session->set_flashdata('Realizado', 'Bienvenido '.ucfirst($query->row()->username)." !");
			return true;
		}
		else{
			return false;
		}		
	}
	public function verify_email_send_otp($email)
	{
		$q1=$this->db->query("select email,company_name from db_company where email<>''");
		if($q1->num_rows()==0){
			$this->session->set_flashdata('Error', 'Error al enviar! Contacte con el admin :(');
			return false;
			exit();
		}
		//Filtering XSS and html escape from user inputs 
		$email_id=$this->security->xss_clean(html_escape($email));
				
		$query=$this->db->query("select * from db_users where email='$email' and status=1");
		if($query->num_rows()==1){
			$otp=rand(1000,9999);

			$server_subject = "OTP for Password Change | OTP: ".$otp;
			$ready_message="---------------------------------------------------------
Hola Usuario,


Se solicita el cambio de contraseña,
Por favor ingrese ".$otp.".

Nota: No comparta su contraseña con nadie.

Gracias.
---------------------------------------------------------
		";
		
			$this->load->library('email');
			$this->email->from($q1->row()->email, $q1->row()->company_name);
			$this->email->to($email_id);
			$this->email->subject($server_subject);
			$this->email->message($ready_message);

			if($this->email->send()){
				//redirect('contact/success');
				$this->session->set_flashdata('Exito', 'El cambio a sido enviado a su correo!');
				$otpdata = array('email'  => $email,'otp'  => $otp );
				$this->session->set_userdata($otpdata);
				//echo "Email Sent";
				return true;
			}
			else{
				//echo "Failed to Send Message.Try again!";
				return false;
			}
		}
		else{
			return false;
		}		
	}
	public function verify_otp($otp)
	{
		//Filtering XSS and html escape from user inputs 
		$otp=$this->security->xss_clean(html_escape($otp));
		$email=$this->security->xss_clean(html_escape($email));
		if($this->session->userdata('email')==$email){ redirect(base_url().'logout','refresh');	}
				
		$query=$this->db->query("select * from db_users where username='$username' and password='".md5($password)."' and status=1");
		if($query->num_rows()==1){

			$logdata = array('inv_username'  => $query->row()->username,
				        	 'inv_userid'  => $query->row()->id,
				        	 'logged_in' => TRUE 
				        	);
			$this->session->set_userdata($logdata);
			return true;
		}
		else{
			return false;
		}		
	}
	public function change_password($password,$email){
			$query=$this->db->query("select * from db_users where email='$email' and status=1");
			if($query->num_rows()==1){
				/*if($query->row()->username == 'admin'){
					echo "Restricted Admin Password Change";exit();
				}*/
				$password=md5($password);
				$query1="update db_users set password='$password' where email='$email'";
				if ($this->db->simple_query($query1)){

				        return true;
				}
				else{
				        return false;
				}
			}
			else{
				return false;
				}

		}
}