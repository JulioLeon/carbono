<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Almacen extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
        //$this->load->model('items_model','items');
        $this->load->model('Almacen_model');
    }
    public function index()
	{
		$this->permission_check('items_view');
		$data=$this->data;
        //$data['page_title']=$this->lang->line('items_list');
        $data['page_title']='Almacenes';
		$this->load->view('almacen',$data);
	}
	public function add()
	{
		$this->permission_check('items_add');
		$data=$this->data;
        //$data['page_title']=$this->lang->line('items');
        $data['page_title']='Almacenes';
		$this->load->view('items',$data);
	}


    public function ajax_list()
	{
        //$list = $this->items->get_datatables();
		$list = $this->Almacen_model->load_almacen();
		echo json_encode($list);
		                		
	}

	public function tiendas ()
	{
		$consulta = $this->Almacen_model->load_tienda();
		echo "<option value=''> --[ Seleccione ]--</option>";
		foreach ($consulta as $data) 
		{
			echo "<option value='$data->id_sucursal'>".$data->nom_suc."</option>";
		}
	}

	public function crea_almacen ()
	{
		$codigo = $this->input->post('codigo');
		$nombre = $this->input->post('nombre');
		$tienda = $this->input->post('tienda');
		$estado = $this->input->post('estado');
		$consulta = $this->Almacen_model->graba_almacen($codigo,$nombre,$tienda,$estado);
		//$rpta = $consulta[0]->rpta;
		//echo $consulta[0]->rpta;
		echo json_encode($consulta[0]->rpta);
	}

}