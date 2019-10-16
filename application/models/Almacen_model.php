<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Almacen_model extends CI_Model { 
    
    public function load_almacen()
	{

        $opc = 1;
        $query = $this->db->query(" CALL SP_ALMACEN($opc,'','','','',@outalmacen); ");
        //$query = $this->db->query("Select @outalmacen  as mensaje;"); 
        return $query->result(); 
    }    
   

    
}