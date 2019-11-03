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
      

    public function graba_comprobantes($codigo,$nombre,$tipcom,$tipmov)
    {
        $opc = 2;  
        $estado = '1';      
        $this->db->query(" CALL SP_COMPROBANTES($opc, '".$codigo."','".$nombre."','".$tipcom."','".$tipmov."','".$estado."','',@outcomprobantes);");
        $query = $this->db->query("SELECT @outcomprobantes as rpta;");
        return $query->result();
    }

    public function actualiza_comprobante($codigo,$nombre,$tipcom,$tipmov,$estado)
    {
        $opc = 3;
        $this->db->query(" CALL SP_COMPROBANTES($opc, '".$codigo."','".$nombre."','".$tipcom."','".$tipmov."','".$estado."','',@outcomprobantes);");
        $query = $this->db->query("SELECT @outcomprobantes as rpta;");
        return $query->result();
    }
    
    public function borra_comprobante($codigo)
    {
        $opc = 4;
        $this->db->query(" CALL SP_COMPROBANTES($opc,'".$codigo."','','','','','',@outcomprobantes);");
        $query = $this->db->query("SELECT @outcomprobantes as rpta;");
        return $query->result();
    }
}