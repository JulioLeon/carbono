<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sucursal_model extends CI_Model { 
    
    public function load_sucursal()
	{

        $opc = 1;
        $query = $this->db->query(" CALL SP_SUCURSAL($opc,'','','','','',@outsucursal); ");
        //$query = $this->db->query("Select @outsucursal  as mensaje;"); 
        return $query->result(); 
    }    
   
    public function load_tienda()
    {
        $opc = 5;
        $estado = "1";
        $query = $this->db->query(" CALL SP_SUCURSAL2($opc, '','','','".$estado."',@outsucursal);");
        return $query->result();
    }

    public function graba_sucursal($codigo,$nombre,$tienda,$distri,$estado)
    {
        $opc = 2;        
        $this->db->query(" CALL SP_SUCURSAL($opc, '".$codigo."','".$nombre."','".$tienda."','".$distri."','".$estado."',@outsucursal);");
        $query = $this->db->query("SELECT @outsucursal as rpta;");
        return $query->result();
    }

    public function actualiza_sucursal($codigo,$nombre,$tienda,$distri,$estado)
    {
        $opc = 3;
        $this->db->query(" CALL SP_SUCURSAL($opc, '".$codigo."','".$nombre."','".$tienda."','".$distri."','".$estado."',@outsucursal);");
        $query = $this->db->query("SELECT @outsucursal as rpta;");
        return $query->result();
    }
    
}