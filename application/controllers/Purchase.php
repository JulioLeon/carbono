<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('purchase_model','purchase');
	}

	//INICIO CAMBIOS
	public function ingreso_stock(){
		$almacen = $this->input->post('almacen');
		$codpro = $this->input->post('codpro');
		$moneda = $this->input->post('monbas');
		$cantidad = $this->input->post('cantidad');	
		$pre_uni = $this->input->post('pre_uni');
		$mon_iva = $this->input->post('mon_iva');
		$mon_tot = $this->input->post('mon_tot');
		$tip_doc = $this->input->post('tip_doc');		
		$serie = $this->input->post('ser_doc');
		$num_doc = $this->input->post('num_doc');
		$glosa = $this->input->post('glosa');
		$fec_inp = $this->input->post('fec_inp');
		$fec_vto = $this->input->post('fec_vto');
		$result2 = $this->purchase->agregar_kardex($fec_inp,$almacen,$codpro,$moneda,$cantidad,$pre_uni,$mon_iva,$mon_tot,$tip_doc,$serie,$num_doc,$glosa,$fec_vto);
		if ($result2 == true){
			$result = $this->purchase->agregar_stock($almacen,$codpro,$cantidad);		
		}
		else {
			echo json_encode(2);
		}

		//echo $this->purchase->delete_purchase($ids);		
		//echo json_encode ($result);		
		//echo json_enconde($result);
		// if ($result=="FALSE") {
		// 	$this->purchase->agregar_kardex();
		// 	echo json_encode(1);
	   	// }else
	   	// {
		// 	$this->purchase->agregar_kardex();
		// 	echo json_encode(2);
	   	// }
	}
	public function loadalmacen()
	{
		$result = $this->purchase->getalmacen();
		echo "<option value=''>[Seleccione]</option>";
		foreach ($result as $row){
			echo "<option value='".$row->cod_alm."'>".$row->nom_alm."</option>";
		}
	}
	public function loadmonedas2()
	{
		//print("dentro de controler");
		$result = $this->purchase->loadmoneda();
		echo "<option value=''>[Seleccione]</option>";
       foreach ($result as $row) {
		   echo "<option value='".$row->id."-".$row->currency_name."'>".$row->currency_code."</option>";
	   }
	}


	public function loadcondiciones2()
	{
		$result = $this->purchase->loadcondicion();
		echo "<option value=''>[Seleccione]</option>";
       foreach ($result as $row) {
		   echo "<option value='".$row->id."'>".$row->payment_type."</option>";
	   }
	}

	public function loadneocomprobantes2()
	{
		$result = $this->purchase->loadneocomprobante();
		echo "<option value=''>[Seleccione]</option>";
       foreach ($result as $row) {
		   echo "<option value='".$row->cod_doc."'>".$row->cod_doc." - ".$row->nom_doc."</option>";
	   }
	}

     public function verificarcod2()
	 {
		 $codigo =  $this->input->post('valor');
		 $query = $this->purchase->verycode($codigo);
		 echo "<option value=''>[Seleccione]</option>";
		 foreach ($query as $row) {
			 
			echo "<option value='".$row->serie."'  >".$row->serie."</option>";
		}
	 }

    public function verycorre2()
	{
		$corre =  $this->input->post('corre');
		$query = $this->purchase->verycorrelativo($corre);
		foreach ($query as $row) {
			 
		   echo json_encode($row->correlativo);
		}
		
	}


   //FIN CAMBIOS

	public function index()
	{
		$this->permission_check('purchase_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('purchase_list');
		$this->load->view('purchase-list',$data);
	}
	
	public function add()
	{
		$this->permission_check('purchase_add');
		$data=$this->data;
		//print_r($data);
		$data['page_title']=$this->lang->line('purchase');
		$this->load->view('purchase',$data);
	}

	public function purchase_save_and_update(){
		$this->form_validation->set_rules('pur_date', 'Purchase Date', 'trim|required');
		$this->form_validation->set_rules('supplier_id', 'Supplier Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
	    	$result = $this->purchase->verify_save_and_update();
	    	echo $result;
		} else {
			echo "Los campos con * son requeridos.";
		}
	}
	
	public function update($id){
		$this->permission_check('purchase_edit');
		$data=$this->data;
		$data=array_merge($data,array('purchase_id'=>$id));
		$data['page_title']=$this->lang->line('purchase');
		$this->load->view('purchase', $data);
	}
	
	//adding new item from Modal
	public function newsupplier(){
	
		$this->form_validation->set_rules('supplier_name', 'supplier Name', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
			$this->load->model('suppliers_model');
			$result=$this->suppliers_model->verify_and_save();
			//fetch latest item details
			$res=array();
			$query=$this->db->query("select id,supplier_name from db_suppliers order by id desc limit 1");
			$res['id']=$query->row()->id;
			$res['supplier_name']=$query->row()->supplier_name;
			$res['result']=$result;
			
			echo json_encode($res);

		} 
		else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function ajax_list()
	{
		$list = $this->purchase->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $purchase) {
			
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$purchase->id.' class="checkbox column_checkbox" >';
			$row[] = show_date($purchase->purchase_date);
			$row[] = $purchase->purchase_code;
			$row[] = $purchase->purchase_status;
			$row[] = $purchase->reference_no;
			$row[] = $purchase->supplier_name;
			// $row[] = $purchase->addmoneda2;
			/*$row[] = $purchase->warehouse_name;*/
			$row[] = $this->currency($purchase->grand_total);
			$row[] = $this->currency($purchase->paid_amount);
					$str='';
					if($purchase->payment_status=='Unpaid')
			          $str= "<span class='label label-danger' style='cursor:pointer'>Pendiente </span>";
			        if($purchase->payment_status=='Partial')
			          $str="<span class='label label-warning' style='cursor:pointer'> Parcial </span>";
			        if($purchase->payment_status=='Paid')
			          $str="<span class='label label-success' style='cursor:pointer'> Pagado </span>";

			$row[] = $str;
			$row[] = ucfirst($purchase->created_by);
					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';
											if($this->permissions('purchase_view'))
											$str2.='<li>
												<a title="View Invoice" href="purchase/invoice/'.$purchase->id.'" ><i class="fa fa-fw fa-eye text-blue"></i>View Purchase
												</a>
											</li>';

											if($this->permissions('purchase_edit'))
											$str2.='<li>
												<a title="Update Record ?" href="purchase/update/'.$purchase->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('purchase_payment_view'))
											$str2.='
											<li>
												<a title="Pay" class="pointer" onclick="view_payments('.$purchase->id.')" >
													<i class="fa fa-fw fa-money text-blue"></i>View Payments
												</a>
											</li>';

											if($this->permissions('purchase_payment_add'))
											$str2.='<li>
												<a title="Pay" class="pointer" onclick="pay_now('.$purchase->id.')" >
													<i class="fa fa-fw  fa-hourglass-half text-blue"></i>Pay Now
												</a>
											</li>';

											if($this->permissions('purchase_add') || $this->permissions('purchase_edit'))
											$str2.='<li>
												<a title="Update Record ?" target="_blank" href="purchase/print_invoice/'.$purchase->id.'">
													<i class="fa fa-fw fa-print text-blue"></i>Print
												</a>
											</li>
											<li>
												<a title="Update Record ?" target="_blank" href="purchase/pdf/'.$purchase->id.'">
													<i class="fa fa-fw fa-file-pdf-o text-blue"></i>PDF
												</a>
											</li>';

											if($this->permissions('purchase_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_purchase(\''.$purchase->id.'\')">
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
						"recordsTotal" => $this->purchase->count_all(),
						"recordsFiltered" => $this->purchase->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function delete_purchase(){
		$this->permission_check_with_msg('purchase_delete');
		$id=$this->input->post('q_id');
		echo $this->purchase->delete_purchase($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('purchase_delete');
		$ids=implode (",",$_POST['checkbox']);
		echo $this->purchase->delete_purchase($ids);
	}


	//Table ajax code
	public function search_item(){
		$q=$this->input->get('q');
		$result=$this->purchase->search_item($q);
		echo $result;
	}
	public function find_item_details(){
		$id=$this->input->post('id');
		
		$result=$this->purchase->find_item_details($id);
		echo $result;
	}

	//Purchase invoice form
	public function invoice($id)
	{
		if(!$this->permissions('purchase_add') && !$this->permissions('purchase_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('purchase_id'=>$id));
		$data['page_title']=$this->lang->line('purchase_invoice');
		$this->load->view('pur-invoice',$data);
	}
	
	//Print Purchase invoice 
	public function print_invoice($purchase_id)
	{
		if(!$this->permissions('purchase_add') && !$this->permissions('purchase_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('purchase_id'=>$purchase_id));
		$data['page_title']=$this->lang->line('purchase_invoice');
		$this->load->view('print-purchase-invoice',$data);
	}
	public function pdf($purchase_id)
	{
		if(!$this->permissions('purchase_add') && !$this->permissions('purchase_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('purchase_id'=>$purchase_id));
		$data['page_title']=$this->lang->line('purchase_invoice');
		$this->load->view('print-purchase-invoice',$data);

		mb_internal_encoding('UTF-8');

		// Get output html
        $html = $this->output->get_output();
        // Load pdf library
        $this->load->library('pdf');
        
        // Load HTML content
        $this->dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');/*landscape or portrait*/
        
        // Render the HTML as PDF
        $this->dompdf->render();
        
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("Purchase_invoice_$purchase_id", array("Attachment"=>0));
	}


	//Purchase Barcode image
	public function barcode_image($item_code)
	{
		$this->load->library('zend');
	    $this->zend->load('Zend/Barcode');
	    Zend_Barcode::render('code39', 'image', array('text' => $item_code), array());
	}


	public function return_row_with_data($rowcount,$item_id){
		echo $this->purchase->get_items_info($rowcount,$item_id);
	}
	public function return_purchase_list($purchase_id){
		echo $this->purchase->return_purchase_list($purchase_id);
	}
	public function delete_payment(){
		$this->permission_check_with_msg('purchase_payment_delete');
		$payment_id = $this->input->post('payment_id');
		echo $this->purchase->delete_payment($payment_id);
	}

	public function show_pay_now_modal(){
		$this->permission_check_with_msg('purchase_view');
		$purchase_id=$this->input->post('purchase_id');
		echo $this->purchase->show_pay_now_modal($purchase_id);
	}

	public function save_payment(){
		$this->permission_check_with_msg('purchase_add');
		echo $this->purchase->save_payment();
	}
	
	public function view_payments_modal(){
		$this->permission_check_with_msg('purchase_view');
		$purchase_id=$this->input->post('purchase_id');
		echo $this->purchase->view_payments_modal($purchase_id);
	}
	
}
