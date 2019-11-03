<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobantes extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
        //$this->load->model('items_model','items');
        $this->load->model('Comprobantes_model');
    }
    public function index()
	{
		$this->permission_check('items_view');
		$data=$this->data;
        //$data['page_title']=$this->lang->line('items_list');
        $data['page_title']='Comprobantes';
		$this->load->view('comprobantes',$data);
	}
	public function add()
	{
		$this->permission_check('items_add');
		$data=$this->data;
        //$data['page_title']=$this->lang->line('items');
        $data['page_title']='Comprobantes';
		$this->load->view('items',$data);
	}


    public function ajax_list()
	{
        //$list = $this->items->get_datatables();
		$list = $this->Comprobantes_model->load_comprobantes();
		echo json_encode($list);
		                		
	}	

	public function crea_comprobantes ()
	{
		$codigo = $this->input->post('codigo');
		$nombre = $this->input->post('nombre');
		$tipcom = $this->input->post('tipcom');
		$tipmov = $this->input->post('tipmov');
		$consulta = $this->Comprobantes_model->graba_comprobantes($codigo,$nombre,$tipcom,$tipmov);
		//$rpta = $consulta[0]->rpta;
		//echo $consulta[0]->rpta;
		echo json_encode($consulta[0]->rpta);
	}

	public function upd_comprobante()
	{
		$codigo = $this->input->post('codigo');
		$nombre = $this->input->post('nombre');
		$tipcom = $this->input->post('tipcom');
		$tipmov = $this->input->post('tipmov');
		$estado = $this->input->post('estado');
		$consulta = $this->Comprobantes_model->actualiza_comprobante($codigo,$nombre,$tipcom,$tipmov,$estado);		
		echo json_encode($consulta[0]->rpta);
	}

	public function del_comprobante()
	{
		$codigo = $this->input->post('cod');
		$consulta = $this->Comprobantes_model->borra_comprobante($codigo);		
		echo json_encode($consulta[0]->rpta);
	}

}