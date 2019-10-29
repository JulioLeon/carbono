<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sucursal extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
        //$this->load->model('items_model','items');
        $this->load->model('Sucursal_model');
    }
    public function index()
	{
		$this->permission_check('items_view');
		$data=$this->data;
        //$data['page_title']=$this->lang->line('items_list');
        $data['page_title']='Sucursales';
		$this->load->view('sucursal',$data);
	}
	public function add()
	{
		$this->permission_check('items_add');
		$data=$this->data;
        //$data['page_title']=$this->lang->line('items');
        $data['page_title']='Sucursales';
		$this->load->view('items',$data);
	}


    public function ajax_list()
	{
        //$list = $this->items->get_datatables();
		$list = $this->Sucursal_model->load_sucursal();
		echo json_encode($list);
		                		
	}

	public function tiendas ()
	{
		$consulta = $this->Sucursal_model->load_tienda();
		echo "<option value=''> --[ Seleccione ]--</option>";
		foreach ($consulta as $data) 
		{
			echo "<option value='$data->id_sucursal'>".$data->nom_suc."</option>";
		}
	}

	public function crea_sucursal ()
	{
		$codigo = $this->input->post('codigo');
		$nombre = $this->input->post('nombre');
		$tienda = $this->input->post('tienda');
		$estado = $this->input->post('estado');
		$consulta = $this->Sucursal_model->graba_sucursal($codigo,$nombre,$tienda,$estado);
		//$rpta = $consulta[0]->rpta;
		//echo $consulta[0]->rpta;
		echo json_encode($consulta[0]->rpta);
	}

	public function upd_sucursal()
	{
		$codigo = $this->input->post('codigo');
		$nombre = $this->input->post('nombre');
		$tienda = $this->input->post('tienda');
		$estado = $this->input->post('estado');
		$consulta = $this->Sucursal_model->actualiza_sucursal($codigo,$nombre,$tienda,$estado);		
		echo json_encode($consulta[0]->rpta);
	}

}