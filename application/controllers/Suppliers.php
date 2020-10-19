<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('Suppliers_model','suppliers');
	}
	
	public function index()
	{
		$this->permission_check('suppliers_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('suppliers_list');
		$this->load->view('suppliers-list',$data);
	}
	public function add()
	{
		$this->permission_check('suppliers_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('suppliers');
		$this->load->view('suppliers',$data);
	}

	public function newsuppliers(){				
		/*$nombre = $this->input->post('nombre');
		$tipodoc = $this->input->post('tipodoc');
		$nrodoc = $this->input->post('nrodoc');
		$mobile = $this->input->post('mobile');
		$email2 = $this->input->post('email2');
		$phone = $this->input->post('phone');
		$country = $this->input->post('country');
		$state = $this->input->post('state');
		$postcode = $this->input->post('postcode');
		$gstin= $this->input->post('gstin');
		$tax_number = $this->input->post('tax_number');
		$address= $this->input->post(' addres');
		*/				
		$result=$this->suppliers->verify_and_save();
		//;	
		if ($result[0]->nres == '1') {
			$this->session->set_flashdata('success', 'Registro grabado!');
			echo 'success';
		}
		else {
			echo $result[0]->nmsj;
		}
		
							
		
	}
	public function update($id){
		$this->permission_check('suppliers_edit');
		$data=$this->data;
		$result=$this->suppliers->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('suppliers');
		$this->load->view('suppliers', $data);
	}
	public function update_suppliers(){
		$this->form_validation->set_rules('supplier_name', 'Customer Name', 'trim|required');
		//$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		//$this->form_validation->set_rules('state', 'State', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->suppliers->update_suppliers();
			echo $result;
		} else {
			echo "Please Enter suppliers name.";
		}
	}

	public function ajax_list()
	{
		$list = $this->suppliers->get_datatables();
		//print_r($list);exit();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $suppliers) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$suppliers->id.' class="checkbox column_checkbox" >';
			$row[] = $suppliers->supplier_name;
			$row[] = $suppliers->tipodoc;
			$row[] = $suppliers->nrodoc;
			$row[] = $suppliers->mobile;
			$row[] = $suppliers->email;
			/*$row[] = $this->currency($suppliers->purchase_due);*/

			 		if($suppliers->status==1){ 
			 			$str= "<span onclick='update_status(".$suppliers->id.",0)' id='span_".$suppliers->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$suppliers->id.",1)' id='span_".$suppliers->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											if($this->permissions('suppliers_edit'))
											$str2.='<li>
												<a title="Edit Record ?" href="suppliers/update/'.$suppliers->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('suppliers_edit'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_suppliers('.$suppliers->id.')">
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
						"recordsTotal" => $this->suppliers->count_all(),
						"recordsFiltered" => $this->suppliers->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$this->permission_check_with_msg('suppliers_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		$result=$this->suppliers->update_status($id,$status);
		return $result;
	}
	
	public function delete_suppliers(){
		$this->permission_check_with_msg('suppliers_delete');
		$id=$this->input->post('q_id');
		return $this->suppliers->delete_suppliers_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('suppliers_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->suppliers->delete_suppliers_from_table($ids);
	}
	public function loadTipoDoc(){		
		$query = $this->suppliers->select_tipodoc();					
		$cant = count($query);
                    if($cant>0)
                    {
                      echo '<option value="">-Select-</option>'; 
                      foreach($query as $res1)
                      {
                      //$selected = ($nomdoc==$res1->coddoc)? 'selected' : '';
		      //echo "<option $selected value='".$res1->coddoc."'>".$res1->nomdoc."</option>";
		      echo "<option value='$res1->coddoc'>".$res1->nomdoc." </option>";
                      }
                    }
                    else
                    {                      
                      echo "<option value=''>No se encontraron registros</option>";
                    } 
	}

}
