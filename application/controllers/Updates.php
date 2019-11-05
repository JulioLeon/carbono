<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updates extends MY_Controller {
	public function __construct(){
			parent::__construct();
			$this->load_global();
			set_time_limit(0);
		}
	public function index()
	{
		$this->permission_check('users_add');
		$data=$this->data;//My_Controller constructor data accessed here
		$data['page_title']=$this->lang->line('database_updater');
		$data['current_version']=$this->get_current_version_of_db();
		$data['latest_version']=$this->source_version;
		$this->load->view('database_updater', $data);
	}
	public function update_db(){
		if($this->get_current_version_of_db()==$this->source_version){
			echo "Database Already Updated!";
			exit();
		}

		//Update database
		$this->db->trans_begin();
		$current_db_name=$this->db->database;

		if($this->get_current_version_of_db()=='1.0' || $this->get_current_version_of_db()=='1.1'){
			//Provide 1.2 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.2' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("INSERT INTO `db_languages` (`language`, `status`) VALUES ('Spanish', '1')");if(!$q1){ echo "failed"; exit();}
		}

		if($this->get_current_version_of_db()=='1.2'){
			//Provide 1.3 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.3' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE `db_roles` ADD COLUMN `description` TEXT NULL AFTER `role_name`");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("UPDATE `db_roles` SET `description` = 'All Rights Permitted.' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("CREATE TABLE `db_permissions` (`id` int(5) NOT NULL AUTO_INCREMENT,`role_id` int(5) DEFAULT NULL,`permissions` varchar(50) DEFAULT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=latin1");if(!$q1){ echo "failed"; exit();}

		}
		if($this->get_current_version_of_db()=='1.3'){
			//Provide 1.3.1 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.3.1' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
		}
		if($this->get_current_version_of_db()=='1.3.1'){
			//Provide 1.3.2 updates 
			$q1 = $this->db->query("ALTER DATABASE ".$current_db_name." CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_category  CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_company CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_country CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_customers CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_expense_category CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_items CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_paymenttypes CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_permissions CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_purchase CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_purchaseitems CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_purchasepayments CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_roles CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_salespayments CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_sitesettings CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_states CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_stockentry CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_suppliers CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_tax CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_timezone CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_units CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_users CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE db_warehouse CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE temp_holdinvoice CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.3.2' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("INSERT INTO `db_languages` (`language`, `status`) VALUES ('Arabic', '1')");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("INSERT INTO `db_currency` (`currency_name`, `currency`, `status`) VALUES ('Saudi Riyal', '﷼. ', '1')");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("INSERT INTO `db_currency` (`currency_name`, `currency`, `status`) VALUES ('Dubai-United Arab Emirates dirham', 'د.إ', '1')");if(!$q1){ echo "failed"; exit();}
		}

		if($this->get_current_version_of_db()=='1.3.2'){
			//Provide 1.3.3 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.3.3' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("INSERT INTO `db_languages` (`language`, `status`) VALUES ('Albanian', '1')");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("INSERT INTO `db_languages` (`language`, `status`) VALUES ('Dutch', '1')");if(!$q1){ echo "failed"; exit();}
		}
		if($this->get_current_version_of_db()=='1.3.3'){
			//Provide 1.3.3 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.3.4' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
		}
		if($this->get_current_version_of_db()=='1.3.4'){
			//Provide 1.3.3 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.3.5' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
		}
		if($this->get_current_version_of_db()=='1.3.5'){
			//Provide 1.3.3 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.3.6' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
		}
		if($this->get_current_version_of_db()=='1.3.6'){
			//Provide 1.3.3 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.3.7' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
		}
		if($this->get_current_version_of_db()=='1.3.7'){
			//Provide 1.3.8 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.3.8' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE `db_salespayments` ADD COLUMN `change_return` DOUBLE(10,2) NULL COMMENT 'Refunding the greater amount' AFTER `payment_note`");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE `db_sitesettings` ADD COLUMN `change_return` INT(1) NULL COMMENT 'show in pos' AFTER `purchase_code`");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `change_return` = '0' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("CREATE TABLE `db_brands` ( `id` INT(5) NOT NULL AUTO_INCREMENT, `brand_code` VARCHAR(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL, `brand_name` VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL, `description` MEDIUMTEXT COLLATE utf8mb4_unicode_ci, `company_id` INT(5) DEFAULT NULL, `status` INT(1) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=INNODB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE `db_items` ADD COLUMN `brand_id` INT(5) NULL AFTER `alert_qty`");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE `db_items` ADD COLUMN `lot_number` VARCHAR(50) NULL AFTER `alert_qty`");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE `db_items` ADD COLUMN `expire_date` DATE NULL AFTER `lot_number`");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE `db_currency` ADD COLUMN `currency_code` VARCHAR(20) NULL AFTER `currency_name`");if(!$q1){ echo "failed"; exit();}
		}

		if($this->get_current_version_of_db()=='1.3.8'){
			//Provide 1.3.9 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.3.9' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
		}
		if($this->get_current_version_of_db()=='1.3.9'){
			//Provide 1.3.9.1 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.3.9.1' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("INSERT INTO `db_languages` (`language`, `status`) VALUES ('Bangla', '1');");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("INSERT INTO `db_languages` (`language`, `status`) VALUES ('Urdu', '1');");if(!$q1){ echo "failed"; exit();}

		}
		if($this->get_current_version_of_db()=='1.3.9.1'){
			//Provide 1.4 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.4' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("CREATE TABLE `db_smsapi`( `id` INT(5) NOT NULL AUTO_INCREMENT, `info` VARCHAR(150), `key` VARCHAR(600), `key_value` VARCHAR(600), `delete_bit` INT(5), PRIMARY KEY (`id`) )");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("CREATE TABLE `db_smstemplates`( `id` INT(5) NOT NULL AUTO_INCREMENT, `template_name` VARCHAR(100), `content` TEXT, `variables` TEXT, `company_id` INT(5), `status` INT(5), `undelete_bit` INT(5), PRIMARY KEY (`id`) )");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE `db_company` ADD COLUMN `sms_status` INT(1) NULL COMMENT '1=Enable 0=Disable' AFTER `status`");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("UPDATE `db_company` SET `sms_status` = '0' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("INSERT into `db_smsapi` (`info`, `key`, `key_value`, `delete_bit`) values('url','weblink','http://www.example.com',NULL)");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("INSERT into `db_smsapi` (`info`, `key`, `key_value`, `delete_bit`) values('mobile','mobiles','',NULL)");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("INSERT into `db_smsapi` (`info`, `key`, `key_value`, `delete_bit`) values('message','message','',NULL)");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("INSERT into `db_smstemplates` (`id`, `template_name`, `content`, `variables`, `company_id`, `status`, `undelete_bit`) values('1','GREETING TO CUSTOMER ON SALES','Hi {{customer_name}},\r\nYour sales Id is {{sales_id}},\r\nSales Date {{sales_date}},\r\nTotal amount  {{sales_amount}},\r\nYou have paid  {{paid_amt}},\r\nand due amount is  {{due_amt}}\r\nThank you Visit Again','{{customer_name}}<br>                          \r\n{{sales_id}}<br>\r\n{{sales_date}}<br>\r\n{{sales_amount}}<br>\r\n{{paid_amt}}<br>\r\n{{due_amt}}<br>\r\n{{company_name}}<br>\r\n{{company_mobile}}<br>\r\n{{company_address}}<br>\r\n{{company_website}}<br>\r\n{{company_email}}<br>',NULL,'1','1')");if(!$q1){ echo "failed"; exit();}

			$q1 = $this->db->query("ALTER TABLE `db_company` ADD COLUMN `company_logo` TEXT NULL AFTER `website`");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("UPDATE `db_company` SET `company_logo` = 'company_logo.png' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE `db_sitesettings` ADD COLUMN `sales_invoice_format_id` INT(5) NULL AFTER `change_return`");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `sales_invoice_format_id` = '1' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("ALTER TABLE `db_sitesettings` ADD COLUMN `sales_invoice_footer_text` TEXT NULL AFTER `sales_invoice_format_id`");if(!$q1){ echo "failed"; exit();}
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `sales_invoice_footer_text` = ' Este es el texto de pie de página. Puede configurarlo desde la Configuración del sitio.' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
			
			
		}
		if($this->get_current_version_of_db()=='1.4'){
			//Provide 1.4.1 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.4.1' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
		}
		if($this->get_current_version_of_db()=='1.4.1'){
			//Provide 1.4.1 updates 
			$q1 = $this->db->query("UPDATE `db_sitesettings` SET `version` = '1.4.2' WHERE `id` = '1'");if(!$q1){ echo "failed"; exit();}
		}
		

		$this->db->trans_commit();
		echo "success";


	}
	

}

/* End of file Updates.php */
/* Location: ./application/controllers/Updates.php */