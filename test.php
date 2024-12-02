<?php
	if(!empty($_POST['data'])){ 
		$data = base64_decode($_POST['data']);
		//$data = $_POST['data'];
		$name = $_GET['file_name'];
		$fname = $name; // name the file
		$file = fopen("uploads/" .$fname, 'w'); // open the file path
		fwrite($file, $data); //save data
		fclose($file);
		echo "File is saved";   
	}
	else {
		echo "No Data Sent";
	}

?>