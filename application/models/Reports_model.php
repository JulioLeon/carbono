<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model {

	public function show_sales_report(){
		extract($_POST);

		$from_date=date("Y-m-d",strtotime($from_date));
		$to_date=date("Y-m-d",strtotime($to_date));
		
		$this->db->select("a.id,a.sales_code,a.sales_date,b.customer_name,b.customer_code,a.grand_total,a.paid_amount");
	    
		if($customer_id!=''){
			
			$this->db->where("a.customer_id=$customer_id");
		}
		if($view_all=="no"){
			$this->db->where("(a.sales_date>='$from_date' and a.sales_date<='$to_date')");
		}
		$this->db->where("b.`id`= a.`customer_id`");
		$this->db->from("db_sales as a");
		$this->db->from("db_customers as b");
		
		
		//echo $this->db->get_compiled_select();exit();
		
		$q1=$this->db->get();
		if($q1->num_rows()>0){
			$i=0;
			$tot_grand_total=0;
			$tot_paid_amount=0;
			$tot_due_amount=0;
			foreach ($q1->result() as $res1) {
				echo "<tr>";
				echo "<td>".++$i."</td>";
				echo "<td><a title='View Invoice' href='".base_url("sales/invoice/$res1->id")."'>".$res1->sales_code."</a></td>";
				echo "<td>".show_date($res1->sales_date)."</td>";
				echo "<td>".$res1->customer_code."</td>";
				echo "<td>".$res1->customer_name."</td>";
				echo "<td class='text-right'>".number_format($res1->grand_total,2,'.','')."</td>";
				echo "<td class='text-right'>".number_format($res1->paid_amount,2,'.','')."</td>";
				echo "<td class='text-right'>".number_format(($res1->grand_total-$res1->paid_amount),2,'.','')."</td>";
				echo "</tr>";
				$tot_grand_total+=$res1->grand_total;
				$tot_paid_amount+=$res1->paid_amount;
				$tot_due_amount+=($res1->grand_total-$res1->paid_amount);

			}

			echo "<tr>
					  <td class='text-right text-bold' colspan='5'><b>Total :</b></td>
					  <td class='text-right text-bold'>".number_format($tot_grand_total,2,'.','')."</td>
					  <td class='text-right text-bold'>".number_format($tot_paid_amount,2,'.','')."</td>
					  <td class='text-right text-bold'>".number_format($tot_due_amount,2,'.','')."</td>
				  </tr>";
		}
		else{
			echo "<tr>";
			echo "<td class='text-center text-danger' colspan=13>No se encontraron registros</td>";
			echo "</tr>";
		}
		
	    exit;
	}

	public function show_purchase_report(){
		extract($_POST);
		
		$from_date=date("Y-m-d",strtotime($from_date));
		$to_date=date("Y-m-d",strtotime($to_date));
		
		$this->db->select("a.id,a.purchase_code,a.purchase_date,b.supplier_name,b.supplier_code,a.grand_total,a.paid_amount");
	    
		if($supplier_id!=''){
			$this->db->where("a.supplier_id=$supplier_id");
		}
		if($view_all=="no"){
			$this->db->where("(a.purchase_date>='$from_date' and a.purchase_date<='$to_date')");
		}
		$this->db->where("b.`id`= a.`supplier_id`");
		$this->db->from("db_purchase as a");
		$this->db->from("db_suppliers as b");
		
		//echo $this->db->get_compiled_select();
		
		$q1=$this->db->get();
		if($q1->num_rows()>0){
			$i=0;
			$tot_grand_total=0;
			$tot_paid_amount=0;
			$tot_due_amount=0;
			foreach ($q1->result() as $res1) {
				echo "<tr>";
				echo "<td>".++$i."</td>";
				echo "<td><a title='View Invoice' href='".base_url("purchase/invoice/$res1->id")."'>".$res1->purchase_code."</a></td>";
				echo "<td>".show_date($res1->purchase_date)."</td>";
				echo "<td>".$res1->supplier_code."</td>";
				echo "<td>".$res1->supplier_name."</td>";
				echo "<td class='text-right'>".number_format($res1->grand_total,2,'.','')."</td>";
				echo "<td class='text-right'>".number_format($res1->paid_amount,2,'.','')."</td>";
				echo "<td class='text-right'>".number_format(($res1->grand_total-$res1->paid_amount),2,'.','')."</td>";
				echo "</tr>";
				$tot_grand_total+=$res1->grand_total;
				$tot_paid_amount+=$res1->paid_amount;
				$tot_due_amount+=($res1->grand_total-$res1->paid_amount);

			}

			echo "<tr>
					  <td class='text-right text-bold' colspan='5'><b>Total :</b></td>
					  <td class='text-right text-bold'>".number_format($tot_grand_total,2,'.','')."</td>
					  <td class='text-right text-bold'>".number_format($tot_paid_amount,2,'.','')."</td>
					  <td class='text-right text-bold'>".number_format($tot_due_amount,2,'.','')."</td>
				  </tr>";
		}
		else{
			echo "<tr>";
			echo "<td class='text-center text-danger' colspan=13>No se encontraron registros</td>";
			echo "</tr>";
		}
		
	    exit;
	}
	
	public function show_expense_report(){
		extract($_POST);
		$from_date=date("Y-m-d",strtotime($from_date));
		$to_date=date("Y-m-d",strtotime($to_date));

		/*$q1=$this->db->query("SELECT a.*,b.category_name from db_expense as a,db_expense_category as b where b.id=a.category_id and a.expense_date>='$from_date' and expense_date<='$to_date'");*/
		
		$this->db->select("a.*,b.category_name");
	    
		if($category_id!=''){
			$this->db->where("a.category_id=$category_id");
		}
		if($view_all=="no"){
			$this->db->where("(a.expense_date>='$from_date' and a.expense_date<='$to_date')");
		}
		$this->db->where("b.`id`= a.`category_id`");
		$this->db->from("db_expense as a");
		$this->db->from("db_expense_category as b");
		
		//echo $this->db->get_compiled_select();
		
		$q1=$this->db->get();
		
		if($q1->num_rows()>0){
			$i=0;
			$tot_expense_amt=0;
			foreach ($q1->result() as $res1) {
				echo "<tr>";
				echo "<td>".++$i."</td>";
				echo "<td>".$res1->expense_code."</td>";
				echo "<td>".show_date($res1->expense_date)."</td>";
				echo "<td>".$res1->category_name."</td>";
				echo "<td>".$res1->reference_no."</td>";
				echo "<td>".$res1->expense_for."</td>";
				echo "<td class='text-right'>".number_format($res1->expense_amt,2,'.','')."</td>";
				echo "<td>".$res1->note."</td>";
				echo "<td>".ucfirst($res1->created_by)."</td>";
				echo "</tr>";
				$tot_expense_amt+=$res1->expense_amt;
			}
			echo "<tr>
					  <td class='text-right text-bold' colspan='6'><b>Total Expense :</b></td>
					  <td class='text-right text-bold'>".number_format($tot_expense_amt,2,'.','')."</td>
				  </tr>";
		}
		else{
			echo "<tr>";
			echo "<td class='text-center text-danger' colspan=13>No se encontraron registros</td>";
			echo "</tr>";
		}
		
	    exit;
	}
	public function show_stock_report(){
		extract($_POST);

		
		$this->db->select("a.*,b.tax_name");
		$this->db->from("db_items as a,db_tax as b");
		$this->db->where("b.id=a.tax_id");
		$this->db->order_by("a.id");
		
		//echo $this->db->get_compiled_select();exit();
		
		$q1=$this->db->get();
		if($q1->num_rows()>0){
			$i=0;
			/*$tot_grand_total=0;
			$tot_paid_amount=0;
			$tot_due_amount=0;*/
			foreach ($q1->result() as $res1) {
				$tax_type = ($res1->tax_type=='Inclusive') ? 'Inc.' : 'Exc.';
				echo "<tr>";
				echo "<td>".++$i."</td>";
				echo "<td>".$res1->item_code."</td>";
				echo "<td>".$res1->item_name."</td>";
				echo "<td class='text-right'>".number_format($res1->purchase_price,2,'.','')."</td>";
				echo "<td>".$res1->tax_name."[".$tax_type."]</td>";
				echo "<td class='text-right'>".number_format($res1->sales_price,2,'.','')."</td>";
				echo "<td>".$res1->stock."</td>";
				echo "</tr>";
				/*$tot_grand_total+=$res1->grand_total;
				$tot_paid_amount+=$res1->paid_amount;
				$tot_due_amount+=($res1->grand_total-$res1->paid_amount);*/

			}

			/*echo "<tr>
					  <td class='text-right text-bold' colspan='5'><b>Total :</b></td>
					  <td class='text-right text-bold'>".number_format($tot_grand_total,2,'.','')."</td>
					  <td class='text-right text-bold'>".number_format($tot_paid_amount,2,'.','')."</td>
					  <td class='text-right text-bold'>".number_format($tot_due_amount,2,'.','')."</td>
				  </tr>";*/
		}
		else{
			echo "<tr>";
			echo "<td class='text-center text-danger' colspan=13>No se encontraron registros</td>";
			echo "</tr>";
		}
		
	    exit;
	}
	public function show_item_sales_report(){
		extract($_POST);

		$from_date=date("Y-m-d",strtotime($from_date));
		$to_date=date("Y-m-d",strtotime($to_date));
		
		$this->db->select("a.id,a.sales_code,a.sales_date,b.customer_name,b.customer_code,a.grand_total,a.paid_amount");
		$this->db->select("c.sales_qty,d.item_name");
	    
	    
		if($view_all=="no"){
			$this->db->where("(a.sales_date>='$from_date' and a.sales_date<='$to_date')");
		}
//		$this->db->group_by("c.`item_id`");
		$this->db->order_by("a.`sales_date`,a.sales_code",'desc');
		$this->db->from("db_sales as a");
		$this->db->where("a.`id`= c.`sales_id`");
		$this->db->from("db_items as d");
		$this->db->where("d.`id`= c.`item_id`");
		$this->db->from("db_customers as b");
		$this->db->where("b.`id`= a.`customer_id`");
		$this->db->from("db_salesitems as c");
		if($item_id!=''){
			$this->db->where("c.item_id=$item_id");
		}
		
		
		
		//echo $this->db->get_compiled_select();exit();
		
		$q1=$this->db->get();
		if($q1->num_rows()>0){
			$i=0;
			$tot_grand_total=0;
			$tot_paid_amount=0;
			$tot_due_amount=0;
			foreach ($q1->result() as $res1) {
				echo "<tr>";
				echo "<td>".++$i."</td>";
				echo "<td><a title='View Invoice' href='".base_url("sales/invoice/$res1->id")."'>".$res1->sales_code."</a></td>";
				echo "<td>".show_date($res1->sales_date)."</td>";
				echo "<td>".$res1->customer_name."</td>";
				echo "<td>".$res1->item_name."</td>";
				echo "<td>".$res1->sales_qty."</td>";
				echo "<td class='text-right'>".number_format($res1->grand_total,2,'.','')."</td>";
				echo "<td class='text-right'>".number_format($res1->paid_amount,2,'.','')."</td>";
				echo "<td class='text-right'>".number_format(($res1->grand_total-$res1->paid_amount),2,'.','')."</td>";
				echo "</tr>";
				$tot_grand_total+=$res1->grand_total;
				$tot_paid_amount+=$res1->paid_amount;
				$tot_due_amount+=($res1->grand_total-$res1->paid_amount);

			}

			echo "<tr>
					  <td class='text-right text-bold' colspan='6'><b>Total :</b></td>
					  <td class='text-right text-bold'>".number_format($tot_grand_total,2,'.','')."</td>
					  <td class='text-right text-bold'>".number_format($tot_paid_amount,2,'.','')."</td>
					  <td class='text-right text-bold'>".number_format($tot_due_amount,2,'.','')."</td>
				  </tr>";
		}
		else{
			echo "<tr>";
			echo "<td class='text-center text-danger' colspan=13>No se encontraron registros</td>";
			echo "</tr>";
		}
		
	    exit;
	}
	public function show_purchase_payments_report(){
		extract($_POST);
		$supplier_id = $this->input->post('supplier_id');
		$from_date=date("Y-m-d",strtotime($from_date));
		$to_date=date("Y-m-d",strtotime($to_date));
		
		$this->db->select("c.id,c.purchase_code,a.payment_date,b.supplier_name,b.supplier_code,a.payment_type,a.payment_note,a.payment");
	    
		if($supplier_id!=''){
			$this->db->where("c.supplier_id=$supplier_id");
		}
		$this->db->where("b.id=c.`supplier_id`");
		$this->db->where("(a.payment_date>='$from_date' and a.payment_date<='$to_date')");
		
		$this->db->where("c.id=a.purchase_id");

		$this->db->from("db_purchasepayments as a");
		$this->db->from("db_suppliers as b");
		$this->db->from("db_purchase as c");
		//$this->db->group_by("c.purchase_code");
		
		//echo $this->db->get_compiled_select();
		
		$q1=$this->db->get();
		if($q1->num_rows()>0){
			$i=0;
			$tot_payment=0;
			foreach ($q1->result() as $res1) {
				echo "<tr>";
				echo "<td>".++$i."</td>";
				echo "<td><a title='View Invoice' href='".base_url("purchase/invoice/$res1->id")."'>".$res1->purchase_code."</a></td>";
				echo "<td>".show_date($res1->payment_date)."</td>";
				echo "<td>".$res1->supplier_code."</td>";
				echo "<td>".$res1->supplier_name."</td>";
				echo "<td>".$res1->payment_type."</td>";
				echo "<td>".$res1->payment_note."</td>";
				echo "<td class='text-right'>".number_format(($res1->payment),2,'.','')."</td>";
				echo "</tr>";
				$tot_payment+=$res1->payment;
			}

			echo "<tr>
					  <td class='text-right text-bold' colspan='7'><b>Total :</b></td>
					  <td class='text-right text-bold'>".number_format($tot_payment,2,'.','')."</td>
				  </tr>";
		}
		else{
			echo "<tr>";
			echo "<td class='text-center text-danger' colspan=8>No se encontraron registros</td>";
			echo "</tr>";
		}
		
	    exit;
	}
	public function show_sales_payments_report(){
		extract($_POST);
		
		$from_date=date("Y-m-d",strtotime($from_date));
		$to_date=date("Y-m-d",strtotime($to_date));
		
		$this->db->select("c.id,c.sales_code,a.payment_date,b.customer_name,b.customer_code,a.payment_type,a.payment_note,a.payment");
	    
		if($customer_id!=''){
			$this->db->where("c.customer_id=$customer_id");
		}
		$this->db->where("b.id=c.`customer_id`");
		$this->db->where("(a.payment_date>='$from_date' and a.payment_date<='$to_date')");
		
		$this->db->where("c.id=a.sales_id");

		$this->db->from("db_salespayments as a");
		$this->db->from("db_customers as b");
		$this->db->from("db_sales as c");
		//$this->db->group_by("c.sales_code");
		
		//echo $this->db->get_compiled_select();
		
		$q1=$this->db->get();
		if($q1->num_rows()>0){
			$i=0;
			$tot_payment=0;
			foreach ($q1->result() as $res1) {
				echo "<tr>";
				echo "<td>".++$i."</td>";
				echo "<td><a title='View Invoice' href='".base_url("sales/invoice/$res1->id")."'>".$res1->sales_code."</a></td>";
				echo "<td>".show_date($res1->payment_date)."</td>";
				echo "<td>".$res1->customer_code."</td>";
				echo "<td>".$res1->customer_name."</td>";
				echo "<td>".$res1->payment_type."</td>";
				echo "<td>".$res1->payment_note."</td>";
				echo "<td class='text-right'>".number_format(($res1->payment),2,'.','')."</td>";
				echo "</tr>";
				$tot_payment+=$res1->payment;
			}

			echo "<tr>
					  <td class='text-right text-bold' colspan='7'><b>Total :</b></td>
					  <td class='text-right text-bold'>".number_format($tot_payment,2,'.','')."</td>
				  </tr>";
		}
		else{
			echo "<tr>";
			echo "<td class='text-center text-danger' colspan=8>No se encontraron registros</td>";
			echo "</tr>";
		}
		
	    exit;
	}
	/*Expired Items Report*/
	public function show_expired_items_report(){
		extract($_POST);
		$CI =& get_instance();

		$from_date=date("Y-m-d",strtotime($from_date));
		$to_date=date("Y-m-d",strtotime($to_date));
		
		$this->db->select("id,item_code,item_name,expire_date,stock,lot_number");
	    
		if($item_id!=''){
			
			$this->db->where("id=$item_id");
		}
		if($view_all=="no"){
			$this->db->where("(expire_date>='$from_date' and expire_date<='$to_date')");
		}
		$this->db->from("db_items");
		
		//echo $this->db->get_compiled_select();exit();
		
		$q1=$this->db->get();
		if($q1->num_rows()>0){
			$i=0;
			foreach ($q1->result() as $res1) {
				echo "<tr>";
				echo "<td>".++$i."</td>";
				echo "<td>".$res1->item_code."</td>";
				echo "<td>".$res1->item_name."</td>";
				echo "<td>".$res1->lot_number."</td>";
				echo "<td>".show_date($res1->expire_date)."</td>";
				echo "<td>".$res1->stock."</td>";

			}
		}
		else{
			echo "<tr>";
			echo "<td class='text-center text-danger' colspan=6>No se encontraron registros</td>";
			echo "</tr>";
		}
		
	    exit;
	}
}
