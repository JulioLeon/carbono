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

}