<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobantes_model extends CI_Model { 
    
    public function load_comprobantes()
	{

        $opc = 1;
        $query = $this->db->query(" CALL SP_COMPROBANTES($opc,'','','','','','',@outcomprobantes); ");
        //$query = $this->db->query("Select @outcomprobantes  as mensaje;"); 
        return $query->result(); 
    }    
   
    public function load_tienda()
    {
        $opc = 5;
        $estado = "1";
        $query = $this->db->query(" CALL SP_COMPROBANTES($opc, '','','','','','".$estado."',@outcomprobantes);");
        return $query->result();
    }

    public function graba_comprobantes($codigo,$nombre,$tienda,$estado)
    {
        $opc = 2;        
        $this->db->query(" CALL SP_COMPROBANTES($opc, '".$codigo."','".$nombre."','".$tienda."','".$estado."',@outcomprobantes);");
        $query = $this->db->query("SELECT @outcomprobantes as rpta;");
        return $query->result();
    }

    public function actualiza_comprobantes($codigo,$nombre,$tienda,$estado)
    {
        $opc = 3;
        $this->db->query(" CALL SP_COMPROBANTES($opc, '".$codigo."','".$nombre."','".$tienda."','".$estado."',@outcomprobantes);");
        $query = $this->db->query("SELECT @outcomprobantes as rpta;");
        return $query->result();
    }
    
}