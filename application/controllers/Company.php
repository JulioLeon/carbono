<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('suppliers_model','suppliers');
	}

	public function index(){
		$this->permission_check('company_edit');
		$this->load->model('company_model');
		$data=$this->company_model->get_details();
		$data['page_title']=$this->lang->line('company_profile');
		$this->load->view('company-profile', $data);
	}
	public function update_company(){
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('city', 'city', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$this->load->model('company_model');
			$result=$this->company_model->update_company();
			echo $result;
		} else {
			echo "Please Enter Compulsary(* marked) fields!";
		}
	}

	public function ajax_list()
	{
		$list = $this->suppliers->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $suppliers) {
			$no++;
			$row = array();
			$row[] = $suppliers->supplier_code;
			$row[] = $suppliers->supplier_name;
			$row[] = $suppliers->mobile;
			$row[] = $suppliers->email;
			$row[] = $suppliers->country;
			$row[] = $suppliers->state;
			$row[] = $suppliers->address;

			 		if($suppliers->status==1){ 
			 			$str= "<span onclick='update_status(".$suppliers->id.",0)' id='span_".$suppliers->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$suppliers->id.",1)' id='span_".$suppliers->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
			$row[] = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">
											<li>
												<a title="Update Record ?" href="suppliers/update/'.$suppliers->id.'">
													Update
												</a>
											</li>
											<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_suppliers('.$suppliers->id.')">
													Delete
												</a>
											</li>
											
										</ul>
									</div>';			


			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->suppliers->count_all(),
						"recordsFiltered" => $this->suppliers->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		$this->load->model('suppliers_model');
		$result=$this->suppliers_model->update_status($id,$status);
		return $result;
	}
	public function delete_suppliers(){
		$id=$this->input->post('q_id');
		$this->load->model('suppliers_model');
		$result=$this->suppliers_model->delete_suppliers($id);
		return $result;
	}

}
