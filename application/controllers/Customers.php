<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('customers_model','customers');
	}

	public function index()
	{
		$this->permission_check('customers_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('customers_list');
		$this->load->view('customers-view',$data);
	}
	public function add()
	{
		$this->permission_check('customers_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('customers');
		$this->load->view('customers',$data);
	}

	public function newcustomers(){
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
		//$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		//$this->form_validation->set_rules('state', 'State', 'trim|required');

		
		if ($this->form_validation->run() == TRUE) {
			$result=$this->customers->verify_and_save();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	public function update($id){
		$this->permission_check('customers_edit');
		$data=$this->data;
		$result=$this->customers->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('customers');
		$this->load->view('customers', $data);
	}
	public function update_customers(){
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
		//$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');

		if ($this->form_validation->run() == TRUE) {			
			$result=$this->customers->update_customers();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function ajax_list()
	{
		$list = $this->customers->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$customers->id.' class="checkbox column_checkbox" >';
			$row[] = $customers->customer_name;
			$row[] = $customers->mobile;
			$row[] = $customers->email;
			$row[] = $customers->country;
			$row[] = $customers->state;
			$row[] = $customers->address;

			 		if($customers->status==1){ 
			 			$str= "<span onclick='update_status(".$customers->id.",0)' id='span_".$customers->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$customers->id.",1)' id='span_".$customers->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											if($this->permissions('customers_edit'))
											$str2.='<li>
												<a title="Edit Record ?" href="customers/update/'.$customers->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('customers_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_customers('.$customers->id.')">
													<i class="fa fa-fw fa-trash text-red"></i>Delete
												</a>
											</li>
											
										</ul>
									</div>';			
			$row[] = $str2;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->customers->count_all(),
						"recordsFiltered" => $this->customers->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$this->permission_check_with_msg('customers_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		$result=$this->customers->update_status($id,$status);
		return $result;
	}
	
	public function delete_customers(){
		$this->permission_check_with_msg('customers_delete');
		$id=$this->input->post('q_id');
		return $this->customers->delete_customers_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('customers_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->customers->delete_customers_from_table($ids);
	}

}
