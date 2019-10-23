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
   
    public function load_tienda()
    {
        $opc = 5;
        $estado = "1";
        $query = $this->db->query(" CALL SP_ALMACEN($opc, '','','','".$estado."',@outalmacen);");
        return $query->result();
    }

    public function graba_almacen($codigo,$nombre,$tienda,$estado)
    {
        $opc = 2;        
        $this->db->query(" CALL SP_ALMACEN($opc, '".$codigo."','".$nombre."','".$tienda."','".$estado."',@outalmacen);");
        $query = $this->db->query("SELECT @outalmacen as rpta;");
        return $query->result();
    }
    
}