<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers_model extends CI_Model {

	//Datatable start
	var $table = 'db_suppliers as a';
	var $column_order = array('a.id','a.supplier_name','a.mobile','a.email','a.opening_balance','a.purchase_due','a.status'); //set column field database for datatable orderable
	var $column_search = array('a.id','a.supplier_name','a.mobile','a.email','a.opening_balance','a.purchase_due','a.status'); //set column field database for datatable searchable 
	var $order = array('a.id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{
		$this->db->select($this->column_order);
		$this->db->from($this->table);
		$this->db->from('db_country as b')->where('b.id=a.country_id');
		$this->db->from('db_states as c')->where('c.id=a.state_id');
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	//Datatable end

	//Save Cutomers
	// public function verify_and_save(){
	// 	//Filtering XSS and html escape from user inputs 
	// 	extract($this->security->xss_clean(html_escape(array_merge($this->data,$_REQUEST))));

	// 	//Validate This suppliers already exist or not		
	// 	$query=$this->db->query("select * from db_suppliers where upper(supplier_name)=upper('$supplier_name')");
	// 	if($query->num_rows()>0){
	// 		return "Sorry! This Suppliers Name already Exist.";
	// 	}
	// 	$query2=$this->db->query("select * from db_suppliers where mobile='$mobile'");
	// 	if($query2->num_rows()>0){
	// 		return "Sorry!This Mobile Number already Exist.";;
	// 	}
		
	// 	$qs5="select supplier_init from db_company";
	// 	$q5=$this->db->query($qs5);
	// 	$supplier_init=$q5->row()->supplier_init;

	// 	//Create suppliers unique Number
	// 	$this->db->query("ALTER TABLE db_suppliers AUTO_INCREMENT = 1");
	// 	$qs4="select coalesce(max(id),0)+1 as maxid from db_suppliers";
	// 	$q1=$this->db->query($qs4);
	// 	$maxid=$q1->row()->maxid;																																																														
	// 	$supplier_code=$supplier_init.str_pad($maxid, 4, '0', STR_PAD_LEFT);
	// 	//end

	// 	$query1="insert into db_suppliers(supplier_code,supplier_name,mobile,phone,email,
	// 										country_id,state_id,postcode,address,opening_balance,
	// 										system_ip,system_name,
	// 										created_date,created_time,created_by,status,gstin,tax_number)
	// 										values('$supplier_code','$supplier_name','$mobile','$phone','$email',
	// 										'$country','$state','$postcode','$address','',
	// 										'$SYSTEM_IP','$SYSTEM_NAME',
	// 										'$CUR_DATE','$CUR_TIME','$CUR_USERNAME',1,'$gstin','$tax_number')";
											
	// 	if ($this->db->simple_query($query1)){
	// 			$this->session->set_flashdata('success', 'Success!! New Supplier Added Successfully!');
	// 	        return "success";
	// 	}
	// 	else{
	// 	        return "failed";
	// 	}
		
	// }
	public function verify_and_save($valor01,$valor02,$valor03,$valor04,$valor05,
	$valor06,$valor07,$valor08,$valor09,$valor10,$valor11,$valor12)
	{
		//values('$supplier_code','$supplier_name','$mobile','$phone','$email',
		$SYSTEM_IP,$SYSTEM_NAME,$CUR_DATE,$CUR_TIME,$CUR_USERNAME)";		
		
		$opcion = 2;
		$query = $this->db->query("CALL SP_PROVEEDOR('".$opcion."','','','','','','','','','')");
		return $query->result();
	}

	//Get suppliers_details
	public function get_details($id,$data){
		//Validate This suppliers already exist or not
		$query=$this->db->query("select * from db_suppliers where upper(id)=upper('$id')");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			$query=$query->row();
			$data['q_id']=$query->id;
			$data['supplier_name']=$query->supplier_name;
			$data['mobile']=$query->mobile;
			$data['phone']=$query->phone;
			$data['email']=$query->email;
			$data['country_id']=$query->country_id;
			$data['state_id']=$query->state_id;
			$data['postcode']=$query->postcode;
			$data['address']=$query->address;
			$data['gstin']=$query->gstin;
			$data['tax_number']=$query->tax_number;
			$data['opening_balance']=$query->opening_balance;

			return $data;
		}
	}
	public function update_suppliers(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_REQUEST))));

		//Validate This suppliers already exist or not
		$query=$this->db->query("select * from db_suppliers where upper(supplier_name)=upper('$supplier_name') and id<>$q_id");
		if($query->num_rows()>0){
			return "This suppliers Name already Exist.";
			
		}
		else{
			$query1="update db_suppliers set supplier_name='$supplier_name',mobile='$mobile',phone='$phone',
							email='$email',country_id='$country',state_id='$state',opening_balance='',
							postcode='$postcode',address='$address',gstin='$gstin',tax_number='$tax_number'
							 where id=$q_id";

			if ($this->db->simple_query($query1)){
					$this->session->set_flashdata('success', 'Success!! Supplier Updated Successfully!');
			        return "success";
			}
			else{
			        return "failed";
			}
		}
	}
	public function update_status($id,$status){
        $query1="update db_suppliers set status='$status' where id=$id";
        if ($this->db->simple_query($query1)){
            echo "success";
        }
        else{
            echo "failed";
        }
	}
	
	public function delete_suppliers_from_table($ids){
		$query1="delete from db_suppliers where id in($ids)";
        if ($this->db->simple_query($query1)){
            echo "success";
        }
        else{
            echo "failed";
        }	
	}  	
	public function select_tipodoc(){
		$opcion = 1;
		$query = $this->db->query("CALL SP_PROVEEDOR('".$opcion."','','','','','','','','','')");
		return $query->result();
	}



}
