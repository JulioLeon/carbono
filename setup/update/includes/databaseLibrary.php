<?php
class Database {
	function check_database_exist_or_not($data){
		$hostname = $data['hostname'];
		$username = $data['username'];
		$password = $data['password'];
		$database_name = $data['database'];

		// Creating a connection
		$conn = new mysqli($hostname, $username, $password);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$q3=$conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database_name'");
		if(mysqli_num_rows($q3)>0){
			//Success
			return true;
		}
		return false;
	}
	function create_database($data){
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');
		if(mysqli_connect_errno())
			return false;
		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database']);
		$mysqli->close();
		return true;
	}

	function create_tables($data){
		$header   = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
		$ch = curl_init();
		$purchase_code = $data['purchase_code'];
		curl_setopt($ch, CURLOPT_URL, "http://destinytechnologies.in/envato/inventory/process.php?v=1.4.2&purchase_code=".$purchase_code);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		$response = json_decode( $output, true );
		
		if($response['status']=='false'){
			return false;			
		}
		else{
			$con1=mysqli_connect($data['hostname'],$data['username'],$data['password'],$data['database']);
			return true;
			/*$q1=mysqli_multi_query($con1,$response['info']);

			if($q1){
				return true;
			}
			else{
				echo "Failed To Install";exit();
				return false;
			}*/
		}
	}
}
