<?php 
	require("includes/connection.php");
	require("includes/function.php");
	require("language/language.php");
	require("language/app_language.php");
	
	include("smtp_email.php");

	$file_path = getBaseUrl();

	// Get event info 
	function get_event_info($event,$field_name) 
	{
		global $mysqli;

		$qry_user="SELECT * FROM tbl_events WHERE id='".$event."'";
		$query1=mysqli_query($mysqli,$qry_user);
		$row_user = mysqli_fetch_array($query1);

		$num_rows1 = mysqli_num_rows($query1);

		if ($num_rows1 > 0)
		{     
			return $row_user[$field_name];
		}
		else
		{
			return "";
		}
	}

	$response=array();

	switch ($_POST['action']) {
		case 'toggle_status':
			$id=$_POST['id'];
			$for_action=$_POST['for_action'];
			$column=$_POST['column'];
			$tbl_id=$_POST['tbl_id'];
			$table_nm=$_POST['table'];
			// enable & disable status
			if($for_action=='active'){

				if($table_nm=='tbl_events'){
					
					$content = array("en" => 'Your '.get_event_info($id,'event_title').' event is approved by admin');
					
					$fields = array(
					      'app_id' => ONESIGNAL_APP_ID,
					      'included_segments' => array('Subscribed Users'),                                            
					      'data' => array("foo" => "bar", "event_id" =>$id),
					      'filters' => array(array('field' => 'tag', 'key' => 'user_id', 'relation' => '=', 'value' => get_event_info($id,'user_id'))),
					      'headings'=> array("en" => APP_NAME),
					      'contents' => $content 
					      );

					$fields = json_encode($fields);

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
					                                           'Authorization: Basic '.ONESIGNAL_REST_KEY));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_HEADER, FALSE);
					curl_setopt($ch, CURLOPT_POST, TRUE);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

					$res_notification = curl_exec($ch);

					curl_close($ch);
				}

				if($column=='is_slider'){

			    	//slider enable and disable
			        $sql="SELECT * FROM tbl_slider WHERE `event_id`=$id";
    				$res=mysqli_query($mysqli, $sql);

    				if($res->num_rows > 0){
    					$row=mysqli_fetch_assoc($res);
    					$data = array('status'  =>  '1');
    					$edit_status=Update('tbl_slider', $data, "WHERE id = ".$row['id']);
    					
    				}
			    		if($res->num_rows == 0){

							$data_slider = array(
								'event_id' => $id,
								'slider_title' =>  '',
								'slider_type'=> 'Event',
								'external_url' =>  '',
								'external_image' =>  ''
							);  

							$qry = Insert('tbl_slider',$data_slider);
						}

			    	}
			    
			    $data = array($column  =>  '1');
			    $edit_status=Update($table_nm, $data, "WHERE $tbl_id = '$id'");
 					
				if($table_nm=='tbl_slider'){

					//status enable and disable
			        $sql="SELECT * FROM tbl_slider WHERE `id`=$id";
    				$res=mysqli_query($mysqli, $sql);
    				$row=mysqli_fetch_assoc($res);
    				
			    	$data = array('tbl_slider'  =>  '1');
			        $edit_status=Update('tbl_events', $data, "WHERE id = ".$row['event_id']);

			        $_SESSION['msg']="13";
			      } 
			      $sql="SELECT * FROM tbl_slider WHERE `event_id`=$id";
    			  $res=mysqli_query($mysqli, $sql);

    				if($res->num_rows > 0){

    					$row=mysqli_fetch_assoc($res);

    					$data = array('status'  =>  '1');
    					$edit_status=Update('tbl_slider', $data, "WHERE id = ".$row['id']);

    					$_SESSION['msg']="13";

    				}
			    
    			else if($column=='is_slider'){
					$_SESSION['msg']="14";
				}
				else{
					$_SESSION['msg']="13";
				}
			
			}else{
				$data = array($column  =>  '0');
			    $edit_status=Update($table_nm, $data, "WHERE $tbl_id = '$id'");

			    $sql="SELECT * FROM tbl_slider WHERE `event_id`=$id";
    			$res=mysqli_query($mysqli, $sql);

    				if($res->num_rows > 0){

    					$row=mysqli_fetch_assoc($res);

    					$data = array('status'  =>  '0');
    					$edit_status=Update('tbl_slider', $data, "WHERE id = ".$row['id']);

    					
    				}
				$_SESSION['msg']="14";
			   
			   if($column=='is_slider'){

				$sqlDelete="DELETE FROM tbl_slider WHERE `event_id`=$id";
				mysqli_query($mysqli, $sqlDelete);

			    }
			}
			
	      	$response['status']=1;
	      	$response['action']=$for_action;
	      	echo json_encode($response);
			break;

		case 'remove_gallery_img':
		
			$id=$_POST['id'];

			$img=$_POST['img'];

			if(file_exists('images/'.$img)){

				unlink('images/'.$img);
				unlink('images/thumbs/'.$img);
			}

			Delete('tbl_event_cover','id='.$id);

	      	$response['status']=1;
	      	echo json_encode($response);
			break;	
		
		case 'removeSlider':
			
			$id=$_POST['id'];
			$tbl_nm=$_POST['tbl_nm'];

			$sql=mysqli_query($mysqli,"SELECT * FROM $tbl_nm WHERE `id` IN ($id)");
			$row=mysqli_fetch_assoc($sql);

			if($row['slider_type']=="external")
			{
			unlink('images/'.$row['external_image']);
			}

			$data = array('is_slider' => '0');
			$edit=Update('tbl_events', $data, "WHERE `id` = '".$row['event_id']."'");

			Delete('tbl_slider','id ='.$id);
			
			$response['status']=1;	
			$_SESSION['msg']="12";
	      	echo json_encode($response);
			break;
	
		case 'removeData':
			$id=$_POST['id'];
			$tbl_nm=$_POST['tbl_nm'];
			$tbl_id=$_POST['tbl_id'];

			if($tbl_nm=='tbl_users'){
				$sql="SELECT * FROM $tbl_nm WHERE $tbl_id=$id";
				$res=mysqli_query($mysqli, $sql);
				$row=mysqli_fetch_assoc($res);
				unlink('images/'.$row['user_image']);
			}

			Delete($tbl_nm,$tbl_id.'='.$id);

			$_SESSION['msg']="12";
	      	$response['status']=1;
	      	echo json_encode($response);
			break;

		// Get remove report	
		case 'removeReport':
			$id=$_POST['id'];

			if(!isset($_POST['event_id'])){
				echo $sqlDelete="DELETE FROM tbl_reports WHERE `id`=$id";
				mysqli_query($mysqli, $sqlDelete);
			}
			else{
				$event_id=$_POST['event_id'];
				$sqlDelete="DELETE FROM tbl_reports WHERE `event_id` IN ($event_id)";
				mysqli_query($mysqli, $sqlDelete);
			}
	      	
	      	$response['status']=1;
	      	echo json_encode($response);
			break;

		 // Get remove all report	
		 case 'removeAllRepoert':
			
			$event_id=implode(',', $_POST['ids']);
			
			$sqlDelete="DELETE FROM tbl_reports WHERE `event_id` IN ($event_id)";

			if(mysqli_query($mysqli, $sqlDelete)){
				$response['status']=1;	
			}
			else{
				$response['status']=0;
			}
			
			$response['status']=1;
			$_SESSION['msg']="12";	
	      	echo json_encode($response);
			break;
	
		case 'multi_delete':

			$ids=implode(",", $_POST['id']);

			if($ids==''){
				$ids=$_POST['id'];
			}

			$tbl_nm=$_POST['tbl_nm'];

			if($tbl_nm=='tbl_events'){

				$sql="SELECT * FROM $tbl_nm WHERE `id` IN ($ids)";
				$res=mysqli_query($mysqli, $sql);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['event_logo']!="")
					{
						unlink('images/'.$row['event_logo']);
						unlink('images/thumbs/'.$row['event_logo']);
					}

					if($row['event_banner']!="")
					{
						unlink('images/'.$row['event_banner']);
						unlink('images/thumbs/'.$row['event_banner']);
					}

					$sql_gallery="SELECT * FROM tbl_event_cover WHERE `event_id`='$row[id]'";
					$res_gallery=mysqli_query($mysqli, $sql_gallery);
					while ($row_img=mysqli_fetch_assoc($res_gallery)) {
						if($row_img['image_file']!="")
						{
							unlink('images/'.$row_img['image_file']);
							unlink('images/thumbs/'.$row_img['image_file']);
						}
					}

					Delete('tbl_event_cover','event_id='.$row['id'].'');

				}

				$deleteSql="DELETE FROM tbl_event_booking WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_reports WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_slider WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_favourite WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_recent WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM $tbl_nm WHERE `id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
			}

			else if($tbl_nm=='tbl_category'){

				$sql="SELECT * FROM tbl_events WHERE `cat_id` IN ($ids)";
				$res=mysqli_query($mysqli, $sql);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['event_logo']!="")
					{
						unlink('images/'.$row['event_logo']);
						unlink('images/thumbs/'.$row['event_logo']);
					}

					if($row['event_banner']!="")
					{
						unlink('images/'.$row['event_banner']);
						unlink('images/thumbs/'.$row['event_banner']);
					}

					$sql_gallery="SELECT * FROM tbl_event_cover WHERE `event_id`='$row[id]'";
					$res_gallery=mysqli_query($mysqli, $sql_gallery);
					while ($row_img=mysqli_fetch_assoc($res_gallery)) {
						if($row_img['image_file']!="")
						{
							unlink('images/'.$row_img['image_file']);
							unlink('images/thumbs/'.$row_img['image_file']);
						}
					}

					Delete('tbl_event_cover','event_id='.$row['id'].'');

				}

				$deleteSql="DELETE FROM tbl_event_booking WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_reports WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_events WHERE `cat_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_slider WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_favourite WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_recent WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				mysqli_free_result($res);

				$sqlCategory="SELECT * FROM $tbl_nm WHERE `cid` IN ($ids)";
				$res=mysqli_query($mysqli, $sqlCategory);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['category_image']!="")
					{
						unlink('images/'.$row['category_image']);
						unlink('images/thumbs/'.$row['category_image']);
					}
					if($row['category_icon']!="")
					{
						unlink('images/'.$row['category_icon']);
						unlink('images/thumbs/'.$row['category_icon']);
					}

				}

				$deleteSql="DELETE FROM $tbl_nm WHERE `cid` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
			}
			else if($tbl_nm=='invitation_card_image'){
				$sqlCategory="SELECT * FROM $tbl_nm WHERE `id` IN ($ids)";
				$res=mysqli_query($mysqli, $sqlCategory);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['card_image']!="")
					{
						unlink('images/'.$row['card_image']);
						unlink('images/thumbs/'.$row['card_image']);
					}
				}
				$deleteSql="DELETE FROM $tbl_nm WHERE `id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
			}
			else if($tbl_nm=='event_image'){
				$sql="SELECT * FROM $tbl_nm WHERE `id` IN ($ids)";
				$res=mysqli_query($mysqli, $sql);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['event_image']!="")
					{
						unlink('images/'.$row['event_image']);
						unlink('images/thumbs/'.$row['event_image']);
					}
				}
				$deleteSql="DELETE FROM $tbl_nm WHERE `id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
			}
			else if($tbl_nm=='event_feed'){
				$sql="SELECT * FROM $tbl_nm WHERE `id` IN ($ids)";
				$res=mysqli_query($mysqli, $sql);
				$deleteSql="DELETE FROM $tbl_nm WHERE `id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
			}

			else if($tbl_nm=='tbl_users'){

				$sql="SELECT * FROM tbl_events WHERE `user_id` IN ($ids)";
				$res=mysqli_query($mysqli, $sql);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['event_logo']!="")
					{
						unlink('images/'.$row['event_logo']);
						unlink('images/thumbs/'.$row['event_logo']);
					}

					if($row['event_banner']!="")
					{
						unlink('images/'.$row['event_banner']);
						unlink('images/thumbs/'.$row['event_banner']);
					}

					$sql_gallery="SELECT * FROM tbl_event_cover WHERE `event_id`='$row[id]'";
					$res_gallery=mysqli_query($mysqli, $sql_gallery);
					while ($row_img=mysqli_fetch_assoc($res_gallery)) {
						if($row_img['image_file']!="")
						{
							unlink('images/'.$row_img['image_file']);
							unlink('images/thumbs/'.$row_img['image_file']);
						}
					}

					Delete('tbl_event_cover','event_id='.$row['id'].'');

					$deleteSql="DELETE FROM tbl_event_booking WHERE `event_id`='".$row['id']."'";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_reports WHERE `event_id`='".$row['id']."'";
					mysqli_query($mysqli, $deleteSql);

				}

				$deleteSql="DELETE FROM tbl_events WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_event_booking WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_reports WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_favourite WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_slider WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
				
				$deleteSql="DELETE FROM tbl_recent WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
				
				$deleteSql="DELETE FROM tbl_active_log WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				mysqli_free_result($res);

				$sqlCategory="SELECT * FROM $tbl_nm WHERE `id` IN ($ids)";
				$res=mysqli_query($mysqli, $sqlCategory);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['user_image']!="")
					{
						unlink('images/'.$row['user_image']);
						unlink('images/thumbs/'.$row['user_image']);
					}

				}

				$deleteSql="DELETE FROM $tbl_nm WHERE `id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
			}

			else if($tbl_nm=='tbl_contact_list' OR $tbl_nm=='tbl_reports' OR $tbl_nm=='tbl_event_booking'){

				$deleteSql="DELETE FROM $tbl_nm WHERE `id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
			}
			
			$_SESSION['msg']="12";
	      	$response['status']=1;
	      	echo json_encode($response);
			break;


		case 'multi_action':

			$action=$_POST['for_action'];
			$ids=implode(",", $_POST['id']);
			$table=$_POST['table'];

			if($action=='enable'){

				if($table=='tbl_events'){

					foreach ($_POST['id'] as $key => $value) {
						$content = array("en" => 'Your '.get_event_info($value,'event_title').' event is approved by admin');
					
						$fields = array(
						      'app_id' => ONESIGNAL_APP_ID,
						      'included_segments' => array('Subscribed Users'),                                            
						      'data' => array("foo" => "bar","event_id" =>$value),
						      'filters' => array(array('field' => 'tag', 'key' => 'user_id', 'relation' => '=', 'value' => get_event_info($value,'user_id'))),
						      'headings'=> array("en" => APP_NAME),
						      'contents' => $content 
						      );

						$fields = json_encode($fields);

						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
						curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic '.ONESIGNAL_REST_KEY));
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
						curl_setopt($ch, CURLOPT_HEADER, FALSE);
						curl_setopt($ch, CURLOPT_POST, TRUE);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

						$res_notification = curl_exec($ch);

						curl_close($ch);	
					}
				}

				$sql="UPDATE $table SET status='1' WHERE id IN ($ids)";
				mysqli_query($mysqli, $sql);
				$response['status']=1;	
				$_SESSION['msg']="13";
			}
			else if($action=='disable'){
				$sql="UPDATE $table SET status='0' WHERE id IN ($ids)";
				mysqli_query($mysqli, $sql);
				$response['status']=1;	
				$_SESSION['msg']="14";

			}
			else if($action=='delete'){

				$sql="SELECT * FROM tbl_events WHERE `id` IN ($ids)";
				$res=mysqli_query($mysqli, $sql);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['event_logo']!="")
					{
						unlink('images/'.$row['event_logo']);
						unlink('images/thumbs/'.$row['event_logo']);
					}

					if($row['event_banner']!="")
					{
						unlink('images/'.$row['event_banner']);
						unlink('images/thumbs/'.$row['event_banner']);
					}

					$sql_gallery="SELECT * FROM tbl_event_cover WHERE `event_id`='$row[id]'";
					$res_gallery=mysqli_query($mysqli, $sql_gallery);
					while ($row_img=mysqli_fetch_assoc($res_gallery)) {
						if($row_img['image_file']!="")
						{
							unlink('images/'.$row_img['image_file']);
							unlink('images/thumbs/'.$row_img['image_file']);
						}
					}

					Delete('tbl_event_cover','event_id='.$row['id'].'');

				}
				$deleteSql="DELETE FROM tbl_events WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_event_booking WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_reports WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_favourite WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_slider WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
				
				$deleteSql="DELETE FROM tbl_recent WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
				
				$deleteSql="DELETE FROM tbl_active_log WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				mysqli_free_result($res);

				$sqlCategory="SELECT * FROM tbl_users WHERE `id` IN ($ids)";
				$res=mysqli_query($mysqli, $sqlCategory);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['user_image']!="")
					{
						unlink('images/'.$row['user_image']);
						unlink('images/thumbs/'.$row['user_image']);
					}

				}

				$deleteSql="DELETE FROM tbl_users WHERE `id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_event_booking WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_reports WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_slider WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_favourite WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_recent WHERE `event_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM $table WHERE `id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$_SESSION['msg']="12";
				$response['status']=1;	
				
			}else if($table=='tbl_users'){

				$sql="SELECT * FROM tbl_events WHERE `user_id` IN ($ids)";
				$res=mysqli_query($mysqli, $sql);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['event_logo']!="")
					{
						unlink('images/'.$row['event_logo']);
						unlink('images/thumbs/'.$row['event_logo']);
					}

					if($row['event_banner']!="")
					{
						unlink('images/'.$row['event_banner']);
						unlink('images/thumbs/'.$row['event_banner']);
					}

					$sql_gallery="SELECT * FROM tbl_event_cover WHERE `event_id`='$row[id]'";
					$res_gallery=mysqli_query($mysqli, $sql_gallery);
					while ($row_img=mysqli_fetch_assoc($res_gallery)) {
						if($row_img['image_file']!="")
						{
							unlink('images/'.$row_img['image_file']);
							unlink('images/thumbs/'.$row_img['image_file']);
						}
					}

					Delete('tbl_event_cover','event_id='.$row['id'].'');

					$deleteSql="DELETE FROM tbl_event_booking WHERE `event_id`='".$row['id']."'";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_reports WHERE `event_id`='".$row['id']."'";
					mysqli_query($mysqli, $deleteSql);

				}

				$deleteSql="DELETE FROM tbl_events WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_event_booking WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_reports WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_favourite WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_slider WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
				
				$deleteSql="DELETE FROM tbl_recent WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
				
				$deleteSql="DELETE FROM tbl_active_log WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				mysqli_free_result($res);

				$sqlCategory="SELECT * FROM $table WHERE `id` IN ($ids)";
				$res=mysqli_query($mysqli, $sqlCategory);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['user_image']!="")
					{
						unlink('images/'.$row['user_image']);
						unlink('images/thumbs/'.$row['user_image']);
					}

				}

				$deleteSql="DELETE FROM $table WHERE `id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
			}
			echo json_encode($response);
			break;
		// Check smtp mail html
		case 'check_smtp':
			{
				$to = trim($_POST['email']);
				$recipient_name='Check User';

				$subject = '[IMPORTANT] '.APP_NAME.' Check SMTP Configuration';

				$message='<div style="background-color: #f9f9f9;" align="center"><br />
				<table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
				<tbody>
				<tr>
				<td colspan="2" bgcolor="#FFFFFF" align="center"><img src="'.$file_path.'images/'.APP_LOGO.'" alt="header" /></td>
				</tr>
				<tr>
				<td width="600" valign="top" bgcolor="#FFFFFF"><br>
				<table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
				<tbody>
				<tr>
				<td valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
				<tbody>
				<tr>
				<td>
					<p style="color: #262626; font-size: 24px; margin-top:0px;">Hi, '.$_SESSION['admin_name'].'</p>
					<p style="color: #262626; font-size: 18px; margin-top:0px;">This is the demo mail to check SMTP Configuration. </p>
					<p style="color:#262626; font-size:17px; line-height:32px;font-weight:500;margin-bottom:30px;">'.$app_lang['thank_you_lbl'].' '.APP_NAME.'</p>

				</td>
				</tr>
				</tbody>
				</table></td>
				</tr>

				</tbody>
				</table></td>
				</tr>
				<tr>
				<td style="color: #262626; padding: 20px 0; font-size: 18px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">'.$app_lang['email_copyright'].' '.APP_NAME.'.</td>
				</tr>
				</tbody>
				</table>
				</div>';

				send_email($to,$recipient_name,$subject,$message, true);
			}
			break;
			
		default:
			# code...
			break;
	}

?>