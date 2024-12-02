<?php
include("includes/connection.php");
include("includes/function.php");
include("language/app_language.php");
include("smtp_email.php");

error_reporting(0);

define("PACKAGE_NAME",$settings_details['package_name']);

define("API_PAGE_LIMIT",$settings_details['page_limit']);

define("API_RECENT_LIMIT",$settings_details['api_recent_limit']);

$mysqli->set_charset('utf8mb4');

date_default_timezone_set("Asia/Kolkata");

$file_path = getBaseUrl();

	// Purchase code verification start


	//get thumb image start
	function get_thumb($filename,$thumb_size)
	{	
		$file_path = getBaseUrl();
		return $thumb_path=$file_path.'thumb.php?src='.$filename.'&size='.$thumb_size;
	}
	//get thumb image end

	//get user info start
	function get_user_info($user_id,$field_name) 
	{
		global $mysqli;

		$qry_user="SELECT * FROM tbl_users WHERE tbl_users.`id`='".$user_id."'";
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
	//get user info end
	//get event info start
	function get_event_info($event_id,$field_name) 
	{
		global $mysqli;

		$qry_event="SELECT * FROM tbl_events WHERE tbl_events.`id`='".$event_id."'";
		$query1=mysqli_query($mysqli,$qry_event);
		$row_event = mysqli_fetch_array($query1);

		$num_rows1 = mysqli_num_rows($query1);

		if ($num_rows1 > 0)
		{		 	
			return $row_event[$field_name];
		}
		else
		{
			return "";
		}
	}
	//get event info end
	
	// Create a random code start
	function createRandomCode() 
	{     
		$chars = "abcdefghijkmn023456789OPQRSTUVWXYZ";     
		srand((double)microtime()*1000000);     
		$i = 0;     
		$pass = '' ;     
		while ($i <= 5) 
		{         
			$num = rand() % 33;         
			$tmp = substr($chars, $num, 1);         
			$pass = $pass . $tmp;         
			$i++;     
		}    
		return $pass; 
	}
	// Create a random code end

	// Generate random password start
	function generateRandomPassword($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	// Generate random password end

	// Get event status start
	function eventStatus($reg_start, $reg_end) 
	{

		$currDateTime=strtotime(date('m/d/Y h:i A'));

		$currTime=strtotime(date('h:i A'));
		$endTime=strtotime(date('h:i A',$reg_end));

		if($currDateTime >= $reg_start){

			if($currDateTime >= $reg_end){

				if($currTime >= $endTime && date('A')==date('A',$endTime)){
					return '2';	
				}
				else{
					return '1';
				}
			}
			else{
				return '1';
			}
		}
		else{
			return '0';	
		}
	}
	// Get event status end

	// Get total booking start
	function get_total_booking($event_id)
	{ 
		global $mysqli;   

		$qry_songs="SELECT SUM(`total_ticket`) as num FROM tbl_event_booking WHERE tbl_event_booking.`event_id`='".$event_id."'";
		$total_item = mysqli_fetch_array(mysqli_query($mysqli,$qry_songs));
		$total_item = $total_item['num'];

		return $total_item;

	}
	// Get total booking end

	// Get total item start
	function get_total_item($cat_id)
	{ 
		global $mysqli;   

		$qry_songs="SELECT COUNT(*) as num FROM tbl_events WHERE tbl_events.`status`=1 AND tbl_events.`cat_id`='".$cat_id."'";
		$total_songs = mysqli_fetch_array(mysqli_query($mysqli,$qry_songs));
		$total_songs = $total_songs['num'];

		return $total_songs;
	}
	// Get total item end
	// Get category name start
    function get_category_name($category_id)
    { 
      global $mysqli;   
      $query="SELECT * FROM tbl_category WHERE tbl_category.`cid`='".$category_id."'";        
      $category = mysqli_fetch_array(mysqli_query($mysqli,$query));
      $category_name = $category['category_name'];
      return $category_name;
  
    }
	// Get category name end
	// Get subject info start
	function get_subject_info($id,$field_name) 
	{
		global $mysqli;

		$qry_sub="SELECT * FROM tbl_contact_sub WHERE tbl_contact_sub.`id`='".$id."'";
		$query1=mysqli_query($mysqli,$qry_sub);
		$row_sub = mysqli_fetch_array($query1);

		$num_rows1 = mysqli_num_rows($query1);
		
		if ($num_rows1 > 0)
		{		 	
			return $row_sub[$field_name];
		}
		else
		{
			return "";
		}
	}
	// Get subject info end

	// Get event booking info start
	function get_event_booking_info($event_id,$param){

		global $mysqli;

		$sql="SELECT * FROM tbl_event_booking WHERE tbl_event_booking.`event_id`='".$event_id."'";
		$res=mysqli_query($mysqli, $sql);

		if(mysqli_num_rows($res) > 0){
			$row=mysqli_fetch_assoc($res);
			return $row[$param];
		}
		else{
			return '';
		}
		mysqli_free_result($res);
		exit;

	}
	// Get event booking info end

	// Get favourite info start
	function get_favourite_info($event_id,$user_id)
	{
		global $mysqli;

		$sql="SELECT * FROM tbl_favourite WHERE tbl_favourite.`event_id`='$event_id' AND tbl_favourite.`user_id`='$user_id'";
		$res=mysqli_query($mysqli,$sql);
		return ($res->num_rows == 1) ? 'true' : 'false';

	}
	// Get favourite info end
    
	// Get favourite info For Envent Media start
	function get_favourite_info_for_event_media($event_media_id)
	{
		global $mysqli;

		$sql="SELECT * FROM event_media_favourite WHERE event_media_favourite.`event_media_id`='$event_media_id'";
		$res=mysqli_query($mysqli,$sql);
		return ($res->num_rows == 1) ? 'true' : 'false';

	}
	// Get favourite info For Envent Media  end
	
	
	// Get total replies start
	function get_total_replies($comment_id)
	{ 
		global $mysqli;   
		$sql="SELECT * FROM event_media_comment_reply WHERE event_media_comment_reply.`comment_id`='$comment_id'";
		$res=mysqli_query($mysqli,$sql);
		return $res->num_rows;

	}
	// Get total replies end
	
	// Get Last reply start
	function get_last_reply($comment_id)
	{ 
		global $mysqli;   
		$file_path = getBaseUrl();
        $query = "SELECT * FROM event_media_comment_reply WHERE event_media_comment_reply.`comment_id`='".$comment_id."' ORDER BY id DESC LIMIT 1";
        $last_reply = mysqli_fetch_array(mysqli_query($mysqli,$query));
        $row['id'] = $last_reply['id'];
		$row['comment_id'] = $last_reply['comment_id'];
		$row['reply'] = $last_reply['reply'];
		$row['created_at'] = $last_reply['created_at'];
		$row['likes'] = get_total_comment_reply_likes($last_reply['id']);
		$row['dislikes'] = get_total_comment_reply_dislikes($last_reply['id']);
		$row['is_like'] = get_user_reply_like_status($last_reply['id'],$last_reply['user_id']);
		$row['user_name'] = get_user_info($last_reply['user_id'],'name');
		if(get_user_info($last_reply['user_id'],'user_image') !='')
		{
			$row['user_image'] = $file_path.'images/'.get_user_info($last_reply['user_id'],'user_image');
		}	
		else
		{
			$row['user_image'] = '';
		}
        return $row;

	}
	// Get Last reply end
	
	// Get total comment likes start
	function get_total_comment_likes($comment_id)
	{ 
		global $mysqli;   
		$sql="SELECT * FROM event_media_comment_likes WHERE event_media_comment_likes.`comment_id`='$comment_id'";
		$res=mysqli_query($mysqli,$sql);
		return $res->num_rows;

	}
	// Get total comment likes end
	
	// Get total comment dislikes start
	function get_total_comment_dislikes($comment_id)
	{ 
		global $mysqli;   
		$sql="SELECT * FROM event_media_comment_dislikes WHERE event_media_comment_dislikes.`comment_id`='$comment_id'";
		$res=mysqli_query($mysqli,$sql);
		return $res->num_rows;

	}
	// Get total comment dislikes end
	
	// Get total comment reply likes start
	function get_total_comment_reply_likes($comment_reply_id)
	{ 
		global $mysqli;   
		$sql="SELECT * FROM event_media_reply_likes WHERE event_media_reply_likes.`comment_reply_id`='$comment_reply_id'";
		$res=mysqli_query($mysqli,$sql);
		return $res->num_rows;

	}
	// Get total comment reply likes end
	
	// Get total comment reply dislikes start
	function get_total_comment_reply_dislikes($comment_reply_id)
	{ 
		global $mysqli;   
		$sql="SELECT * FROM event_media_reply_dislikes WHERE event_media_reply_dislikes.`comment_reply_id`='$comment_reply_id'";
		$res=mysqli_query($mysqli,$sql);
		return $res->num_rows;

	}
	// Get total comment reply dislikes end
	
	// Get user Comment Status start
	function get_user_comment_like_status($comment_id,$user_id)
	{
		global $mysqli;
		$sql="SELECT * FROM event_media_comment_likes WHERE event_media_comment_likes.`comment_id`='$comment_id' AND event_media_comment_likes.`user_id`='$user_id'";
		$res=mysqli_query($mysqli,$sql);
		return ($res->num_rows == 1) ? 'true' : 'false';

	}
	// Get user Comment Status  end
	
	// Get user Comment Status start
	function get_user_reply_like_status($comment_reply_id,$user_id)
	{
		global $mysqli;
		$sql="SELECT * FROM event_media_reply_likes WHERE event_media_reply_likes.`comment_reply_id`='$comment_reply_id' AND event_media_reply_likes.`user_id`='$user_id'";
		$res=mysqli_query($mysqli,$sql);
		return ($res->num_rows == 1) ? 'true' : 'false';

	}
	// Get user Comment Status  end
	$get_method = checkSignSalt($_POST['data']);	

	// Get home event start
	if($get_method['method_name']=="get_home")
	{	
		$row['status'] = '1';
		$row['message'] = '';
		$ids=$get_method['user_id'];

		$jsonObj_4= array();

		// Get event slider start
		$query_all="SELECT * FROM tbl_slider WHERE tbl_slider.`status`='1' ORDER BY tbl_slider.`id` DESC";
		$sql_all = mysqli_query($mysqli,$query_all) or die(mysqli_error($mysqli));

		while($data = mysqli_fetch_assoc($sql_all))
		{

			$event_id=$data['event_id'];

			switch ($data['slider_type']) {
				case 'Event':

				$query="SELECT tbl_events.`event_title`, tbl_events.`event_banner`,tbl_events.`event_address`,tbl_events.`cat_id` FROM tbl_events LEFT JOIN tbl_category ON tbl_events.`cat_id`= tbl_category.`cid` WHERE tbl_events.`status`='1' AND (tbl_events.`website`='public' OR tbl_events.`website`='private' AND tbl_events.`user_id`= $ids) AND tbl_events.`id`='$event_id'AND tbl_events.`is_slider`='1' ORDER BY tbl_events.`id` DESC";	

				$sql_res=mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));

				$row_data=mysqli_fetch_assoc($sql_res);

				$event_title=$row_data['event_title'];
				$image=$row_data['event_banner'];
				$event_address=$row_data['event_address'];
				$cat_id= $row_data['cat_id'];
				break;
				
				default:
				$event_title=$data['slider_title'];
				$cat_id='';
				$event_address='';
				$image=$data['external_image'];
				break;

			}
			
			if($sql_res->num_rows == 0 AND $data['slider_type']!='external'){
				continue;
			}

			$row4['event_id'] = $data['event_id'];
			$row4['event_type'] = $data['slider_type'];
			$row4['cat_id'] = ($cat_id!='') ? $cat_id : '';
			$row4['event_address'] = ($event_address!='') ? $event_address : '';
			$row4['event_title'] = ($event_title!='') ? $event_title : '';
			$row4['event_banner_thumb'] = get_thumb('images/'.$image,'500x250');
			$row4['external_link'] = ($data['external_url']!='') ? $data['external_url'] : '';

			array_push($jsonObj_4,$row4);
			
		}
		// Get event slider end
		$row['event_slider']=$jsonObj_4;

		// Get recent event start
		$jsonObj_2= array();	

		if($ids!=0){
			
			$sql_all="SELECT * FROM tbl_recent WHERE `user_id`='$ids' ORDER By `recent_date` DESC";
			$res=mysqli_query($mysqli, $sql_all);

			while($data_all = mysqli_fetch_assoc($res))
			{	
				$event_id=trim($data_all['event_id']);
				
				$query_all1="SELECT tbl_events.`id`,tbl_events.`event_title`, tbl_events.`event_banner`,tbl_events.`event_address`,tbl_events.`cat_id` FROM tbl_events LEFT JOIN tbl_category ON tbl_events.`cat_id`= tbl_category.`cid` WHERE tbl_events.`status`='1' AND (tbl_events.`website`='public' OR tbl_events.`website`='private' AND tbl_events.`user_id`= $ids) AND tbl_events.`id`='$event_id' ORDER BY tbl_events.`id` DESC LIMIT ".API_RECENT_LIMIT;
				
				$sql_res_all1=mysqli_query($mysqli,$query_all1) or die(mysqli_error($mysqli));

				if(mysqli_num_rows($sql_res_all1) > 0){

					$row_data1=mysqli_fetch_assoc($sql_res_all1);

					$row_all1['id'] = $row_data1['id'];
					$row_all1['cat_id'] = $row_data1['cat_id'];
					$row_all1['category_name'] = get_category_name($row_data1['cat_id']);
					$row_all1['event_title'] = stripslashes($row_data1['event_title']);
					$row_all1['event_banner_thumb'] = get_thumb('images/'.$row_data1['event_banner'],'180x120');
    				$row_all1['event_address'] = $row_data1['event_address'];
    				$row_all1['event_date'] = date('d,M',$row_data1['event_start_date']);
    				$row_all1['is_fav']=get_favourite_info($row_data1['id'],$ids);

					array_push($jsonObj_2,$row_all1);
				}

			}
		}
		// Get recent event end
		
		$row['recent_views']=$jsonObj_2; 
		
		$jsonObj2= array();

	    // Get nearby home event start
		$latitude = $get_method['user_lat'];
		$longitude = $get_method['user_long'];

        $earthRadius = '6371.0'; // In miles(3959)  

        $sql2 = mysqli_query($mysqli,"
        	SELECT e.*,c.*,
        	ROUND(
        	$earthRadius * ACOS(  
        	SIN( $latitude*PI()/180 ) * SIN( event_map_latitude*PI()/180 )
        	+ COS( $latitude*PI()/180 ) * COS( event_map_longitude*PI()/180 )  *  COS( (event_map_longitude*PI()/180) - ($longitude*PI()/180) )   ) 
        	, 1)
        	AS distance                              

        	FROM
        	tbl_events e,tbl_category c
        	WHERE e.cat_id= c.cid 
        	AND (e.`website`='public' OR e.`website`='private' AND e.`user_id`= $ids)
        	AND  e.status='1'
        	ORDER BY
        	distance LIMIT 5"); 


        while($data2 = mysqli_fetch_assoc($sql2))
        {
        	$row2['id'] = $data2['id'];
        	$row2['cat_id'] = $data2['cat_id'];
        	$row2['category_name'] = get_category_name($data2['cat_id']);
        	$row2['event_title'] = stripslashes($data2['event_title']);
        	$row2['event_address'] = $data2['event_address'];
        	$row2['event_date'] = date('d,M',$data2['event_start_date']);
        	$row2['event_banner_thumb'] = get_thumb('images/'.$data2['event_banner'],'500x250');
        	$row2['is_fav']=get_favourite_info($data2['id'],$ids);

        	array_push($jsonObj2,$row2);
        }

        // Get nearby home event end
        $row['nearby_home']=$jsonObj2;  

        // Get category list start
        $jsonObj_1= array();

        $cat_order=API_CAT_ORDER_BY;	

        $query="SELECT * FROM tbl_category
        WHERE tbl_category.`status`=1 ORDER BY tbl_category.$cat_order ".API_CAT_POST_ORDER_BY." LIMIT 10";

        $sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

        while($data = mysqli_fetch_assoc($sql))
        {
        	$row1['cat_count'] = get_total_item($data['cid']);
        	$row1['cid'] = $data['cid'];
        	$row1['category_name'] = $data['category_name'];
        	$row1['category_image'] = $file_path.'images/'.$data['category_image'];
        	$row1['category_image_thumb'] = get_thumb('images/'.$data['category_image'],'250x250');

        	if($data['category_icon']==''){
        		$row1['category_icon'] = '';
        	}
        	else{
        		$row1['category_icon'] = $file_path.'images/'.$data['category_icon'];
        	}

        	if($data['app_bg_color_rgba']==''){
        		$row1['category_bg'] = '';	
        	}
        	else{
        		$row1['category_bg'] = $data['app_bg_color_rgba'];
        	}

        	array_push($jsonObj_1,$row1);

        }

        // Get category list end
        $row['cat_list'] = $jsonObj_1;

        $set = $row;

        header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        die();
    }  
    // Get home event end

    // Get recent view all start
    else if ($get_method['method_name']=="recent_views_all") {

    	$page_limit= API_RECENT_LIMIT;

    	$limit=($get_method['page']-1) * $page_limit;

    	$jsonObj1= array();	

    	$ids=$get_method['user_id'];

    	if($ids!=0){

    		$sql_all="SELECT * FROM tbl_recent WHERE `user_id`='$ids' ORDER By `recent_date` DESC";
    		$res=mysqli_query($mysqli, $sql_all);

    		while($data_all = mysqli_fetch_assoc($res))
    		{	
    			$event_id=trim($data_all['event_id']);

    			$query="SELECT tbl_events.`id`,tbl_events.`event_title`, tbl_events.`event_banner`,tbl_events.`event_address`,tbl_events.`event_start_date`,tbl_events.`cat_id` FROM tbl_events LEFT JOIN tbl_category ON tbl_events.`cat_id`= tbl_category.`cid` WHERE tbl_events.`status`='1' AND (tbl_events.`website`='public' OR tbl_events.`website`='private' AND tbl_events.`user_id`= $ids) AND tbl_events.`id`='$event_id' ORDER BY tbl_events.`id` DESC LIMIT $limit,$page_limit";

    			$sql_res=mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));

    			while($row_data = mysqli_fetch_assoc($sql_res))
    			{	

    				$row_all['id'] = $row_data['id'];
    				$row_all['cat_id'] = $row_data['cat_id'];
    				$row_all['event_title'] = stripslashes($row_data['event_title']);
    				$row_all['event_address'] = $row_data['event_address'];
    				$row_all['event_date'] = date('d,M',$row_data['event_start_date']);
    				$row_all['event_banner_thumb'] = get_thumb('images/'.$row_data['event_banner'],'500x250');

    				$row_all['is_fav']=get_favourite_info($row_data['id'],$ids);

    				array_push($jsonObj1,$row_all);

    			}
    		}
    		$set['status'] = '1';
    		$set['message'] = '';
    		$set['EVENT_APP'] = $jsonObj1;
    	}
    	else{
    		$set['status'] = '1';
    		$set['message'] = '';
    		$set['EVENT_APP']= array();
    	}

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    // Get recent view all end 

    // Get nearby event start
    else if($get_method['method_name']=="get_nearby")
    {

    	$jsonObj2= array();

    	$page_limit=API_PAGE_LIMIT;

    	$limit=($get_method['page']-1) * $page_limit;

    	$latitude = $get_method['user_lat'];
    	$longitude = $get_method['user_long'];
    	$user_id = $get_method['user_id'];

        $earthRadius = '6371.0'; // In miles(3959)  

        $sql2 = mysqli_query($mysqli,"
        	SELECT e.*,c.*,
        	ROUND(
        	$earthRadius * ACOS(  
        	SIN( $latitude*PI()/180 ) * SIN( event_map_latitude*PI()/180 )
        	+ COS( $latitude*PI()/180 ) * COS( event_map_longitude*PI()/180 )  *  COS( (event_map_longitude*PI()/180) - ($longitude*PI()/180) )   ) 
        	, 1)
        	AS distance                              

        	FROM
        	tbl_events e,tbl_category c
        	WHERE e.cat_id= c.`cid` AND (e.`website`='public' OR e.`website`='private' AND e.`user_id`= $user_id) AND  e.`status`='1'
        	ORDER BY `distance` LIMIT $limit,$page_limit"); 

        while($data2 = mysqli_fetch_assoc($sql2))
        {	
        	$row2['id'] = $data2['id'];
        	$row2['cat_id'] = $data2['cat_id'];
        	$row2['event_title'] = stripslashes($data2['event_title']);
        	$row2['event_address'] = $data2['event_address'];
        	$row2['event_date'] = date('d,M',$data2['event_start_date']);
        	$row2['event_banner_thumb'] = get_thumb('images/'.$data2['event_banner'],'500x250');
        	$row2['is_fav']=get_favourite_info($data2['id'],$user_id);

        	array_push($jsonObj2,$row2);

        }
        $set['status'] = '1';
        $set['message'] = '';
        $set['EVENT_APP']=$jsonObj2;  

        header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        die();
    }
    // Get nearby event end

    // Get category start
    else if($get_method['method_name']=="get_category")
    {
    	$jsonObj= array();

    	$cid=API_CAT_ORDER_BY;

    	$page_limit=API_PAGE_LIMIT;
    	$limit=($get_method['page']-1) * $page_limit;

    	$query="SELECT * FROM tbl_category WHERE tbl_category.`status`=1 ORDER BY tbl_category.$cid LIMIT $limit, $page_limit";
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

    	while($data = mysqli_fetch_assoc($sql))
    	{
    		$row['cat_count'] = get_total_item($data['cid']);
    		$row['cid'] = $data['cid'];
    		$row['category_name'] = $data['category_name'];
    		$row['category_image'] = $file_path.'images/'.$data['category_image'];
    		$row['category_image_thumb'] = get_thumb('images/'.$data['category_image'],'250x250');

    		if($data['category_icon']==''){
    			$row['category_icon'] = '';
    		}
    		else{
    			$row['category_icon'] = $file_path.'images/'.$data['category_icon'];
    		}

    		if($data['app_bg_color_rgba']==''){
    			$row['category_bg'] = '';	
    		}
    		else{
    			$row['category_bg'] = $data['app_bg_color_rgba'];
    		}

    		array_push($jsonObj,$row);
    	}

    	$set['status'] = '1';
    	$set['message'] = '';
    	$set['EVENT_APP'] = $jsonObj;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    // Get category end
    // Get card images start
    else if($get_method['method_name']=="get_card_images")
    {
    	$jsonObj= array();
    // 	$page_limit=API_PAGE_LIMIT;
    // 	$limit=($get_method['page']-1) * $page_limit;
// 		$query="SELECT * FROM invitation_card_image ORDER BY invitation_card_image.`id` LIMIT $limit, $page_limit";
		$query="SELECT * FROM invitation_card_image ORDER BY invitation_card_image.`id`"; 
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

    	while($data = mysqli_fetch_assoc($sql))
    	{
    		$row['id'] = $data['id'];
			$row['category_name'] = get_category_name($data['category_id']);
    		$row['category_id'] = $data['category_id'];
    		$row['card_image'] = $file_path.'images/'.$data['card_image'];
    		$row['card_image_thumb'] = get_thumb('images/'.$data['card_image'],'250x250');

    		array_push($jsonObj,$row);
    	}
    	$set['message'] = '';
    	$set['EVENT_APP'] = $jsonObj;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    // Get card images end

    // Get category upload start
    else if($get_method['method_name']=="get_category_upload")
    {
    	$jsonObj= array();

    	$query="SELECT * FROM tbl_category WHERE tbl_category.`status`=1 ORDER BY tbl_category.`cid`";
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

    	while($data = mysqli_fetch_assoc($sql))
    	{
    		$row['cid'] = $data['cid'];
    		$row['category_name'] = $data['category_name'];
    		array_push($jsonObj,$row);
    	}

    	$set['status'] = '1';
    	$set['message'] = '';
    	$set['EVENT_APP'] = $jsonObj;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    } 
    // Get category upload end

     // Get event by cat start
    else if($get_method['method_name']=="events_by_cat")
    {
    	$post_order_by=API_CAT_POST_ORDER_BY;

    	$cat_id=$get_method['cat_id'];	
    	$user_id=$get_method['user_id'];	

    	$page_limit=API_PAGE_LIMIT;

    	$limit=($get_method['page']-1) * $page_limit;

    	$jsonObj= array();	
        if($user_id)
        {
            if($cat_id == 0)
            {
                
            	$userQuery="SELECT * FROM tbl_events
            	LEFT JOIN tbl_category ON tbl_events.`cat_id`= tbl_category.`cid` 
            	WHERE tbl_events.`user_id`='$user_id' AND tbl_events.`status`='1' AND tbl_category.`status`='1' ORDER BY tbl_events.`id` ".$post_order_by." LIMIT $limit, $page_limit";
            }else{
                
            	$userQuery="SELECT * FROM tbl_events
            	LEFT JOIN tbl_category ON tbl_events.`cat_id`= tbl_category.`cid` 
            	WHERE tbl_events.`cat_id`='$cat_id'  AND tbl_events.`user_id`='$user_id' AND tbl_events.`status`='1' AND tbl_category.`status`='1' ORDER BY tbl_events.`id` ".$post_order_by." LIMIT $limit, $page_limit";
            }
        	$userSql = mysqli_query($mysqli,$userQuery)or die(mysqli_error($mysqli));
        	while($user_data = mysqli_fetch_assoc($userSql))
        	{
        		$row['id'] = $user_data['id'];
        		$row['cat_id'] = $user_data['cat_id'];
        		$row['website'] = $user_data['website'];
        		$row['event_title'] = stripslashes($user_data['event_title']);
    
        		$row['event_address'] = $user_data['event_address'];
    
        		$row['event_date'] = date('d,M',$user_data['event_start_date']);
    
        		$row['event_banner_thumb'] = get_thumb('images/'.$user_data['event_banner'],'500x250');
    			$row['category_name'] = get_category_name($user_data['cat_id']);
        		$row['is_fav']=get_favourite_info($user_data['id'],$user_id);
    
        		array_push($jsonObj,$row);
    
        	}
        }else{
            if($cat_id == 0)
            {
                
            	$query = "SELECT * FROM tbl_events
            	LEFT JOIN tbl_category ON tbl_events.`cat_id`= tbl_category.`cid` 
            	WHERE tbl_events.`status`='1' AND tbl_events.`website`='public' AND tbl_category.`status`='1' ORDER BY tbl_events.`id` ".$post_order_by." LIMIT $limit, $page_limit";
            }else{
                
            	$query = "SELECT * FROM tbl_events
            	LEFT JOIN tbl_category ON tbl_events.`cat_id`= tbl_category.`cid` 
            	WHERE tbl_events.`cat_id`='$cat_id' AND tbl_events.`status`='1' AND tbl_events.`website`='public' AND tbl_category.`status`='1' ORDER BY tbl_events.`id` ".$post_order_by." LIMIT $limit, $page_limit";
            }
        	 $sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));
        	 
        	while($data = mysqli_fetch_assoc($sql))
        	{
        		$row['id'] = $data['id'];
        		$row['cat_id'] = $data['cat_id'];
        		$row['event_title'] = stripslashes($data['event_title']);
    
        		$row['event_address'] = $data['event_address'];
        		$row['website'] = $data['website'];
    
        		$row['event_date'] = date('d,M',$data['event_start_date']);
    
        		$row['event_banner_thumb'] = get_thumb('images/'.$data['event_banner'],'500x250');
    			$row['category_name'] = get_category_name($data['cat_id']);
        		$row['is_fav']=get_favourite_info($data['id'],$user_id);
    
        		array_push($jsonObj,$row);
    
        	}
        }
            
            
        

    	
    	
    	
    	$set['status'] = '1';
    	$set['message'] = '';		
    	$set['EVENT_APP'] = $jsonObj;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    // Get event by cat end

    // Get search event start
    else if($get_method['method_name']=="search_event")
    {
    	$page_limit=API_PAGE_LIMIT;

    	$limit=($get_method['page']-1) * $page_limit;

    	$user_id=$get_method['user_id'];	

    	$event_search=addslashes(trim($get_method['event_search']));	

    	$jsonObj= array();	

    	$query="SELECT * FROM tbl_events
    	LEFT JOIN tbl_category ON tbl_events.`cat_id`= tbl_category.`cid` 
    	WHERE (tbl_events.`event_title` LIKE '%$event_search%' OR tbl_events.`event_description` LIKE '%$event_search%' OR tbl_events.`event_address` LIKE '%$event_search%') AND tbl_events.`status`='1' AND tbl_category.`status`='1' ORDER BY tbl_events.`event_title` LIMIT $limit, $page_limit";

    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

    	while($data = mysqli_fetch_assoc($sql))
    	{
    		$row['id'] = $data['id'];
    		$row['cat_id'] = $data['cat_id'];
    		$row['event_title'] = stripslashes($data['event_title']);

    		$row['event_address'] = $data['event_address'];

    		$row['event_date'] = date('d,M',$data['event_start_date']);

    		$row['event_banner_thumb'] = get_thumb('images/'.$data['event_banner'],'500x250');

    		$row['is_fav']=get_favourite_info($data['id'],$user_id);

    		array_push($jsonObj,$row);

    	}

    	$set['status'] = '1';
    	$set['message'] = '';
    	$set['EVENT_APP'] = $jsonObj;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    // Get search event end

    // Get single event start
    else if($get_method['method_name']=="single_event")
    { 

    	$jsonObj= array();

    	$set['status'] = '1';
    	$set['message'] = '';
    	$set['success'] = '1';
    	
    	$user_id= $get_method['user_id'];
    	$event_id= $get_method['event_id'];		
    	
    	$query="SELECT tbl_events.*, tbl_category.`cid`,tbl_category.`category_name`, tbl_category.`category_image`, tbl_category.`category_icon`, tbl_category.`app_bg_color_rgba` FROM tbl_events LEFT JOIN tbl_category ON tbl_events.`cat_id`=tbl_category.`cid`
    	 WHERE tbl_events.`id`= '$event_id'";
    	
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));
    	
    	if(mysqli_num_rows($sql) > 0){
    		
    		$data = mysqli_fetch_assoc($sql);

    		if($data['status']==1 OR ($user_id==$data['user_id'] AND $event_id==$data['id']) ){
    			$registration_str=explode('/', $data['registration_start']);

    			$registration_date=$registration_str[0];
    			$registration_time=$registration_str[1];

    			$registration_end_str=explode('/', $data['registration_end']);

    			$registration_end_date=$registration_end_str[0];
    			$registration_end_time=$registration_end_str[1];

    			$set['is_event'] = $data['registration_closed'];

    			$set['id'] = $data['id'];
    			$set['cat_id'] = $data['cat_id'];
    			$set['user_id'] = $data['user_id'];
    			$set['event_title'] = stripslashes($data['event_title']);
    			$set['event_description'] = stripslashes($data['event_description']);

    			$set['event_email'] = $data['event_email'];
    			$set['event_phone'] = $data['event_phone'];
    			$set['event_website'] = $data['event_website'];
    			$set['event_address'] = $data['event_address'];
    			$set['event_map_latitude'] = $data['event_map_latitude'];
    			$set['event_map_longitude'] = $data['event_map_longitude'];

    			$set['event_date_time'] = date('d, M Y D ',$data['event_start_date']) . date('h:i a ',$data['event_start_time']) .'To'. date(' d, M Y D ',$data['event_end_date']) . date('h:i a',$data['event_end_time']);

    			if($registration_str[0]!='' && $registration_end_str[0]!=''){

    				$set['event_registration_date_time'] = date('d, M Y D ',$registration_date).date('h:i a ',$registration_time).'To'.date(' d, M Y D ',$registration_end_date).date('h:i a ',$registration_end_time);

    			}
    			else{
    				$set['event_registration_date_time'] = '';
    			}
                $sqlBooking ="SELECT * FROM tbl_event_booking WHERE tbl_event_booking.`event_id`='".$data['id']."' AND tbl_event_booking.`user_id`='".$data['user_id']."'";
        		$bookingResponse =mysqli_query($mysqli, $sqlBooking);
        
        		if(mysqli_num_rows($bookingResponse) > 0){
            		$set['already_booked'] = 1;
        		}else{
        		    $set['already_booked'] = 0;
        		}
    			$set['event_logo'] = $file_path.'images/'.$data['event_logo'];
    			$set['event_logo_thumb'] = get_thumb('images/'.$data['event_logo'],'80x80');

    			$set['event_banner'] = $file_path.'images/'.$data['event_banner'];
    			$set['event_banner_thumb'] = get_thumb('images/'.$data['event_banner'],'500x250');

    			$set['total_views'] = $data['total_views'];

    			$set['event_ticket'] = $data['event_ticket'];
    			$set['person_wise_ticket'] = $data['person_wise_ticket'];
    			$set['ticket_price'] = $data['ticket_price'];
    			$set['booking_id'] =get_event_booking_info($event_id,'id');
    			$set['share_link'] = $file_path.'view_event.php?event_id='.$event_id;

    			$set['is_fav']=get_favourite_info($data['id'],$user_id);

    			$sql_cover="SELECT * FROM tbl_event_cover WHERE tbl_event_cover.`event_id`='$event_id'";
    			$res_cover=mysqli_query($mysqli, $sql_cover);

    			if(mysqli_num_rows($res_cover) > 0){
    				while ($row_cover=mysqli_fetch_assoc($res_cover)) {
    					$row_img['cover_id'] = $row_cover['id'];
    					$row_img['cover_image'] = $file_path.'images/'.$row_cover['image_file'];

    					$set['cover_images'][]=$row_img;
    				}	
    			}
    			else{
    				$set['cover_images']=array();
    			}
    			// Add recent views event
    			$view_qry=mysqli_query($mysqli,"UPDATE tbl_events SET `total_views` = total_views + 1 WHERE tbl_events.`id` = '$event_id' AND tbl_events.`user_id` =`$user_id`");

    			if($data['status']==1){
    				if($user_id > 0){
    					
    					$sql_recent="SELECT * FROM tbl_recent WHERE `event_id`= '$event_id' AND `user_id`= '$user_id' ";
    					$res_recent=mysqli_query($mysqli, $sql_recent);
    					$num_rows = mysqli_num_rows($res_recent);

    					$recent_date=date('Y-m-d');

    					if ($num_rows == 0 && $user_id !='')
    					{

    						$data_log = array(
    							'user_id'  =>  $user_id,
    							'event_id'  =>$set['id'],
    							'recent_date' => $recent_date
    						);

    						$qry = Insert('tbl_recent',$data_log);

    					} 
    					else{
    						$recent_row = mysqli_fetch_assoc($res_recent);

    						$data1= array( 
    							'recent_date'  => $recent_date
    						);		

    						$qry=Update('tbl_recent', $data1, "WHERE re_id = '".$recent_row['re_id']."'");

    					}
    				}

    			}	
    			
    			$event_status=eventStatus($registration_str[2], $registration_end_str[2]);
    			
    			if($user_id==$data['user_id'] && $data['user_id']!=0 && $data['registration_closed']=='false'){

    				$total_booked=get_total_booking($event_id);

    				$remain_tickets=$data['event_ticket']-$total_booked;

    				$set['remain_tickets'] = $remain_tickets;			

    				$set['is_userList'] = 'true';
    				$set['is_booking'] = 'false';
    			}
    			else if($user_id==$data['user_id'] && $data['user_id']!=0 && $data['registration_closed']=='true'){

    				$total_booked=get_total_booking($event_id);

    				$remain_tickets=$data['event_ticket']-$total_booked;

    				$set['remain_tickets'] = $remain_tickets;			

    				$set['is_userList'] = 'true';
    				$set['is_booking'] = 'false';
    			}
    			else if($user_id!=$data['user_id'] && $data['user_id']!=0 && $data['registration_closed']=='true'){

    				$total_booked=get_total_booking($event_id);

    				$remain_tickets=$data['event_ticket']-$total_booked;

    				$set['remain_tickets'] = $remain_tickets;			

    				$set['is_userList'] = 'false';
    				$set['is_booking'] = 'false';
    			}
    			else{
    				$set['is_userList'] = 'false';

    				$set['remain_tickets'] = '';

    				if($event_status==1 && $user_id!=0 && $data['registration_closed']=='false'){
    					$set['is_booking'] = 'true';
    				}
    				else if($user_id==0){
    					$set['is_booking'] = 'true';	
    				}
    				else{
    					$set['is_booking'] = 'false';
    				}
    			}		
    		}
    		else{
    			// blank when no data found
    			$set['msg']= $app_lang['no_data_found'];
    			$set['message'] = '';
    			$set['status']=1;
    			$set['success'] = '0';
    		}

    	}

    	else{
			// blank when no data found
    		$set['msg']= $app_lang['event_not_found'];
    		$set['message'] = '';
    		$set['status']=1;
    		$set['success']='0';
    	}
      	
    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();	
    }
    // Get single event end

    // Get edit event start
    else if($get_method['method_name']=="get_edit_event")
    { 

    	$jsonObj= array();

    	$set['message'] = '';
    	$set['status']=1;

    	$event_id=$get_method['event_id'];		

    	$query="SELECT * FROM tbl_events WHERE tbl_events.`id`='$event_id' ORDER BY tbl_events.`id`";

    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));
    	$data = mysqli_fetch_assoc($sql);

    	$registration_str=explode('/', $data['registration_start']);

    	$registration_date=$registration_str[0];
    	$registration_time=$registration_str[1];

    	$registration_end_str=explode('/', $data['registration_end']);

    	$registration_end_date=$registration_end_str[0];
    	$registration_end_time=$registration_end_str[1];

    	$set['id'] = $data['id'];
    	$set['cat_id'] = $data['cat_id'];
    	$set['event_title'] = stripslashes($data['event_title']);
    	$set['event_description'] = stripslashes($data['event_description']);

    	$set['event_email'] = $data['event_email'];
    	$set['event_phone'] = $data['event_phone'];
    	$set['event_website'] = $data['event_website'];
    	$set['event_address'] = $data['event_address'];
    	$set['event_map_latitude'] = $data['event_map_latitude'];
    	$set['event_map_longitude'] = $data['event_map_longitude'];
    	$set['is_event'] = $data['registration_closed'];
    	$set['event_start_date'] = date('d, M Y D',$data['event_start_date']);
    	$set['event_start_time'] = date('h:i a',$data['event_start_time']);
    	$set['event_end_date'] = date('d, M Y D',$data['event_end_date']);
    	$set['event_end_time'] = date('h:i a',$data['event_end_time']);

    	$set['event_logo'] = $file_path.'images/'.$data['event_logo'];
    	$set['event_logo_thumb'] = get_thumb('images/'.$data['event_logo'],'500x250');

    	$set['event_banner'] = $file_path.'images/'.$data['event_banner'];
    	$set['event_banner_thumb'] = get_thumb('images/'.$data['event_banner'],'500x250');

    	$set['total_views'] = $data['total_views'];

    	$set['event_ticket'] = $data['event_ticket'];
    	$set['person_wise_ticket'] = $data['person_wise_ticket'];
    	$set['ticket_price'] = $data['ticket_price'];

    	if($registration_str[0]!='' && $registration_end_str[0]!=''){
    		$set['registration_start_date'] = date('d, M Y D',$registration_date);
    		$set['registration_start_time'] = date('h:i a',$registration_time);

    		$set['registration_end_date'] = date('d, M Y D',$registration_end_date);
    		$set['registration_end_time'] = date('h:i a',$registration_end_time);
    	}
    	else{
    		$set['registration_start_date'] = '';
    		$set['registration_start_time'] = '';

    		$set['registration_end_date'] = '';
    		$set['registration_end_time'] = '';
    	}

		//for edit purpose
    	$set['edit_event_start_date'] = date('d/m/Y',$data['event_start_date']);
    	$set['edit_event_start_time'] = date('H:i',$data['event_start_time']);
    	$set['edit_event_end_date'] = date('d/m/Y',$data['event_end_date']);
    	$set['edit_event_end_time'] = date('H:i',$data['event_end_time']);

    	if($registration_str[0]!=''){
    		$set['edit_registration_start_date'] = date('d/m/Y',$registration_date);
    		$set['edit_registration_start_time'] = date('H:i',$registration_time);

    		$set['edit_registration_end_date'] = date('d/m/Y',$registration_end_date);
    		$set['edit_registration_end_time'] = date('H:i',$registration_end_time);
    	}
    	else{
    		$set['edit_registration_start_date'] = '';
    		$set['edit_registration_start_time'] = '';

    		$set['edit_registration_end_date'] = '';
    		$set['edit_registration_end_time'] = '';
    	}

    	$sql_cover="SELECT * FROM tbl_event_cover WHERE event_id='".$get_method['event_id']."'";
    	$res_cover=mysqli_query($mysqli, $sql_cover);

    	if(mysqli_num_rows($res_cover) > 0){
    		while ($row_cover=mysqli_fetch_assoc($res_cover)) {
    			$row_img['cover_id'] = $row_cover['id'];
    			$row_img['cover_image'] = $file_path.'images/'.$row_cover['image_file'];

    			$set['cover_images'][]=$row_img;
    		}	
    	}
    	else{
    		$set['cover_images']=array();
    	}

    	$jsonObj_1= array();

    	$query="SELECT * FROM tbl_category WHERE tbl_category.`status`=1 ORDER BY tbl_category.`cid`";
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

    	while($data = mysqli_fetch_assoc($sql))
    	{
    		$row['cid'] = $data['cid'];
    		$row['category_name'] = $data['category_name'];
    		array_push($jsonObj_1,$row);
    	}

    	$set['EVENT_APP'] = $jsonObj_1;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();	
    }
    // Get edit event end

    // Get users event start
    else if($get_method['method_name']=="get_user_events")
    {
    	$user_id= $get_method['user_id'];  

    	$page_limit=API_PAGE_LIMIT;

    	$limit=($get_method['page']-1) * $page_limit;

    	$jsonObj_all= array();  

    	$query="SELECT * FROM tbl_events
    	WHERE tbl_events.`user_id`='$user_id' ORDER BY tbl_events.`id` DESC LIMIT $limit, $page_limit";
    	
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

    	while($data = mysqli_fetch_assoc($sql))
    	{

    		$row['id'] = $data['id'];
    		$row['cat_id'] = $data['cat_id'];
    		$row['event_title'] = stripslashes($data['event_title']);
    		$row['event_address'] = $data['event_address'];
    		$row['event_date'] = date('d,M',$data['event_start_date']);
    		$row['event_banner_thumb'] = get_thumb('images/'.$data['event_banner'],'500x250');
    		$row['total_views'] = $data['total_views'];

    		$row['is_fav']=get_favourite_info($data['id'],$user_id);
    		$row['is_reviewed'] = ($data['status']!=0) ? 'true' : 'false';
    		
    		array_push($jsonObj_all,$row);
    	}

    	$set['status'] = '1';
    	$set['message'] = '';
    	$set['EVENT_APP'] = $jsonObj_all;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    // Get users event end

    // Get add event start
    else if($get_method['method_name']=="add_event")
    {
    	$ext = pathinfo($_FILES['event_logo']['name'], PATHINFO_EXTENSION);
		$path = "images/"; //set your folder path
		$event_logo=date('dmYhis').'_'.rand(0,99999).".png";
		if ($ext == "heic" || $ext == "heif") {
    		$tpath1='images/'.$event_logo;            
            // Path to the HEIC image
            $heic_path = $_FILES["event_logo"]["tmp_name"];
            
            // Convert HEIC to PNG using imagick
            $imagick = new \Imagick();
            $imagick->readImage($heic_path);
            $imagick->setImageFormat("png");
            $png_data = $imagick->getImageBlob();
            
            // Save the PNG file
            file_put_contents($path . $event_logo, $png_data);
    
        } else {
    		//Main Image
    		$tpath1='images/'.$event_logo;            
    		$pic1=compress_image($_FILES["event_logo"]["tmp_name"], $tpath1, 60);   
        }
		//Thumb Image 
		$thumbpath='images/thumbs/'.$event_logo;     
		$thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');  

		$ext = pathinfo($_FILES['event_banner']['name'], PATHINFO_EXTENSION);
		$path = "images/"; //set your folder path
		$event_banner=date('dmYhis').'_'.rand(0,99999).".png";
		if ($ext == "heic" || $ext == "heif") {
    		$tpath1='images/'.$event_banner;        
            // Path to the HEIC image
            $heic_path = $_FILES["event_banner"]["tmp_name"];
            
            // Convert HEIC to PNG using imagick
            $imagick = new \Imagick();
            $imagick->readImage($heic_path);
            $imagick->setImageFormat("png");
            $png_data = $imagick->getImageBlob();
            
            // Save the PNG file
            file_put_contents($path . $event_banner, $png_data);
    
        } else {
    		//Main Image
    		$tpath1='images/'.$event_banner;        
    		$pic1=compress_image($_FILES["event_banner"]["tmp_name"], $tpath1, 60);   
        }
		//Thumb Image 
		$thumbpath='images/thumbs/'.$event_banner;   
		$thumb_pic1=create_thumb_image($tpath1,$thumbpath,'450','250'); 

		$event_start_time=strtotime(strtoupper(str_replace(' ','',$get_method['event_start_time'])));
		$event_end_time=strtotime(strtoupper(str_replace(' ','',$get_method['event_end_time'])));   
        if($get_method['website'] == "private")
        {
            $registration_from = null;
            $registration_end = null;
            $event_ticket = 0;
            $person_wise_ticket = 0;
            $ticket_price = 0;
        }else{
            
    		// for registration start data and time
    		$registration_date=strtotime($get_method['registration_start_date']);
    		$registration_time=strtotime(str_replace(' ','',$get_method['registration_start_time']));      
    
    		$actual_reg_from=strtotime($get_method['registration_start_date'].' '.str_replace(' ','',$get_method['registration_start_time']));   
    
    		$registration_from=$registration_date.'/'.$registration_time.'/'.$actual_reg_from; 
    
    		// for registration end data and time
    		$registration_date=strtotime($get_method['registration_end_date']);
    		$registration_time=strtotime(str_replace(' ','',$get_method['registration_end_time']));      
    
    		$actual_reg_end=strtotime($get_method['registration_end_date'].' '.str_replace(' ','',$get_method['registration_end_time'])); 
    
    		$registration_end=$registration_date.'/'.$registration_time.'/'.$actual_reg_end;   
            $event_ticket = cleanInput($get_method['event_ticket']);
            $person_wise_ticket = cleanInput($get_method['person_wise_ticket']);
            $ticket_price = cleanInput($get_method['ticket_price']);
        }

		$data = array( 
			'user_id'  =>  $get_method['user_id'],
			'cat_id'  =>  $get_method['cat_id'],
			'event_title'  =>  cleanInput($get_method['event_title']),
			'event_description'  =>  addslashes(trim($get_method['event_description'])),
			'event_email'  =>  cleanInput($get_method['event_email']),
			'event_phone'  =>  cleanInput($get_method['event_phone']),
			'event_website'  =>  cleanInput($get_method['event_website']),
			'website'  =>  $get_method['website'],
			'event_address'  =>  addslashes(trim($get_method['event_address'])),
			'event_map_latitude'  =>  $get_method['event_map_latitude'],
			'event_map_longitude'  =>  $get_method['event_map_longitude'], 
			'event_start_date'  =>  strtotime($get_method['event_start_date']),
			'event_start_time'  =>  $event_start_time,
			'event_end_date'  =>  strtotime($get_method['event_end_date']), 
			'event_end_time'  =>  $event_end_time,
			'registration_start'  =>  $registration_from,
			'registration_end'  =>  $registration_end,
			'event_ticket'  =>  $event_ticket,
			'person_wise_ticket'  =>  $person_wise_ticket,
			'ticket_price'  =>  $ticket_price,
			'event_logo'  =>  $event_logo,
			'event_banner'  =>  $event_banner
		);    

		$qry = Insert('tbl_events',$data);

		$last_id=mysqli_insert_id($mysqli);

		$size_sum = array_sum($_FILES['event_cover']['size']);

		if($size_sum > 0)
		{  
			for ($i = 0; $i < count($_FILES['event_cover']['name']); $i++) 
			{

				$ext = pathinfo($_FILES['event_cover']['name'][$i], PATHINFO_EXTENSION);

	          $path = "images/"; //set your folder path
	          $image_file=date('dmYhis').'_'.rand(0,99999).'_'.$i.".png";
	          $tpath1=$path.$image_file;    
	          if ($ext == "heic" || $ext == "heif") {
                    // Path to the HEIC image
                    $heic_path = $_FILES["event_cover"]["tmp_name"][$i];
                    
                    // Convert HEIC to PNG using imagick
                    $imagick = new \Imagick();
                    $imagick->readImage($heic_path);
                    $imagick->setImageFormat("png");
                    $png_data = $imagick->getImageBlob();
                    
                    // Save the PNG file
                    file_put_contents($tpath1, $png_data);
            
                } else {
            		 if($ext!='png'){
        	          	$pic1=compress_image($_FILES["event_cover"]["tmp_name"][$i], $tpath1, 60);
        	          }else{
        	          	move_uploaded_file($_FILES['event_cover']['tmp_name'][$i], $tpath1);
        	          }  
                }

	         

	          $thumbpath='images/thumbs/'.$image_file;

	          $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'450','250');

	          $data1 = array(
	          	'event_id'=>$last_id,
	          	'image_file'  => $image_file                         
	          );      

	          $qry1 = Insert('tbl_event_cover',$data1); 
	      }
	  }

	  $set=array('status' => '1','message' => '','msg' => $app_lang['add_success'],'success'=>'1','event_id'=>$last_id);

	  header('Content-Type: application/json; charset=utf-8' );
	  $json = json_encode($set);
	  echo $json;
	  exit;
	}
	// Get add event end

	// Update event start
	else if($get_method['method_name']=="edit_event")
	{
		$event_start_time=strtotime(str_replace(' ','',$get_method['event_start_time']));
		$event_end_time=strtotime(str_replace(' ','',$get_method['event_end_time'])); 
        if($get_method['website'] == 'private')
        {
            $registration_from = null;
            $registration_end = null;
            $event_ticket = 0;
            $person_wise_ticket = 0;
            $ticket_price = 0;
        }else{
            
    		// for registration start data and time
    		$registration_date=strtotime($get_method['registration_start_date']);
    		$registration_time=strtotime(str_replace(' ','',$get_method['registration_start_time']));      
    
    		$actual_reg_from=strtotime($get_method['registration_start_date'].' '.str_replace(' ','',$get_method['registration_start_time']));   
    
    		$registration_from=$registration_date.'/'.$registration_time.'/'.$actual_reg_from; 
    
    		// for registration end data and time
    		$registration_date=strtotime($get_method['registration_end_date']);
    		$registration_time=strtotime(str_replace(' ','',$get_method['registration_end_time']));      
    
    		$actual_reg_end=strtotime($get_method['registration_end_date'].' '.str_replace(' ','',$get_method['registration_end_time'])); 
    
    		$registration_end=$registration_date.'/'.$registration_time.'/'.$actual_reg_end;   
            $event_ticket = cleanInput($get_method['event_ticket']);
            $person_wise_ticket = cleanInput($get_method['person_wise_ticket']);
            $ticket_price = cleanInput($get_method['ticket_price']);
        }
		
		$event_id=$get_method['event_id'];

		$sql="SELECT * FROM tbl_events WHERE `id`=$event_id";
		$res=mysqli_query($mysqli, $sql);
		$row=mysqli_fetch_assoc($res);

		$event_logo=$row['event_logo'];

		$event_banner=$row['event_banner'];

		if($_FILES['event_logo']['name']!="")
		{
			if($row['event_logo']!="")
			{
				unlink('images/'.$row['event_logo']);
				unlink('images/thumbs/'.$row['event_logo']);
			}

			$ext = pathinfo($_FILES['event_logo']['name'], PATHINFO_EXTENSION);
			$path = "images/"; //set your folder path
			$event_logo=date('dmYhis').'_'.rand(0,99999)."_logo.png";    
			//Main Image
			$tpath1='images/'.$event_logo;        
			$pic1=compress_image($_FILES["event_logo"]["tmp_name"], $tpath1, 60);   
			//Thumb Image 
			$thumbpath='images/thumbs/'.$event_logo;   
			$thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');
		}

		if($_FILES['event_banner']['name']!="")
		{
			if($row['event_banner']!="")
			{
				unlink('images/'.$row['event_banner']);
				unlink('images/thumbs/'.$row['event_banner']);
			}

			$ext = pathinfo($_FILES['event_banner']['name'], PATHINFO_EXTENSION);
			$path = "images/"; //set your folder path
			$event_banner=date('dmYhis').'_'.rand(0,99999)."_banner.png";    
			//Main Image
			$tpath1='images/'.$event_banner;        
			$pic1=compress_image($_FILES["event_banner"]["tmp_name"], $tpath1, 60);   
			//Thumb Image 
			$thumbpath='images/thumbs/'.$event_banner;   
			$thumb_pic1=create_thumb_image($tpath1,$thumbpath,'450','250');
		}

		$data = array(
			'user_id'  =>  $get_method['user_id'], 
			'cat_id'  =>  $get_method['cat_id'],
			'event_title'  =>  cleanInput($get_method['event_title']),
			'event_description'  =>  addslashes(trim($get_method['event_description'])),
			'event_email'  =>  cleanInput($get_method['event_email']),
			'event_phone'  =>  cleanInput($get_method['event_phone']),
			'event_website'  =>  cleanInput($get_method['event_website']),
			'event_address'  =>  addslashes($get_method['event_address']),
			'event_map_latitude'  =>  $get_method['event_map_latitude'],
			'event_map_longitude'  =>  $get_method['event_map_longitude'], 
			'event_start_date'  => $get_method['event_start_date'] != null &&  $get_method['event_start_date'] != 0 ? strtotime($get_method['event_start_date']) : $row['event_start_date'],
			'event_start_time'  =>  $event_start_time,
			'event_end_date'  => $get_method['event_end_date'] != null &&  $get_method['event_end_date'] != 0 ? strtotime($get_method['event_end_date']) : $row['event_end_date'],
			'event_end_time'  =>  $event_end_time,
			'website'  =>  $get_method['website'],
			'registration_start'  =>  $registration_from,
			'registration_end'  =>  $registration_end,
			'event_ticket'  =>  $event_ticket,
			'person_wise_ticket'  =>  $person_wise_ticket,
			'ticket_price'  =>  $ticket_price,
			'event_logo'  =>  $event_logo,
			'event_banner'  =>  $event_banner,
			'registration_closed'  => $get_method['is_event'],
			'close_open_date'  =>  strtotime(date('d-m-Y h:i:s A')) 
		);

		$event_edit=Update('tbl_events', $data, "WHERE id = '".$get_method['event_id']."'");

		$last_id=$get_method['event_id'];

		$size_sum = array_sum($_FILES['event_cover']['size']);

		if($size_sum > 0)
		{  
			for ($i = 0; $i < count($_FILES['event_cover']['name']); $i++) 
			{

				$ext = pathinfo($_FILES['event_cover']['name'][$i], PATHINFO_EXTENSION);

	          $path = "images/"; //set your folder path
	          $image_file=date('dmYhis').'_'.rand(0,99999).'_'.$i.".png";

	          $tpath1=$path.$image_file;    
	          if($ext!='png'){
	          	$pic1=compress_image($_FILES["event_cover"]["tmp_name"][$i], $tpath1, 60);
	          }else{
	          	move_uploaded_file($_FILES['event_cover']['tmp_name'][$i], $tpath1);
	          }

	          $thumbpath='images/thumbs/'.$image_file;

	          $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'450','250');

	          $data1 = array(
	          	'event_id'=>$last_id,
	          	'image_file'  => $image_file                         
	          );      

	          $qry1 = Insert('tbl_event_cover',$data1); 
	      }
	  }

	  $sql="SELECT * FROM tbl_events WHERE id=$event_id";
	  $res=mysqli_query($mysqli, $sql);
	  $row=mysqli_fetch_assoc($res);

	  $data = array(
	  	'status' => '1',
	  	'message' => '',
	  	'success' => '1',
	  	'msg'=>$app_lang['update_success'],
	  	'event_title'  => $row['event_title'],
	  	'event_date' => date('d,M',$row['event_start_date']),
	  	'event_banner_thumb'  => get_thumb('images/'.$row['event_banner'],'500x250'),
	  	'event_address'  => $row['event_address']
	  );

	  $set=$data;   

	  header( 'Content-Type: application/json; charset=utf-8' );
	  $json = json_encode($set);
	  echo $json;
	  exit;
	}
	// Update event end

	// Add favourite event start
	else if($get_method['method_name']=="add_favourite")
	{
		$user_id =$get_method['user_id'];
		$event_id =$get_method['event_id'];

		$sql="SELECT * FROM tbl_favourite WHERE `user_id`='$user_id' AND `event_id`='$event_id'";
		$res=mysqli_query($mysqli, $sql);
		
		if($res->num_rows == 0){
			// add to favourite list

			$data = array( 
				'event_id'  =>  $event_id,
				'user_id'  =>  $user_id,
				'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
			);      

			$qry = Insert('tbl_favourite',$data);

			$set = array('status' => '1','message' => '','msg'=>$app_lang['add_favourite'],'success'=>1,'is_favourite'=>true);

		}
		else{
			// remove to favourite list

			$deleteSql="DELETE FROM tbl_favourite WHERE `user_id`='$user_id' AND `event_id`='$event_id'";

			if(mysqli_query($mysqli, $deleteSql)){
				$set = array('status' => '1','message' => '','msg'=>$app_lang['remove_favourite'],'success'=>1,'is_favourite'=>false);
			}
			else{

				$set = array('status' => '1','message' => '','msg'=>$app_lang['error_msg'],'success'=>0,'is_favourite'=>false);
			}
		}

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	// Add favourite event end

	// Get favourite list start
	else if($get_method['method_name']=="get_favourite_list")		
	{

		$post_order_by=API_CAT_POST_ORDER_BY;

		$user_id=$get_method['user_id'];

		$page_limit=API_PAGE_LIMIT;
		$limit=($get_method['page']-1) * $page_limit;

		$jsonObj_all= array();

		$query_all="SELECT tbl_events.*,tbl_category.`cid`,tbl_category.`category_name`,tbl_category.`category_image`,tbl_category.`category_icon`,tbl_category.`app_bg_color_rgba` FROM tbl_events
		LEFT JOIN tbl_category ON tbl_events.`cat_id`= tbl_category.`cid` 
		LEFT JOIN tbl_favourite ON tbl_events.`id`= tbl_favourite.`event_id` 
		WHERE tbl_events.`status`='1' AND tbl_category.`status`='1' AND tbl_favourite.`user_id`='$user_id' ORDER BY tbl_favourite.`id` DESC LIMIT $limit, $page_limit";

		$sql_all = mysqli_query($mysqli,$query_all)or die(mysqli_error($mysqli));

		while($data_all = mysqli_fetch_assoc($sql_all))
		{	
			$row_all['id'] = $data_all['id'];
			$row_all['cat_id'] = $data_all['cat_id'];
			$row_all['event_title'] = stripslashes($data_all['event_title']);
			$row_all['event_address'] = $data_all['event_address'];
			$row_all['event_date'] = date('d,M',$data_all['event_start_date']);
			$row_all['event_banner_thumb'] = get_thumb('images/'.$data_all['event_banner'],'500x250');
			$row_all['is_fav']=get_favourite_info($data_all['id'],$user_id);

			array_push($jsonObj_all,$row_all);	

		}

		$set['status'] = '1';
		$set['message'] = ''; 
		$set['EVENT_APP'] = $jsonObj_all;

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	// Get favourite list end

	// Get delete event start
	else if($get_method['method_name']=="delete_event")
	{

		$ids=$get_method['event_id'];

		$sql="SELECT * FROM tbl_events WHERE tbl_events.`id` IN ($ids)";
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

			$sql_gallery="SELECT * FROM tbl_event_cover WHERE tbl_event_cover.`event_id`='$row[id]'";
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

		Delete('tbl_event_booking','event_id='.$ids);

		$deleteSql="DELETE FROM tbl_events WHERE tbl_events.`id` IN ($ids)";

		mysqli_query($mysqli, $deleteSql);

		Delete('tbl_reports','event_id='.$ids);
		Delete('tbl_slider','event_id='.$ids);
		Delete('tbl_favourite','event_id='.$ids);

		$set =array('status' => '1','message' => '','msg' => $app_lang['delete_success'],'success'=>'1');
		header('Content-Type: application/json; charset=utf-8' );
		$json = json_encode($set);
		echo $json;
		exit;
	}
	// Get delete event end

	// Get event booking start
	else if($get_method['method_name']=="event_booking")
	{
		$event_id=$get_method['event_id'];

		$qry="SELECT * FROM tbl_events WHERE tbl_events.`id`='$event_id'";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_assoc($result);

		$user_id=$get_method['user_id'];
		$sql="SELECT * FROM tbl_event_booking WHERE tbl_event_booking.`event_id`='".$event_id."' AND tbl_event_booking.`user_id`='".$user_id."'";
		$res=mysqli_query($mysqli, $sql);

		if(mysqli_num_rows($res) > 0){
    	    $deleteSql="DELETE FROM tbl_event_booking WHERE tbl_event_booking.`event_id`='".$event_id."' AND tbl_event_booking.`user_id`='".$user_id."'";
            mysqli_query($mysqli, $deleteSql);
    		$total_booked=get_total_booking($event_id);
    		$set['status'] = '0';
    		$set['message'] = 'Your event has been unbooked'; 
    		$set['total_booked'] = $total_booked; 
    		$set['msg'] = 'Your event has been unbooked'; 
    		$set['success']='0';
		}else{
		    
    		$data = array( 
    			'event_id'  =>  $event_id,
    			'user_id'  =>  $user_id,
    			'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
    		);    
    
    		$qry = Insert('tbl_event_booking',$data);
    		$total_booked=get_total_booking($event_id);
    		$set['status'] = '1';
    		$set['message'] = ''; 
    		$set['total_booked'] = $total_booked; 
    		$set['msg']='Event has been booked by your email';
    		$set['success']='1';
		    
		}
// 		$name=$get_method['user_name'];
// 		$email= $get_method['user_email'];
// 		$phone= $get_method['user_phone'];
// 		$total_tickets= $get_method['total_tickets'];
// 		$user_message=$get_method['user_message'];

// 		$total_booked=get_total_booking($event_id);

// 		$remain_tickets=$row['event_ticket']-get_total_booking($event_id);

// 		if($remain_tickets >= $total_tickets){
// 			if($email!="")
// 			{
// 				$ticket_no=trim(strtoupper(substr($row['event_title'], 0, 4))).date('Y',$row['event_start_date']).createRandomCode();
// 				$to = $row['event_email'];
// 				$recipient_name=$name;
				
// 				$subject = ''.$row['event_title'].' New Booking';

// 				$message='<div style="background-color: #f9f9f9;" align="center"><br />
// 				<table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
// 				<tbody>
// 				<tr>
// 				<td colspan="2" bgcolor="#FFFFFF" align="center"><img src="'.$file_path.'images/'.APP_LOGO.'" alt="header" style="width:100px;height:100px"/></td>
// 				</tr>
// 				<tr>
// 				<td width="600" valign="top" bgcolor="#FFFFFF"><br>
// 				<table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
// 				<tbody>
// 				<tr>
// 				<td valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
// 				<tbody>
// 				<tr>
// 				<td> 
// 				<p style="color: #262626; font-size: 18px; margin-top:0px;">You have received new registration.</p>

// 				<p style="color:#262626; font-size:16px; line-height:10px;font-weight:500;"> 
// 				Ticket No.: '.$ticket_no.'</p>

// 				<p style="color:#262626; font-size:16px; line-height:10px;font-weight:500;"> 
// 				Name: '.$name.'</p>
// 				<p style="color:#262626; font-size:16px; line-height:10px;font-weight:500;"> 
// 				Email: '.$email.'</p>

// 				<p style="color:#262626; font-size:16px; line-height:10px;font-weight:500;"> 
// 				Phone: '.$phone.'</p>

// 				<p style="color:#262626; font-size:16px; line-height:10px;font-weight:500;"> 
// 				Tickets: '.$total_tickets.'</p>

// 				<p style="color:#262626; font-size:16px; line-height:10px;font-weight:500;"> 
// 				Message: '.$user_message.'</p>

// 				<p style="color:#262626; font-size:16px; line-height:18px;font-weight:500;margin-bottom:30px;">Thanks you,<br />
// 				'.APP_NAME.'.</p></td>
// 				</tr>
// 				</tbody>
// 				</table></td>
// 				</tr>

// 				</tbody>
// 				</table></td>
// 				</tr>
// 				<tr>
// 				<td style="color: #262626; padding: 20px 0; font-size: 18px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">Copyright © '.date('Y').' '.APP_NAME.'.</td>
// 				</tr>
// 				</tbody>
// 				</table>
// 				</div>';

// 				send_email($to,$recipient_name,$subject,$message);

// 				$email_user='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
// 				<html>
// 				<head>
// 				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
// 				<meta name="viewport" content="width=device-width, initial-scale=1.0" />
// 				<style>

// 				body, table, thead, tbody, tr, td, img {
// 					padding: 0;
// 					margin: 0;
// 					border: none;
// 					line-height:26px;
// 					border-spacing: 0px;
// 					border-collapse: collapse;
// 					vertical-align: top;
// 				}

// 				.wrapper {
// 					padding-left: 10px;
// 					padding-right: 10px;
// 				}
// 				strong{
// 					font-weight:600;
// 				}
// 				h1{
// 					margin: 0;
// 					padding: 0;
// 					font-size:22px;
// 					padding-bottom: 25px;
// 					line-height: 1.4;
// 					font-weight:600;
// 					font-family: "Poppins", "Arial", sans-serif;
// 				}
// 				h2 {
// 					margin: 0;
// 					padding: 0;
// 					font-size:18px;
// 					padding-bottom: 0px;
// 					line-height: 1.2;
// 					font-weight:600;
// 					font-family: "Poppins", "Arial", sans-serif;
// 				}
// 				h3 {
// 					margin: 0;
// 					padding: 0;
// 					font-size:16px;
// 					padding-bottom: 0px;
// 					line-height: 1.2;
// 					font-weight:500;
// 					font-family: "Poppins", "Arial", sans-serif;
// 				}
// 				p {
// 					font-size:15px;
// 					color:#424242;
// 					font-family: "Poppins", "Arial", sans-serif;
// 				}
// 				.user_details a{
// 					color:#424242 !important;
// 				}
// 				.user_details2 a{
// 					color:#fff !important;
// 				}
// 				a {
// 					font-size:15px;
// 					color:#fff;
// 					text-decoration:none;
// 					font-family: "Poppins", "Arial", sans-serif;
// 				}
// 				p, li {
// 					font-family: "Poppins", "Arial", sans-serif;
// 				}
// 				img.social_icon{
// 					width:60px;
// 					height:60px;
// 					margin:0 auto 10px auto;
// 					text-align:center
// 				}
// 				img {
// 					width: 100%;
// 					display: block;
// 				}
// 				@media only screen and (max-width: 620px) {
// 					.wrapper .section {
// 						width: 100%;
// 					}
// 					.wrapper .column {
// 						width: 100%;
// 						display: block;
// 					}
// 					table.section{
// 						width:94%;
// 					}
// 					.section td.column h3{
// 						padding-left:5px;
// 					}
// 					.section td.column{
// 						width:100%;
// 						display: block;
// 					}
// 				}
// 				</style>
// 				</head>
// 				<body>
// 				<table width="100%">
// 				<tbody>
// 				<tr>
// 				<td class="wrapper" width="600" align="center">            
// 				<table class="section header" cellpadding="0" cellspacing="0" width="600" style="margin-bottom:20px;margin-top:20px">
// 				<tr>
// 				<td class="column" width="290" valign="top">
// 				<table>
// 				<tbody>
// 				<tr>
// 				<td><img src="'.$file_path.'images/'.APP_LOGO.'" style="width:auto !important;height:auto !important" alt="" /></td>
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>
// 				<td class="column" width="20" valign="top">
// 				<table>
// 				<tbody>
// 				<tr>
// 				<td>&nbsp;</td>
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>
// 				<td class="column user_details" width="290" valign="top">
// 				<table>
// 				<tbody>
// 				<tr>
// 				<td><p style="text-align:left;">
// 				<strong>Name:</strong> '.$name.'<br>
// 				<strong>Mobile:</strong> '.$phone.'<br>
// 				<strong>Email:</strong><span style="color: #424242 !important"> '.$email.'</span><br>
// 				<strong>Booked By:</strong> '.get_user_info($user_id,'name').'<br>
// 				<strong>User Email:</strong><span style="color: #424242 !important"> '.get_user_info($user_id,'email').'</span><br>
// 				<strong>Booking Date:</strong> '.date('d M, Y').'</p>
// 				</td>
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>                
// 				</tr>
// 				</table>
// 				<table class="section header" cellpadding="0" cellspacing="0" width="600">
// 				<tr>
// 				<td class="column">
// 				<table>
// 				<tbody>
// 				<tr>
// 				<h1 style="color:#000000 !important">'.$row['event_title'].'</h1>                        
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>
// 				</tr>
// 				</table>            
// 				<table class="section" cellpadding="0" cellspacing="0">
// 				<tr>
// 				<table class="section header" cellpadding="0" cellspacing="0" width="600">
// 				<tr>
// 				<td class="column">
// 				<table>
// 				<tbody>
// 				<tr>
// 				<td><p style="text-align:left;"><h2 style="width:100%;color:#000000 !important">Location</h2>'.$row['event_address'].'</p></td>
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>
// 				</tr>
// 				</table>

// 				<table class="section header" cellpadding="0" cellspacing="0" width="600">
// 				<tr>
// 				<td class="column">
// 				<table>
// 				<tbody>
// 				<tr>
// 				<td><p style="text-align:left;">
// 				<h2 style="width:100%;color:#000000 !important">Date</h2>
// 				'.date('d M, Y',$row['event_start_date']).' , '.date('h:i a',$row['event_start_time']).'<br>
// 				'.date('d M, Y',$row['event_end_date']).' , '.date('h:i a',$row['event_end_time']).'</p>
// 				</td>
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>
// 				</tr>
// 				</table>
// 				</tr>
// 				</table>
// 				<table class="section" cellpadding="0" cellspacing="0" width="600" style="margin:0px auto 20px auto;background:#f5f5f5;border-radius:10px">
// 				<tr>
// 				<td class="column" width="150" valign="top">
// 				<table style="text-align:center;width:100%">
// 				<tbody>
// 				<tr>
// 				<td>
// 				<p style="text-align:center;color:#000000 !important">
// 				<strong>Ticket No.</strong><br>
// 				'.$ticket_no.'
// 				</p>
// 				</td>
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>
// 				<td class="column" width="150" valign="top">
// 				<table style="text-align:center;width:100%">
// 				<tbody>
// 				<tr>
// 				<td>
// 				<p style="text-align:center;">
// 				<strong>Nos. Tickets</strong><br>
// 				'.$total_tickets.'
// 				</p>
// 				</td>
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>
// 				<td class="column" width="150" valign="top">
// 				<table style="text-align:center;width:100%">
// 				<tbody>
// 				<tr>
// 				<td>
// 				<p style="text-align:center;">
// 				<strong>Ticket Price</strong><br>
// 				'.$row['ticket_price'].'
// 				</p>
// 				</td>
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>
// 				<td class="column" width="150" valign="top">
// 				<table style="text-align:center;width:100%">
// 				<tbody>
// 				<tr>
// 				<td>
// 				<p style="text-align:center;">
// 				<strong>Total Price</strong><br>
// 				'.$row['ticket_price']*$total_tickets.'								
// 				</p>
// 				</td>
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>                
// 				</tr>
// 				</table>
// 				<table class="section" cellpadding="0" cellspacing="0" width="600" style="margin:10px auto 0 auto;background:linear-gradient(90deg, rgba(169,121,59,1) 0%, rgba(179,110,22,1) 100%);border-radius:10px">
// 				<tr>
// 				<td class="column user_details2" width="200" valign="top">
// 				<table style="text-align:center;width:100%">
// 				<tbody>
// 				<tr>
// 				<td>
// 				<p style="text-align:center;">
// 				<img class="social_icon" src="'.$file_path.'assets/images/contact.png" alt="" />
// 				<a href="#">'.$row['event_phone'].'</a>
// 				</p>
// 				</td>
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>
// 				<td class="column user_details2" width="200" valign="top">
// 				<table style="text-align:center;width:100%">
// 				<tbody>
// 				<tr>
// 				<td>
// 				<p style="text-align:center;">
// 				<img class="social_icon" src="'.$file_path.'assets/images/email.png" alt="" />
// 				<a href="#">'.$row['event_email'].'</a>
// 				</p>
// 				</td>
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>
// 				<td class="column user_details2" width="200" valign="top">
// 				<table style="text-align:center;width:100%">
// 				<tbody>
// 				<tr>
// 				<td>
// 				<p style="text-align:center;">
// 				<img class="social_icon" src="'.$file_path.'assets/images/web.png" alt="" />
// 				<a href="#">'.$row['event_website'].'</a>
// 				</p>
// 				</td>
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>                
// 				</tr>
// 				</table>			
// 				<table class="section" cellpadding="0" cellspacing="0" width="600" style="margin:20px auto">
// 				<tr>
// 				<td class="column">
// 				<table>
// 				<tbody>
// 				<tr>
// 				<h3>Thanks! - '.APP_NAME.'</h3>                        
// 				</tr>
// 				</tbody>
// 				</table>
// 				</td>
// 				</tr>
// 				</table> 	
// 				</td>		  
// 				</tr>
// 				</tbody>
// 				</table>
// 				</body>
// 				</html>';

// 				// Email send
// 				send_email($email,$name,'Your Event Ticket',$email_user);

// 				$data = array( 
// 					'event_id'  =>  $event_id,
// 					'user_id'  =>  $user_id,
// 					'ticket_no' => $ticket_no,
// 					'user_name'  =>  $name,
// 					'user_email'  =>  $email,
// 					'user_phone'  =>  $phone,
// 					'total_ticket'  =>  $total_tickets,
// 					'user_message'  =>  $user_message,
// 					'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
// 				);    

// 				$qry = Insert('tbl_event_booking',$data);

// 				$remain_tickets=$row['event_ticket']-get_total_booking($event_id);	
// 				$ticket;	

// 				if($remain_tickets <= $row['person_wise_ticket']){
// 					$ticket=$remain_tickets;
// 				}else{
// 					$ticket=$row['person_wise_ticket'];
// 				}
// 				$set['status'] = '1';
// 				$set['message'] = ''; 
// 				$set['msg']=$app_lang['msg_sent'];
// 				$set['success']='1';
// 				$set['person_wise_ticket']=$ticket;
// 			}
// 			else
// 			{
// 				$set['status'] = '1';
// 				$set['message'] = ''; 				 
// 				$set['msg']=$app_lang['msg_sent_fail'];
// 				$set['success']='1';
// 			}	
// 		}
// 		else{
// 			$set['status'] = '1';
// 			$set['message'] = ''; 
// 			$set['msg']=$app_lang['no_ticket_msg'];
// 			$set['success']='1';

// 			$ticket;	

// 			if($remain_tickets <= $row['person_wise_ticket']){
// 				$ticket=$remain_tickets;
// 			}else{
// 				$ticket=$row['person_wise_ticket'];
// 			}
			
// 			$set['remain_tickets']=$remain_tickets;
// 			$set['person_wise_ticket']=$ticket;
// 		}
		
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	// Get event booking end

	// User register start
	else if($get_method['method_name']=="user_register")
	{
		$user_type=trim($get_method['type']); //Google, Normal, Facebook

		$device_id=trim($get_method['device_id']); //Google, Normal, Facebook

		$email=cleanInput($get_method['email']);
		$auth_id=cleanInput($get_method['auth_id']);

		$created_at=strtotime(date('d-m-Y h:i A'));

		$to = $get_method['email'];
		$recipient_name=$get_method['name'];
		  // subject
		$subject = '[IMPORTANT] '.APP_NAME.'Registration completed';

		// User google register
		if($user_type=='Google' || $user_type=='google'){

			$qry = "SELECT * FROM tbl_users WHERE (`email` = '$email' OR `auth_id`='$auth_id') AND `user_type`='Google'";
			$result = mysqli_query($mysqli,$qry) or die(mysqli_error($mysqli));
			$num_rows = mysqli_num_rows($result);
			$row = mysqli_fetch_assoc($result);
			
			if($num_rows == 0){

				$is_duplicate='';

				$sql_device="SELECT * FROM tbl_users WHERE `device_id` = '".$device_id."'";
				$res_device=mysqli_query($mysqli,$sql_device);
				if(mysqli_num_rows($res_device) > 0){
					$is_duplicate='1';
				}else{
					$is_duplicate='0';
				}

				$data = array(
					'user_type' => 'Google',
					'name'  => cleanInput($get_method['name']),				    
					'email'  =>  cleanInput($get_method['email']),
					'password'  =>  trim($get_method['password']),
					'phone'  =>  cleanInput($get_method['phone']),
					'auth_id' => $auth_id,
					'is_duplicate' => $is_duplicate,
					'device_id' => $device_id,
					'created_at' => $created_at,
					'status'  =>  '1'
				);		

				$qry = Insert('tbl_users',$data);	

				$user_id=mysqli_insert_id($mysqli);

				$sql="SELECT * FROM tbl_active_log WHERE `user_id`='$user_id'";
				$res=mysqli_query($mysqli, $sql);

				if(mysqli_num_rows($res) == 0){
                            // insert active log

					$data_log = array(
						'user_id'  =>  $user_id,
						'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
					);

					$qry = Insert('tbl_active_log',$data_log);

				}
				else{
                    // update active log
					$data_log = array(
						'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
					);

					$update=Update('tbl_active_log', $data_log, "WHERE tbl_active_log.`user_id` = '$user_id'");  
				}

				$message='<div style="background-color: #eee;" align="center"><br />
				<table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
				<tbody>
				<tr>
				<td colspan="2" bgcolor="#FFFFFF" align="center" ><img src="'.$file_path.'images/'.APP_LOGO.'" alt="logo" /></td>
				</tr>
				<br>
				<br>
				<tr>
				<td colspan="2" bgcolor="#FFFFFF" align="center" style="padding-top:25px;">
				<img src="'.$file_path.'assets/images/thankyoudribble.gif" alt="header" auto-height="100" width="50%"/>
				</td>
				</tr>
				<tr>
				<td width="600" valign="top" bgcolor="#FFFFFF">
				<table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
				<tbody>
				<tr>
				<td valign="top">
				<table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
				<tbody>
				<tr>
				<td>
				<p style="color: #717171; font-size: 28px; margin-top:0px; margin:0 auto; text-align:center;"><strong>Welcome, '.cleanInput($get_method['name']).'</strong></p>
				<br>
				<p style="color:#15791c; font-size:20px; line-height:32px;font-weight:500;margin-bottom:30px; margin:0 auto; text-align:center;">You have sucsessfully registration with google<br /></p>
				<br/>
				<p style="color:#999; font-size:18px; line-height:32px;font-weight:500;">Thank you for using '.APP_NAME.'</p>
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				<tr>
				<td style="color: #262626; padding: 20px 0; font-size: 20px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">Copyright © '.APP_NAME.'.</td>
				</tr>
				</tbody>
				</table>
				</div>';

				send_email($to,$recipient_name,$subject,$message);

				$set=array('status' => '1','message' => '','user_id' => $user_id,'name'=>$get_method['name'],'email'=>$get_method['email'],'auth_id' => $auth_id,'msg' => $app_lang['register_success'],'success'=>'1');

			}else{	

				if($row['status']==0)
				{
					$set=array('status' => '1','message' => '','msg' =>$app_lang['account_blocked'],'success'=>'0');
				}	

				else
				{  
					$set=array('status' => '1','message' => '','user_id' => $row['id'],'name'=>$row['name'],'email'=>$row['email'],'auth_id' => $auth_id,'msg' => $app_lang['login_success'],'success'=>'1');
				}
			}

		}
		// User normal register
		else if($user_type=='Normal' || $user_type=='normal')
		{			
			// User normal
			$qry = "SELECT * FROM tbl_users WHERE tbl_users.`email` = '".$get_method['email']."' AND tbl_users.`user_type`='Normal'";
			$result = mysqli_query($mysqli,$qry);
			$num_rows = mysqli_num_rows($result);
			$row = mysqli_fetch_assoc($result);
			
			if($num_rows == 0){

				$is_duplicate='';

				$sql_device="SELECT * FROM tbl_users WHERE tbl_users.`device_id` = '".$device_id."'";
				$res_device=mysqli_query($mysqli,$sql_device);
				if(mysqli_num_rows($res_device) > 0){
					$is_duplicate='1';
				}else{
					$is_duplicate='0';
				}

				$data = array(
					'user_type' => 'Normal',
					'name'  => cleanInput($get_method['name']),				    
					'email'  =>  cleanInput($get_method['email']),
					'password'  =>  md5(trim($get_method['password'])),
					'phone'  =>  cleanInput($get_method['phone']),
					'device_id'  =>  $device_id,
					'is_duplicate' => $is_duplicate,
					'auth_id' => $auth_id,
					'created_at' => $created_at,
					'status'  =>  '1'
				);	

				$qry = Insert('tbl_users',$data);	

				$user_id=mysqli_insert_id($mysqli);


				$message='<div style="background-color: #eee;" align="center"><br />
				<table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
				<tbody>
				<tr>
				<td colspan="2" bgcolor="#FFFFFF" align="center" ><img src="'.$file_path.'images/'.APP_LOGO.'" alt="logo" /></td>
				</tr>
				<br>
				<br>
				<tr>
				<td colspan="2" bgcolor="#FFFFFF" align="center" style="padding-top:25px;">
				<img src="'.$file_path.'assets/images/thankyoudribble.gif" alt="header" auto-height="100" width="50%"/>
				</td>
				</tr>
				<tr>
				<td width="600" valign="top" bgcolor="#FFFFFF">
				<table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
				<tbody>
				<tr>
				<td valign="top">
				<table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
				<tbody>
				<tr>
				<td>
				<p style="color: #717171; font-size: 28px; margin-top:0px; margin:0 auto; text-align:center;"><strong>Welcome, '.cleanInput($get_method['name']).'</strong></p>
				<br>
				<p style="color:#15791c; font-size:20px; line-height:32px;font-weight:500;margin-bottom:30px; margin:0 auto; text-align:center;">You have sucsessfully registration with normal<br /></p>
				<br/>
				<p style="color:#999; font-size:18px; line-height:32px;font-weight:500;">Thank you for using '.APP_NAME.'</p>
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				<tr>
				<td style="color: #262626; padding: 20px 0; font-size: 20px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">Copyright © '.APP_NAME.'.</td>
				</tr>
				</tbody>
				</table>
				</div>';

				send_email($to,$recipient_name,$subject,$message);

				$set=array('status' => '1','message' => '','user_id' => $user_id,'name'=>$get_method['name'],'email'=>$get_method['email'],'phone'=>$get_method['phone'],'auth_id' => $auth_id,'msg' => $app_lang['register_success'],'success'=>'1');
			}else{

				if($row['status']==0)
				{
					$set=array('status' => '1','message' => '','msg' =>$app_lang['account_blocked'],'success'=>'0');
				}	
				else
				{  

					$set=array('status' => '1','message' => '','user_id' => $row['id'],'name'=>$row['name'],'email'=>$row['email'],'phone'=>$get_method['phone'],'auth_id' => $auth_id,'msg' => $app_lang['register_success'],'success'=>'1');
				}
			}

		}
		// User facebook register
		else if($user_type=='Facebook' || $user_type=='facebook')
		{			

			$qry = "SELECT * FROM tbl_users WHERE  (`email` = 'email' OR `auth_id`='$auth_id') AND `user_type`='Facebook'";
			$result = mysqli_query($mysqli,$qry);
			$num_rows = mysqli_num_rows($result);
			$row = mysqli_fetch_assoc($result);

			if($num_rows == 0){

				$is_duplicate='';

				$sql_device="SELECT * FROM tbl_users WHERE `device_id` = '".$device_id."'";
				$res_device=mysqli_query($mysqli,$sql_device);
				if(mysqli_num_rows($res_device) > 0){
					$is_duplicate='1';
				}else{
					$is_duplicate='0';
				}

				$data = array(

					'user_type' => 'Facebook',
					'name'  => cleanInput($get_method['name']),				    
					'email'  =>  cleanInput($get_method['email']),
					'password'  =>  trim($get_method['password']),
					'phone'  =>  cleanInput($get_method['phone']),
					'device_id'  =>  $device_id,
					'is_duplicate' => $is_duplicate,
					'auth_id' => $auth_id,
					'created_at' => $created_at,
					'status'  =>  '1'
				);		

				$qry = Insert('tbl_users',$data);	

				$user_id=mysqli_insert_id($mysqli);

				$sql="SELECT * FROM tbl_active_log WHERE `user_id`='$user_id'";
				$res=mysqli_query($mysqli, $sql);

				if(mysqli_num_rows($res) == 0){
                            // insert active log

					$data_log = array(
						'user_id'  =>  $user_id,
						'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
					);

					$qry = Insert('tbl_active_log',$data_log);

				}
				else{
                            // update active log
					$data_log = array(
						'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
					);

					$update=Update('tbl_active_log', $data_log, "WHERE user_id = '$user_id'");  
				}


				$message='<div style="background-color: #eee;" align="center"><br />
				<table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
				<tbody>
				<tr>
				<td colspan="2" bgcolor="#FFFFFF" align="center" ><img src="'.$file_path.'images/'.APP_LOGO.'" alt="logo" /></td>
				</tr>
				<br>
				<br>
				<tr>
				<td colspan="2" bgcolor="#FFFFFF" align="center" style="padding-top:25px;">
				<img src="'.$file_path.'assets/images/thankyoudribble.gif" alt="header" auto-height="100" width="50%"/>
				</td>
				</tr>
				<tr>
				<td width="600" valign="top" bgcolor="#FFFFFF">
				<table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
				<tbody>
				<tr>
				<td valign="top">
				<table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
				<tbody>
				<tr>
				<td>
				<p style="color: #717171; font-size: 28px; margin-top:0px; margin:0 auto; text-align:center;"><strong>Welcome, '.cleanInput($get_method['name']).'</strong></p>
				<br>
				<p style="color:#15791c; font-size:20px; line-height:32px;font-weight:500;margin-bottom:30px; margin:0 auto; text-align:center;">You have sucsessfully registration with facebook<br /></p>
				<br/>
				<p style="color:#999; font-size:18px; line-height:32px;font-weight:500;">Thank you for using '.APP_NAME.'</p>
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				<tr>
				<td style="color: #262626; padding: 20px 0; font-size: 20px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">Copyright © '.APP_NAME.'.</td>
				</tr>
				</tbody>
				</table>
				</div>';

				send_email($to,$recipient_name,$subject,$message);

				$set=array('status' => '1','message' => '','user_id' => $user_id,'name'=>$get_method['name'],'email'=>$get_method['email'],'auth_id' => $auth_id,'msg' => $app_lang['register_success'],'success'=>'1');
			}
			else{

				if($row['status']==0)
				{
					$set=array('status' => '1','message' => '','msg' =>$app_lang['account_blocked'],'success'=>'0');
				}

				else
				{  
					$set=array('status' => '1','message' => '','user_id' => $row['id'],'name'=>$row['name'],'email'=>$row['email'],'auth_id' => $auth_id,'msg' => $app_lang['login_success'],'success'=>'1');
				}
			}
		}

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
		die();
	}
	// User register end

	// User login start
	else if($get_method['method_name']=="user_login")
	{

		$email = cleanInput($get_method['email']);
		$password = trim($get_method['password']);

		$sql_user="SELECT * FROM tbl_users WHERE tbl_users.`email`='$email'";
		$res_user=mysqli_query($mysqli, $sql_user) or die('Error in fetch data ->'.mysqli_error($mysqli));

		if(mysqli_num_rows($res_user) > 0){
			$row=mysqli_fetch_assoc($res_user);

			if($row['status']==1){

				if($row['password']==md5($password)){

					$user_id=$row['id'];

					$sql="SELECT * FROM tbl_active_log WHERE tbl_active_log.`user_id`='$user_id'";
					$res=mysqli_query($mysqli, $sql);

					if(mysqli_num_rows($res) == 0){
                        // insert active log

						$data_log = array(
							'user_id'  =>  $user_id,
							'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
						);

						$qry = Insert('tbl_active_log',$data_log);

					}
					else{
                        // update active log
						$data_log = array(
							'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
						);

						$update=Update('tbl_active_log', $data_log, "WHERE tbl_active_log.`user_id` = '$user_id'");  
					}

					mysqli_free_result($res);

					$set=array('status' => '1','message' => '','user_id' => $row['id'],'name'=>$row['name'],'success'=>'1');


				}
				else{
					// invalid password
					$set=array('status' => '1','message' => '','msg' =>$app_lang['invalid_password'],'success'=>'0');
				}
			}
			else{
				// account is deactivated
				$set=array('status' => '1','message' => '','msg' =>$app_lang['account_deactive'],'success'=>'0');
			}

		}
		else{
			// email not found
			$set=array('status' => '1','message' => '','msg' =>$app_lang['email_not_found'],'success'=>'0');
		}

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	// User login end

	// User profile start
	else if($get_method['method_name']=="user_profile")
	{
		
		$qry = "SELECT * FROM tbl_users WHERE  tbl_users.`status`=1 AND tbl_users.`id` = '".$get_method['id']."'"; 
		$result = mysqli_query($mysqli,$qry);
		$row = mysqli_fetch_assoc($result);
		if(mysqli_num_rows($result) > 0){

			if($row['user_image']!='')
			{
				$user_image=$file_path.'images/'.$row['user_image'];
			}	
			else
			{
				$user_image='';
			}

			$set=array('status' => '1','message' => '','user_id' => $row['id'],'name'=>$row['name'],'email'=>$row['email'],'phone'=>$row['phone'],'city'=>$row['city'],'address'=>$row['address'],'user_image'=>$user_image,'msg' => '','success'=>'1');
		}
		else{
			$set=array('status' => '2','message' => '','msg'=>$app_lang['account_disable'],'success'=>'0');
		}

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	// User profile end

	// User profile update start
	else if($get_method['method_name']=="user_profile_update")
	{

		$user_id=$get_method['user_id'];
		$is_remove=$get_method['is_remove'];

		$qry = "SELECT * FROM tbl_users WHERE tbl_users.`id`='$user_id'"; 
		$result = mysqli_query($mysqli,$qry);
		$row = mysqli_fetch_assoc($result);

		if(isset($is_remove) && $is_remove){
			if($row['user_image']!=""){
				if (file_exists('images/' .$row['user_image'])){
					unlink('images/'.$row['user_image']);
				} 

				$sql="UPDATE tbl_users SET `user_image`='' WHERE `id`='".$row['id']."'";
				mysqli_query($mysqli,$sql);
			}
			$user_image ='';
		}

		if(isset($_FILES['user_image']))
		{
			if($row['user_image']!="")
			{
				unlink('images/'.$row['user_image']);
			}

			$ext = pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION);

		$path = "images/"; //set your folder path
		$user_image=date('dmYhis').'_'.rand(0,99999).".png";
        //Main Image
		$tpath1=$path.$user_image;        
		$pic1=compress_image($_FILES["user_image"]["tmp_name"], $tpath1, 60);

		$data = array(
			'name'  => cleanInput($get_method['name']),			 
			'phone'  =>  cleanInput($get_method['phone']),
			'city'  =>  $get_method['city'],
			'address'  =>  $get_method['address'],
			'user_image'  =>  $user_image 
		);

	}else{

		$data = array(
			'name'  => cleanInput($get_method['name']),			 
			'phone'  =>  cleanInput($get_method['phone']),
			'city'  =>  $get_method['city'],
			'address'  =>  $get_method['address']
		);
	}

	$user_edit=Update('tbl_users', $data, "WHERE `id`= '$user_id'");

	$set=array('status' => '1','message' => '','msg'=>$app_lang['update_success'],'success'=>'1');	

	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
	die();
}
// User profile update end

// User status start
else if($get_method['method_name']=="user_status")
{

	$user_id = $get_method['user_id'];

	$qry = "SELECT * FROM tbl_users WHERE  tbl_users.`id` = '".$user_id."'"; 
	$result = mysqli_query($mysqli,$qry);
	$num_rows = mysqli_num_rows($result);
	$row = mysqli_fetch_assoc($result);

	if($num_rows > 0){ 	 
		if($row['status']==1){
			$set=array('status' => '1','message' => '','msg' => '','success'=>'1');	 
		}else{
			$set=array('status' => '1','message' => '','msg' => '','success'=>'0');
		}
	}else{
		$set=array('status' => '1','message' => '','msg' => '','success'=>'0');
	}

	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
	die();

}
// User status end

// Change password start 
else if($get_method['method_name']=="change_password"){

	$user_id=$get_method['user_id'];
	$old_password=$get_method['old_password'];
	$new_password=$get_method['new_password'];

	$qry = "SELECT * FROM tbl_users WHERE `id`='$user_id' AND `status` = 1"; 
	$result = mysqli_query($mysqli,$qry);
	$num_rows = mysqli_num_rows($result);
	$row = mysqli_fetch_assoc($result);

	if ($row['password'] == md5($old_password)) {

		$data = array(
			'password' => md5($new_password)
		);

		$edit=Update('tbl_users', $data, "WHERE `id` = '$user_id'");

		$set=array('status' => '1','message' => '','msg' => $app_lang['change_password_msg'],'success' => '1');	 
	}
	else{
		$set=array('status' => '1','message' => '','msg' =>$app_lang['wrong_password_error'],'success' => '0');
	}

	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();

}
// Change password end 

// User forgot password start
else if($get_method['method_name']=="user_forgot_pass")	
{

	$email=trim($get_method['email']);

	$qry = "SELECT * FROM tbl_users WHERE tbl_users.`email` = '$email' AND tbl_users.`user_type`='Normal'"; 
	$result = mysqli_query($mysqli,$qry);
	$row = mysqli_fetch_assoc($result);

	if($result->num_rows > 0)
	{
		$password=generateRandomPassword(7);

		$new_password=md5($password);

		$to = $row['email'];
		$recipient_name=$row['name'];
			// subject
		$subject = '[IMPORTANT] '.APP_NAME.' Forgot Password Information';

		$message='<div style="background-color: #f9f9f9;" align="center"><br />
				  <table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
				    <tbody>
				      <tr>
				        <td colspan="2" bgcolor="#FFFFFF" align="center"><img src="'.$file_path.'images/'.APP_LOGO.'" alt="header" style="width:100px;height:auto"/></td>
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
				                        	<p style="color: #262626; font-size: 24px; margin-top:0px;"><strong>'.$app_lang['dear_lbl'].' '.$row['name'].'</strong></p>
				                          <p style="color:#262626; font-size:20px; line-height:32px;font-weight:500;margin-top:5px;"><br>'.$app_lang['your_password_lbl'].': <span style="font-weight:400;">'.$password.'</span></p>
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

		//Email send
		send_email($to,$recipient_name,$subject,$message);

		$sql="UPDATE tbl_users SET `password`='$new_password' WHERE `id`='".$row['id']."'";
		mysqli_query($mysqli,$sql);

		$set=array('status' => '1','message' => '','msg' => $app_lang['password_sent_mail'],'success'=>'1');
	}
	else
	{  	 	
		$set=array('status' => '1','message' => '','msg' => $app_lang['email_not_found'],'success'=>'0');		
	}
	
	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();	
}	
// User forgot password end

// Get tickets start
else if($get_method['method_name']=="get_tickets")
{

	$jsonObj= array();

	$user_id=$get_method['user_id'];	
	$event_id=$get_method['event_id'];	

	$sql="SELECT * FROM tbl_events WHERE tbl_events.`id`='$event_id'";
	$res=mysqli_query($mysqli, $sql);
	$row=mysqli_fetch_assoc($res);

	$remain_tickets=$row['event_ticket']-get_total_booking($event_id);	
	$ticket;	

	if($remain_tickets <= $row['person_wise_ticket']){
		$ticket=$remain_tickets;
	}else{
		$ticket=$row['person_wise_ticket'];
	}
	$set['status'] = '1';
	$set['message'] = '';
	$set['total_tickets']=$row['event_ticket'];
	$set['remain_tickets']=$remain_tickets;
	$set['name']=get_user_info($user_id,'name');
	$set['email']=get_user_info($user_id,'email');
	$set['phone']=get_user_info($user_id,'phone');
	$set['address']=get_user_info($user_id,'address');
	$set['person_wise_ticket']=$ticket;

	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();	
}
// Get tickets end

// Get booked events start
else if($get_method['method_name']=="booked_events")
{
	$user_id=$get_method['user_id'];  

	$jsonObj= array();  

	$page_limit=API_PAGE_LIMIT;

	$limit=($get_method['page']-1) * $page_limit;

	$sql="SELECT tbl_event_booking.`id` AS booking_id, tbl_events.*, tbl_category.* FROM tbl_event_booking
	LEFT JOIN tbl_events ON tbl_event_booking.`event_id`=tbl_events.`id`
	LEFT JOIN tbl_category ON tbl_events.`cat_id`=tbl_category.`cid`
	WHERE tbl_event_booking.`user_id`='$user_id' ORDER BY tbl_event_booking.`id` DESC LIMIT $limit, $page_limit";


	$res = mysqli_query($mysqli, $sql)or die(mysqli_error($mysqli));

	while($data = mysqli_fetch_assoc($res))
	{
		$row['id'] = $data['id'];
		$row['booking_id'] = $data['booking_id'];
		$row['cat_id'] = $data['cat_id'];
		$row['event_title'] = stripslashes($data['event_title']);

		$row['event_address'] = $data['event_address'];

		$row['event_date'] = date('d,M',$data['event_start_date']);

		$row['event_banner_thumb'] = get_thumb('images/'.$data['event_banner'],'500x250');	
		$row['is_fav']=get_favourite_info($data['id'],$user_id);
		$row['total_views'] = $data['total_views'];

		array_push($jsonObj,$row);

	}

	$set['status'] = '1';
	$set['message'] = '';
	$set['EVENT_APP'] = $jsonObj;

	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();
}
// Get booked events end

// Get remove cover start
else if($get_method['method_name']=="remove_cover")
{
	$image_id=$get_method['image_id'];

	$sql="SELECT * FROM tbl_event_cover WHERE tbl_event_cover.`id`='$image_id'";
	$res=mysqli_query($mysqli, $sql);
	$row=mysqli_fetch_assoc($res);

	if($row['image_file']!="")
	{
		unlink('images/'.$row['image_file']);
		unlink('images/thumbs/'.$row['image_file']);
	}

	Delete('tbl_event_cover','id='.$image_id); 

	$set['msg']=$app_lang['delete_success'];
	$set['success']=1;
	$set['status'] = '1';
	$set['message'] = '';

	header('Content-Type: application/json; charset=utf-8' );
	$json = json_encode($set);
	echo $json;
	exit;
}
// Get remove cover end

// Get contact start
else if($get_method['method_name']=="get_contact")		
{

	$jsonObj= array();	

	$user_id=cleanInput($get_method['user_id']);

	$query="SELECT * FROM tbl_contact_sub WHERE tbl_contact_sub.`status`=1 ORDER BY tbl_contact_sub.`id` DESC";
	$sql = mysqli_query($mysqli,$query);

	if(mysqli_num_rows($sql) > 0){
		while ($data = mysqli_fetch_assoc($sql)){
			$info['id']=$data['id'];
			$info['subject']=$data['title'];

			array_push($jsonObj, $info);
		}
	}

	$set['name']=get_user_info($user_id,'name');
	$set['email']=get_user_info($user_id,'email');
	$set['phone']=get_user_info($user_id,'phone');
	$set['address']=get_user_info($user_id,'address');
	$set['status'] = '1';
	$set['message'] = '';
	$set['EVENT_APP'] = $jsonObj;

	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();	
}
// Get contact end

// Get user contact us start
else if($get_method['method_name']=="user_contact_us")	
{	

	$contact_name = cleanInput($get_method['contact_name']);
	$contact_email = cleanInput($get_method['contact_email']);
	$contact_subject = cleanInput($get_method['contact_subject']);
	$contact_msg = cleanInput($get_method['contact_msg']);

	$data = array(
		'contact_name'  => $contact_name,
		'contact_email'  => $contact_email,
		'contact_subject'  =>  $contact_subject,
		'contact_msg'  =>  $contact_msg,
		'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
	);	

	$qry = Insert('tbl_contact_list',$data);

	$to = $settings_details['app_email'];
	$recipient_name=APP_NAME;
		// subject
	$subject = '[IMPORTANT] '.APP_NAME.' Contact';

	$message='<div style="background-color:#f9f9f9;" align="center"><br>
	<table style="font-family:Poppins,sans-serif;color:#666666;border-radius:10px;overflow:hidden;" border="0" width="90%" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
	<tbody>
	<tr>
	<td colspan="2" bgcolor="#FFFFFF" align="center" style="border-bottom:1px solid rgba(0, 0, 0, 0.05)"><img src="'.$file_path.'images/'.APP_LOGO.'" alt="header" width="100" style="margin-top:15px;padding-bottom:15px;" /></td>
	</tr>
	<tr>
	<td width="50%" valign="top" bgcolor="#FFFFFF">
	<table style="font-family:Poppins,sans-serif;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
	<tbody>
	<tr>
	<td valign="top" style="width: 100%;display: inline-block;padding:25px 25px 15px 25px;">
	<table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:Poppins,sans-serif; color: #666666; font-size: 10px; width:100%;">
	<tbody>
	<tr>
	<span style="color:#262626;font-size:20px;line-height:28px;font-weight:600;display:inline-block;margin-bottom:10px;">Hello '.$contact_name.',</span><br>
	<span style="color:#262626;font-size:16px;line-height:26px;font-weight:600;display:inline-block">Name: <p style="color:#727272;font-size:16px;line-height:26px;font-weight:400;margin:5px 0 8px 0;display:inline-block;">'.$contact_name.'</p></span><br>
	<span style="color:#262626;font-size:16px;line-height:26px;font-weight:600;display:inline-block">Email: <p style="color:#727272;font-size:16px;line-height:26px;font-weight:400;margin:5px 0 8px 0;display:inline-block;">'.$contact_email.'</p></span><br>
	<span style="color:#262626;font-size:16px;line-height:26px;font-weight:600;display:inline-block">Subject: <p style="color:#727272;font-size:16px;line-height:26px;font-weight:400;margin:5px 0 8px 0;display:inline-block;">'.get_subject_info($contact_subject,'title').'</p></span><br>
	<span style="color:#262626;font-size:16px;line-height:26px;font-weight:600;display:inline-block">Message: <p style="color:#727272;font-size:16px;line-height:26px;font-weight:400;margin:5px 0 8px 0;display:inline-block;">'.$contact_msg.'</p></span><br>
	<span style="color:#262626;font-size:16px;line-height:26px;font-weight:600;display:inline-block;margin-top:25px">Thank You, <p style="color:#262626;font-size:16px;line-height:26px;font-weight:500;margin:5px 0 8px 0;display:block;">'.APP_NAME.'</p></span>						  
	</tr>
	</tbody>
	</table>
	</td>
	<td valign="top" style="width:100%;display:inline-block;border-top:1px solid rgba(0, 0, 0, 0.05);text-align:center;padding:10px 0;">
	<table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:Poppins,sans-serif; color: #666666; font-size: 10px; width:100%;">
	<tbody>
	<span><a href="https://www.facebook.com/viaviweb"><img src="'.$file_path.'images/ic-facebook.png" alt="ic-facebook" style="width:40px;height:40px;margin:0 5px;" /></a></span>
	<span><a href="https://www.youtube.com/viaviwebtech"><img src="'.$file_path.'images/ic-youtube.png" alt="ic-youtube" style="width:40px;height:40px;margin:0 5px;" /></a></span>
	<span><a href="https://www.instagram.com/viaviwebtech"><img src="'.$file_path.'images/ic-instagram.png" alt="ic-instagram" style="width:40px;height:40px;margin:0 5px;" /></a></span>
	</tbody>
	</table>
	</td>
	</tr>			   
	</tbody>
	</table>
	</td>
	</tr>
	<tr>
	<td style="background:#ffffff;color:#424242;padding:20px 0;font-size:14px;border-top:2px solid #fd780a;" colspan="2" align="center" bgcolor="#ffffff">Copyright © '.APP_NAME.'.</td>
	</tr>
	</tbody>
	</table>
	<br>
	</div>';

	//Email send
	send_email($to,$recipient_name,$subject,$message);

	$set=array('status' => '1','message' => '','msg' => $app_lang['contact_sent'],'success'=>'1');

	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();
}
// Get user contact us end

// Get event report start
else if($get_method['method_name']=="event_report")	
{		
	$report_type=$get_method['report_type'];
	$report=addslashes(trim(strip_tags($get_method['report_text'])));   

	if($report)
	{

		$qry1="INSERT INTO tbl_reports (`user_id`,`event_id`,`type`,`report`) VALUES ('".$get_method['report_user_id']."','".$get_method['report_event_id']."','".$report_type."','".$report."')"; 

		$result1=mysqli_query($mysqli,$qry1);  	


		$set = array('status' => '1','message' => '','msg' => $app_lang['report_success'],'success'=>'1');
	}
	else
	{
		$set = array('status' => '1','message' => '','msg' => 'Please add report text','success'=>'0');
	}

	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();
}
// Get event report end

// Get download ticket start 
else if($get_method['method_name']=="download_ticket")
{

	$booking_id=$get_method['booking_id'];

	$file_name=date('d_m_y').'_'.$booking_id;

		//$file_url=$file_path.'user_ticket.php?id='.$booking_id.'&file_name='.$file_name;

	$url = $file_path.'user_ticket.php?id='.$booking_id;
	$data = file_get_contents($url);

	$set['msg']='Success';
	$set['string_data']=$data;
	$set['file_name']=$file_name;
	$set['success']='1';
	$set['status'] = '1';
	$set['message'] = ''; 

	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();
}
// Get download ticket end

// Get view ticket start 
else if($get_method['method_name']=="view_ticket")
{
	$booking_id=$get_method['booking_id']; 
	$is_dark=$get_method['is_dark']; 

	$set['status'] = '1';
	$set['message'] = ''; 
	$set['msg']='Success';
	$set['success']='1';

	if($is_dark == 'true'){
		$set['url']=$file_path.'dark_ticket.php?id='.$booking_id;
	}else{
		$set['url']=$file_path.'ticket.php?id='.$booking_id;
	}

	header( 'Content-Type: application/json; charset=utf-8' );
	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	die();
}
// Get view ticket end 

// Get event users start  
else if($get_method['method_name']=="event_user_list")
{

	$event_id=$get_method['event_id'];

	function clean($string) {
		   $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
		   $string = preg_replace('/[^A-Za-z0-9\-]/', '_', $string); // Removes special chars.

		   return ucfirst(preg_replace('/-+/', '_', $string)); // Replaces multiple hyphens with single one.
		}

		$sql="SELECT * FROM tbl_events WHERE tbl_events.`id`=$event_id";
		$res=mysqli_query($mysqli, $sql);
		$row=mysqli_fetch_assoc($res);

		$file_name=clean($row['event_title']).'_'.date('d_m_y').'.xls';  

		$set['status'] = '1';
		$set['message'] = ''; 
		$set['msg']='Success';
		$set['success']='1';
		$set['url']=$file_path.'download_register.php?event_id='.$event_id.'&file_name='.$file_name;
		$set['file_name']=$file_name;

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	// Get event users end

	// Get app faq start 
	else if($get_method['method_name']=="app_faq")		
	{

		$jsonObj= array();	

		$query="SELECT * FROM tbl_settings WHERE tbl_settings.`id`='1'";
		$sql = mysqli_query($mysqli,$query);

		$data = mysqli_fetch_assoc($sql);

		$row['status'] = '1';
		$row['message'] = '';
		$row['success'] = 1;
		$row['app_faq'] = stripslashes($data['app_faq']);

		$set = $row;
		
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();	
	}
	// Get app faq end

	// Get app privacy policy start 
	else if($get_method['method_name']=="app_privacy_policy")		
	{

		$jsonObj= array();	

		$query="SELECT * FROM tbl_settings WHERE tbl_settings.`id`='1'";
		$sql = mysqli_query($mysqli,$query);

		$data = mysqli_fetch_assoc($sql);

		$row['status'] = '1';
		$row['message'] = '';
		$row['app_privacy_policy'] = stripslashes($data['app_privacy_policy']);

		$set= $row;
		
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();	
	}
	// Get app privacy policy end

	// Get app about start
	else if($get_method['method_name']=="app_about")
	{
		$jsonObj= array();	

		$query="SELECT * FROM tbl_settings WHERE tbl_settings.`id`='1'";
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

		$data = mysqli_fetch_assoc($sql);

		$row['status'] = '1';
		$row['message'] = '';
		$row['app_name'] = $data['app_name'];
		$row['app_logo'] = $file_path.'images/'.$data['app_logo'];
		$row['package_name']=$data['package_name'];
		$row['app_version'] = $data['app_version'];
		$row['app_author'] = $data['app_author'];
		$row['app_contact'] = $data['app_contact'];
		$row['app_email'] = $data['app_email'];
		$row['app_website'] = $data['app_website'];
		$row['app_description'] = stripslashes($data['app_description']);
		$row['app_developed_by'] = $data['app_developed_by'];
		
		$set = $row;
		
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();	
	}
	// Get app about end

	// Get app terms conditions start
	else if($get_method['method_name']=="app_terms_conditions"){

		$jsonObj= array();	

		$query="SELECT * FROM tbl_settings WHERE `id` ='1'";
		$sql = mysqli_query($mysqli,$query);

		$data = mysqli_fetch_assoc($sql);

		$row['status'] = 1;
		$row['message'] = '';
		$row['app_terms_conditions'] = stripslashes($data['app_terms_conditions']);

		$set= $row;

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();	
	}
	// Get app terms conditions end

	// Get app details start	
	else if($get_method['method_name']=="get_app_details")
	{
		$jsonObj= array();	

		$query="SELECT * FROM tbl_settings WHERE id='1'";
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));
		$data = mysqli_fetch_assoc($sql);

		$row['status'] = '1';
		$row['message'] = '';

		$row['publisher_id'] = $data['publisher_id'];
		$row['interstitial_ad'] = $data['interstital_ad'];
		$row['interstitial_ad_type'] = $data['interstital_ad_type'];
		$row['interstitial_ad_id'] = ($data['interstital_ad_type']=='facebook') ? $data['interstital_facebook_id'] : $data['interstital_ad_id'];
		$row['interstitial_ad_click'] = $data['interstital_ad_click'];

		$row['banner_ad'] = $data['banner_ad'];
		$row['banner_ad_type'] = $data['banner_ad_type'];

		$row['banner_ad_id'] = ($data['banner_ad_type']=='facebook') ? $data['banner_facebook_id'] : $data['banner_ad_id'];

		$row['app_update_status'] = $data['app_update_status'];
		$row['app_new_version'] = $data['app_new_version'];
		$row['app_update_desc'] = stripslashes($data['app_update_desc']);
		$row['app_redirect_url'] = $data['app_redirect_url'];
		$row['cancel_update_status'] = $data['cancel_update_status'];

		$set= $row;
		
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();	
	}
	// Get app details end

	
    // Get add event image start
     else if($get_method['method_name']=="add_event_image")
    {
		
		for ($i = 0; $i < count($_FILES['event_image']['name']); $i++) {
        
            $ext = pathinfo($_FILES['event_image']['name'][$i], PATHINFO_EXTENSION);
            
            if ($ext == "heic" || $ext == "heif") {
                $path = "images/"; // Set your folder path
                $image_file = date('dmYhis') . '_' . rand(0, 99999) . '_' . $i . ".png";
        
                // Path to the HEIC image
                $heic_path = $_FILES["event_image"]["tmp_name"][$i];
                
                // Convert HEIC to PNG using imagick
                $imagick = new \Imagick();
                $imagick->readImage($heic_path);
                $imagick->setImageFormat("png");
                $png_data = $imagick->getImageBlob();
                
                // Save the PNG file
                file_put_contents($path . $image_file, $png_data);
                
                // Compress the PNG image
                $compressed_path = $path . 'compressed_' . $image_file;
                $original_image = imagecreatefrompng($path . $image_file);
                imagepng($original_image, $compressed_path, 9); // 9 is the compression level (0-9)
                imagedestroy($original_image);
                
                // Rest of your code...
                
                $data = array(
                    'user_id' => $get_method['user_id'],
                    'event_id' => $get_method['event_id'],
                    'event_image' => $image_file
                );
        
                $qry = Insert('event_image', $data);
            } else {
                
    			$path = "images/"; //set your folder path
    			$image_file=date('dmYhis').'_'.rand(0,99999).'_'.$i.".png";
                // $new_image = imagepng(imagecreatefromstring(file_get_contents($_FILES["event_image"]["tmp_name"][$i])),$image_file);
    
    			$tpath1=$path.$image_file;    
    			$pic1=compress_image($_FILES["event_image"]["tmp_name"][$i], $tpath1, 60);
    // 			$pic1=compress_image($new_image, $tpath1, 60);
    			
    
    			$thumbpath='images/thumbs/'.$image_file;
    
    			$thumb_pic1=create_thumb_image($tpath1,$thumbpath,'450','250');
    
      
    			$data = array( 
    				'user_id'  =>  $get_method['user_id'],
    				'event_id'  =>  $get_method['event_id'],
    				'event_image'  =>  $image_file
    			);    
      
    		  	$qry = Insert('event_image',$data);
            }
        }



	  $set=array('status' => '1','message' => '','msg' => $app_lang['add_success'],'success'=>'1');

	  header('Content-Type: application/json; charset=utf-8' );
	  $json = json_encode($set);
	  echo $json;
	  exit;
	}
	// Get add event image end
    // Get add event feed start
    else if($get_method['method_name']=="add_event_feed")
    {
		$data = array( 
			'user_id'  =>  $get_method['user_id'],
			'event_id'  =>  $get_method['event_id'],
			'event_feed'  =>  $get_method['event_feed'],
			'date'  =>  $get_method['date'],
			'created_at' => date('Y-m-d H:i:s')
		);    
		$qry = Insert('event_feed',$data);
		$last_id=mysqli_insert_id($mysqli);
		$set=array('status' => '1','message' => '','msg' => $app_lang['add_success'],'success'=>'1');
		header('Content-Type: application/json; charset=utf-8' );
		$json = json_encode($set);
		echo $json;
		exit;
	}
	// Get add event feed end
    // Get get event feed start
    else if($get_method['method_name']=="get_event_feed")
    {
    	$event_id= $get_method['event_id'];  

    	$page_limit=API_PAGE_LIMIT;

    	$limit=($get_method['page']-1) * $page_limit;

    	$jsonObj_all= array();  

    	$query="SELECT * FROM event_feed
    	WHERE event_feed.`event_id`='$event_id' ORDER BY event_feed.`id` DESC LIMIT $limit, $page_limit";
    	
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

    	while($data = mysqli_fetch_assoc($sql))
    	{

    		$row['id'] = $data['id'];
    		$row['created_at'] = $data['created_at'];
    		$row['event_feed'] = $data['event_feed'];
    		$row['user_name'] = get_user_info($data['user_id'],'name');
    		$row['event_title'] = stripslashes(get_event_info($data['event_id'],'event_title'));    		
    		array_push($jsonObj_all,$row);
    	}

    	$set['status'] = '1';
    	$set['message'] = '';
    	$set['EVENT_APP'] = $jsonObj_all;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
	}
	// Get get event feed end
    // Get get event media start
    else if($get_method['method_name']=="get_event_media")
    {
    	$event_id= $get_method['event_id'];  

    	$page_limit=API_PAGE_LIMIT;

    	$limit=($get_method['page']-1) * $page_limit;

    	$jsonObj_all= array();  

    	$query="SELECT * FROM event_image
    	WHERE event_image.`event_id`='$event_id' ORDER BY event_image.`id` DESC LIMIT $limit, $page_limit";
    	
    	
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

    	while($data = mysqli_fetch_assoc($sql))
    	{

    		$row['id'] = $data['id'];
    		$row['event_image'] = $file_path.'images/'.$data['event_image'];
    		$row['event_image_thumb'] = get_thumb('images/'.$data['event_image'],'250x250');
    		$row['user_name'] = get_user_info($data['user_id'],'name');
    		$row['event_title'] = stripslashes(get_event_info($data['event_id'],'event_title'));    		
    		array_push($jsonObj_all,$row);
    	}

    	$set['status'] = '1';
    	$set['message'] = '';
    	$set['EVENT_APP'] = $jsonObj_all;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
	}
	// Get get event media end
	
    // Delete event media start
    else if($get_method['method_name']=="delete_event_media")
    {
    	$event_media_id = $get_method['event_media_id'];  

		$deleteSql="DELETE FROM event_image WHERE `id`='$event_media_id'";

		if(mysqli_query($mysqli, $deleteSql)){
			$set = array('status' => '1','message' => '','msg'=>'Event Media Deleted','success'=>1);
		}
		else{

			$set = array('status' => '1','message' => '','msg'=>$app_lang['error_msg'],'success'=>0);
		}

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
	}
	// Delete get event media end

    // Get add event invitation start
     else if($get_method['method_name']=="add_event_invitation")
    {
		

    	$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    
    	$path = "images/"; //set your folder path
    	$image_file=date('dmYhis').'_'.rand(0,99999).'_.'.$ext;
    
    	$tpath1=$path.$image_file;    
    	$pic1=compress_image($_FILES["image"]["tmp_name"], $tpath1, 60);
    	
    
    	$thumbpath='images/thumbs/'.$image_file;
    
        $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'450','250');
    
    
    	$data = array( 
    		'event_id'  =>  $get_method['event_id'],
    		'image'  =>  $image_file
    	);    
    
      $qry = Insert('event_invitation',$data);


	  $set=array('status' => '1','message' => '','msg' => $app_lang['add_success'],'success'=>'1');

	  header('Content-Type: application/json; charset=utf-8' );
	  $json = json_encode($set);
	  echo $json;
	  exit;
	}
	// Get add event invitation end
	
    // Get get event invitation start
    else if($get_method['method_name']=="get_event_invitation")
    {
    	$event_id= $get_method['event_id'];  

    	$page_limit=API_PAGE_LIMIT;

    	$limit=($get_method['page']-1) * $page_limit;

    	$jsonObj_all= array();  

    	$query="SELECT * FROM event_invitation
    	WHERE event_invitation.`event_id`='$event_id' ORDER BY event_invitation.`id` DESC LIMIT $limit, $page_limit";
    	
    	
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

    	while($data = mysqli_fetch_assoc($sql))
    	{

    		$row['id'] = $data['id'];
    		$row['image'] = $file_path.'images/'.$data['image'];
    		$row['image_thumb'] = get_thumb('images/'.$data['image'],'250x250');
    		$row['event_title'] = stripslashes(get_event_info($data['event_id'],'event_title'));    		
    		array_push($jsonObj_all,$row);
    	}

    	$set['status'] = '1';
    	$set['message'] = '';
    	$set['EVENT_APP'] = $jsonObj_all;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
	}
	// Get get event invitation end
    // Get get all event media start
    else if($get_method['method_name']=="get_all_event_media")
    {
    	$page_limit=API_PAGE_LIMIT;

    	$limit=($get_method['page']-1) * $page_limit;
    	
    	$user_id= $get_method['user_id'];  

    	$jsonObj_all= array();  
        if($user_id != 0)
        {
            $query=	"SELECT event_image.* FROM event_image
                JOIN tbl_events ON event_image.event_id = tbl_events.id
                WHERE (tbl_events.`website`='public' OR tbl_events.`website`='private' AND tbl_events.`user_id`= $user_id)
                ORDER BY event_image.`created_at` DESC LIMIT $limit, $page_limit";
        }else{
            $query=	"SELECT event_image.* FROM event_image
                JOIN tbl_events ON event_image.event_id = tbl_events.id
                WHERE tbl_events.`website`='public'
                ORDER BY event_image.`created_at` DESC LIMIT $limit, $page_limit";
        }
    // 	$query="SELECT * FROM event_image ORDER BY event_image.`created_at` DESC LIMIT $limit, $page_limit";
        

    	
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

    	
    	while($data = mysqli_fetch_assoc($sql))
    	{

    		$row['id'] = $data['id'];
    		$row['event_image'] = $file_path.'images/'.$data['event_image'];
    		$row['event_image_thumb'] = get_thumb('images/'.$data['event_image'],'250x250');    		
    		$row['user_name'] = get_user_info($data['user_id'],'name');
    		$row['user_id'] = $data['user_id'];
    		$row['event_id'] = $data['event_id'];
			
			if(get_user_info($data['user_id'],'user_image') !='')
			{
				$row['user_image'] = $file_path.'images/'.get_user_info($data['user_id'],'user_image');
			}	
			else
			{
				$row['user_image'] = '';
			}
			$row['is_fav']=get_favourite_info_for_event_media($data['id']);
    		$row['event_title'] = stripslashes(get_event_info($data['event_id'],'event_title'));    		
    		array_push($jsonObj_all,$row);
    	}

    	$set['status'] = '1';
    	$set['message'] = '';
    	$set['EVENT_APP'] = $jsonObj_all;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
	}
	// Get get all event media end
	// Add event media comment start
    else if($get_method['method_name']=="add_event_media_comment")
    {
		$data = array( 
			'user_id'  =>  $get_method['user_id'],
			'event_id'  =>  $get_method['event_id'],
			'event_media_id'  =>  $get_method['event_media_id'],
			'comment'  =>  $get_method['comment']
		);    
		$qry = Insert('event_media_comment',$data);
		$last_id=mysqli_insert_id($mysqli);
		$set=array('status' => '1','message' => '','msg' => $app_lang['add_success'],'success'=>'1');
		header('Content-Type: application/json; charset=utf-8' );
		$json = json_encode($set);
		echo $json;
		exit;
	}
	// Add event media comment end
	
    // Delete event media comment start
    else if($get_method['method_name']=="delete_event_media_comment")
    {
    	$comment_id = $get_method['comment_id'];  
    	$user_id = $get_method['user_id'];  
        
    	$deleteSql = "DELETE FROM event_media_comment WHERE `id`='$comment_id' AND `user_id`='$user_id'";

		if(mysqli_query($mysqli, $deleteSql)){
		    $deleteReplySql = "DELETE FROM event_media_comment_reply WHERE `comment_id`='$comment_id'";
		    mysqli_query($mysqli, $deleteReplySql);
			$set = array('status' => '1','message' => '','msg'=>'Event Media Comment Deleted','success'=>1);
		}
		else{

			$set = array('status' => '1','message' => '','msg'=>$app_lang['error_msg'],'success'=>0);
		}

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
	}
	// Delete get event media comment end
    // Get event media comment start
    else if($get_method['method_name']=="get_event_media_comment")
    {
    	$event_media_id= $get_method['event_media_id'];  

    	$page_limit=10;

    	$limit=($get_method['page']-1) * $page_limit;

    	$jsonObj_all= array();  

    	$query="SELECT * FROM event_media_comment
    	WHERE event_media_comment.`event_media_id`='$event_media_id' ORDER BY event_media_comment.`id` DESC LIMIT $limit, $page_limit";
    	
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

    	while($data = mysqli_fetch_assoc($sql))
    	{

    		$row['id'] = $data['id'];
    		$row['comment'] = $data['comment'];
    		$row['event_media_id'] = $data['event_media_id'];
    		$row['user_id'] = $data['user_id'];
    		$row['event_title'] = stripslashes(get_event_info($data['event_id'],'event_title'));
    		$row['user_name'] = get_user_info($data['user_id'],'name');
    		if(get_user_info($data['user_id'],'user_image') !='')
			{
				$row['user_image'] = $file_path.'images/'.get_user_info($data['user_id'],'user_image');
			}	
			else
			{
				$row['user_image'] = '';
			}
			$row['is_like'] = get_user_comment_like_status($data['id'],$data['user_id']);
    		$row['created_at'] = $data['created_at'];   
    		$row['total_replies'] = get_total_replies($data['id']);
    		if(get_total_replies($data['id']) > 0)
    		{
    		   $row['last_reply'] = get_last_reply($data['id']);
    		}else{
    		   $row['last_reply'] = '';
    		}
    		$row['likes'] = get_total_comment_likes($data['id']);
    		$row['dislikes'] = get_total_comment_dislikes($data['id']);
    		array_push($jsonObj_all,$row);
    	}

    	$set['status'] = '1';
    	$set['message'] = '';
    	$set['EVENT_APP'] = $jsonObj_all;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
	}
	// Get event media comment end
	// Add event media comment reply start
    else if($get_method['method_name']=="add_media_comment_reply")
    {
		$data = array( 
			'user_id'  =>  $get_method['user_id'],
			'reply'  =>  $get_method['reply'],
			'comment_id'  =>  $get_method['comment_id']
		);    
		$qry = Insert('event_media_comment_reply',$data);
		$last_id=mysqli_insert_id($mysqli);
		$set=array('status' => '1','message' => '','msg' => $app_lang['add_success'],'success'=>'1');
		header('Content-Type: application/json; charset=utf-8' );
		$json = json_encode($set);
		echo $json;
		exit;
	}
	// Add event media comment reply end
	// Delete event media comment reply start
    else if($get_method['method_name']=="delete_event_media_comment_reply")
    {
    	$comment_reply_id = $get_method['comment_reply_id'];  
    	$user_id = $get_method['user_id'];  
        
		$deleteSql = "DELETE FROM event_media_comment_reply WHERE `id`='$comment_reply_id' AND `user_id`='$user_id'";
		if(mysqli_query($mysqli, $deleteSql)){
			$set = array('status' => '1','message' => '','msg'=>'Event Media Comment Reply Deleted','success'=>1);
		}
		else{

			$set = array('status' => '1','message' => '','msg'=>$app_lang['error_msg'],'success'=>0);
		}

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
	}
	// Delete get event media comment reply end
    // Get event media comment reply start
    else if($get_method['method_name']=="get_event_media_comment_reply")
    {
    	$comment_id= $get_method['comment_id'];  

    	$page_limit=API_PAGE_LIMIT;

    	$limit=($get_method['page']-1) * $page_limit;

    	$jsonObj_all= array();  

    	$query="SELECT * FROM event_media_comment_reply
    	WHERE event_media_comment_reply.`comment_id`='$comment_id' ORDER BY event_media_comment_reply.`id` DESC LIMIT $limit, $page_limit";
    	
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

    	while($data = mysqli_fetch_assoc($sql))
    	{

    		$row['id'] = $data['id'];
    		$row['comment_id'] = $data['comment_id'];
    		$row['reply'] = $data['reply'];
    		$row['user_id'] = $data['user_id'];
    		$row['user_name'] = get_user_info($data['user_id'],'name');
    		if(get_user_info($data['user_id'],'user_image') !='')
    		{
    			$row['user_image'] = $file_path.'images/'.get_user_info($data['user_id'],'user_image');
    		}	
    		else
    		{
    			$row['user_image'] = '';
    		}
		    $row['likes'] = get_total_comment_reply_likes($data['id']);
		    $row['dislikes'] = get_total_comment_reply_dislikes($data['id']);
		    $row['is_like'] = get_user_reply_like_status($data['id'],$data['user_id']);
		    $row['created_at'] = $data['created_at'];
    		array_push($jsonObj_all,$row);
    	}

    	$set['status'] = '1';
    	$set['message'] = '';
    	$set['EVENT_APP'] = $jsonObj_all;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
	}
	// Get event media comment end
	// Add event media favourite start
	else if($get_method['method_name']=="add_event_media_favourite")
	{
		$user_id =$get_method['user_id'];
		$event_media_id =$get_method['event_media_id'];

		$sql="SELECT * FROM event_media_favourite WHERE `user_id`='$user_id' AND `event_media_id`='$event_media_id'";
		$res=mysqli_query($mysqli, $sql);
		
		if($res->num_rows == 0){
			// add to favourite list

			$data = array( 
				'event_media_id'  =>  $event_media_id,
				'user_id'  =>  $user_id,
				'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
			);      

			$qry = Insert('event_media_favourite',$data);

			$set = array('status' => '1','message' => '','msg'=>$app_lang['add_favourite'],'success'=>1,'is_favourite'=>true);

		}
		else{
			// remove to favourite list

			$deleteSql="DELETE FROM event_media_favourite WHERE `user_id`='$user_id' AND `event_media_id`='$event_media_id'";

			if(mysqli_query($mysqli, $deleteSql)){
				$set = array('status' => '1','message' => '','msg'=>$app_lang['remove_favourite'],'success'=>1,'is_favourite'=>false);
			}
			else{

				$set = array('status' => '1','message' => '','msg'=>$app_lang['error_msg'],'success'=>0);
			}
		}

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	// Add event media favourite end
	
	// Add event media comment likes start
	else if($get_method['method_name']=="add_event_media_comment_likes")
	{
		$user_id =$get_method['user_id'];
		$comment_id =$get_method['comment_id'];

		$sql="SELECT * FROM event_media_comment_likes WHERE `user_id`='$user_id' AND `comment_id`='$comment_id'";
		$res=mysqli_query($mysqli, $sql);
		
		if($res->num_rows == 0){
			// add to favourite list

			$data = array( 
				'comment_id'  =>  $comment_id,
				'user_id'  =>  $user_id,
				'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
			);      
			$qry = Insert('event_media_comment_likes',$data);

			$set = array('status' => '1','message' => '','msg'=>$app_lang['add_success'],'success'=>1);

		}
		else{
			// remove to favourite list

			$deleteSql="DELETE FROM event_media_comment_likes WHERE `user_id`='$user_id' AND `comment_id`='$comment_id'";

			if(mysqli_query($mysqli, $deleteSql)){
				$set = array('status' => '1','message' => '','msg'=>$app_lang['update_success'],'success'=>1);
			}
			else{

				$set = array('status' => '1','message' => '','msg'=>$app_lang['error_msg'],'success'=>0);
			}
		}

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	// Add event media comment likes end
	
	// Add event media comment dislikes start
	else if($get_method['method_name']=="add_event_media_comment_dislikes")
	{
		$user_id =$get_method['user_id'];
		$comment_id =$get_method['comment_id'];

		$sql="SELECT * FROM event_media_comment_dislikes WHERE `user_id`='$user_id' AND `comment_id`='$comment_id'";
		$res=mysqli_query($mysqli, $sql);
		
		if($res->num_rows == 0){
			// add to favourite list

			$data = array( 
				'comment_id'  =>  $comment_id,
				'user_id'  =>  $user_id,
				'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
			);      
			$qry = Insert('event_media_comment_dislikes',$data);

			$set = array('status' => '1','message' => '','msg'=>$app_lang['add_success'],'success'=>1);

		}
		else{
			// remove to favourite list

			$deleteSql="DELETE FROM event_media_comment_dislikes WHERE `user_id`='$user_id' AND `comment_id`='$comment_id'";

			if(mysqli_query($mysqli, $deleteSql)){
				$set = array('status' => '1','message' => '','msg'=>$app_lang['update_success'],'success'=>1);
			}
			else{

				$set = array('status' => '1','message' => '','msg'=>$app_lang['error_msg'],'success'=>0);
			}
		}

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	// Add event media comment dislikes end
	
	// Add event media comment reply likes start
	else if($get_method['method_name']=="add_event_media_comment_reply_likes")
	{
		$user_id =$get_method['user_id'];
		$comment_reply_id =$get_method['comment_reply_id'];

		$sql="SELECT * FROM event_media_reply_likes WHERE `user_id`='$user_id' AND `comment_reply_id`='$comment_reply_id'";
		$res=mysqli_query($mysqli, $sql);
		
		if($res->num_rows == 0){
			// add to favourite list

			$data = array( 
				'comment_reply_id'  =>  $comment_reply_id,
				'user_id'  =>  $user_id,
				'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
			);      
			$qry = Insert('event_media_reply_likes',$data);

			$set = array('status' => '1','message' => '','msg'=>$app_lang['add_success'],'success'=>1,'is_favourite'=>true);

		}
		else{
			// remove to favourite list

			$deleteSql="DELETE FROM event_media_reply_likes WHERE `user_id`='$user_id' AND `comment_reply_id`='$comment_reply_id'";

			if(mysqli_query($mysqli, $deleteSql)){
				$set = array('status' => '1','message' => '','msg'=>$app_lang['update_success'],'success'=>1);
			}
			else{

				$set = array('status' => '1','message' => '','msg'=>$app_lang['error_msg'],'success'=>0);
			}
		}

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	// Add event media comment  reply likes end
	
	// Add event media comment reply likes start
	else if($get_method['method_name']=="add_event_media_comment_reply_dislikes")
	{
		$user_id =$get_method['user_id'];
		$comment_reply_id =$get_method['comment_reply_id'];

		$sql="SELECT * FROM event_media_reply_dislikes WHERE `user_id`='$user_id' AND `comment_reply_id`='$comment_reply_id'";
		$res=mysqli_query($mysqli, $sql);
		
		if($res->num_rows == 0){
			// add to favourite list

			$data = array( 
				'comment_reply_id'  =>  $comment_reply_id,
				'user_id'  =>  $user_id,
				'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
			);      
			$qry = Insert('event_media_reply_dislikes',$data);

			$set = array('status' => '1','message' => '','msg'=>$app_lang['add_success'],'success'=>1);

		}
		else{
			// remove to favourite list

			$deleteSql="DELETE FROM event_media_reply_dislikes WHERE `user_id`='$user_id' AND `comment_reply_id`='$comment_reply_id'";

			if(mysqli_query($mysqli, $deleteSql)){
				$set = array('status' => '1','message' => '','msg'=>$app_lang['update_success'],'success'=>1);
			}
			else{

				$set = array('status' => '1','message' => '','msg'=>$app_lang['error_msg'],'success'=>0);
			}
		}

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	// Add event media comment  reply likes end
	
	// Add event review start
    else if($get_method['method_name']=="add_event_review")
    {
		$data = array( 
			'user_id'  =>  $get_method['user_id'],
			'event_id'  =>  $get_method['event_id'],
			'description'  =>  $get_method['description'],
			'created_at' => date('Y-m-d H:i:s')
		);    
		$qry = Insert('event_reviews',$data);
		$last_id=mysqli_insert_id($mysqli);
		$set=array('status' => '1','message' => '','msg' => $app_lang['add_success'],'success'=>'1');
		header('Content-Type: application/json; charset=utf-8' );
		$json = json_encode($set);
		echo $json;
		exit;
	}
	// Add event review end
    // Get event review start
    else if($get_method['method_name']=="get_event_reviews")
    {
    	$event_id = $get_method['event_id'];  

    	$page_limit=10;

    	$limit=($get_method['page']-1) * $page_limit;

    	$jsonObj_all= array();  

    	$query="SELECT * FROM event_reviews
    	WHERE event_reviews.`event_id`='$event_id' ORDER BY event_reviews.`id` DESC LIMIT $limit, $page_limit";
    	
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

    	while($data = mysqli_fetch_assoc($sql))
    	{

    		$row['id'] = $data['id'];
    		$row['description'] = $data['description'];
    		$row['$event_id'] = $data['$event_id'];
    		$row['event_title'] = stripslashes(get_event_info($data['event_id'],'event_title'));
    		$row['user_name'] = get_user_info($data['user_id'],'name');
    		if(get_user_info($data['user_id'],'user_image') !='')
			{
				$row['user_image'] = $file_path.'images/'.get_user_info($data['user_id'],'user_image');
			}	
			else
			{
				$row['user_image'] = '';
			}
    		$row['created_at'] = $data['created_at'];   
    		array_push($jsonObj_all,$row);
    	}

    	$set['status'] = '1';
    	$set['message'] = '';
    	$set['EVENT_APP'] = $jsonObj_all;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
	}
	// Get event media comment end
	
    // Get Location start
    else if($get_method['method_name']=="get_locations")
    {
    	$API_KEY = 'AIzaSyCt1aq0GevUtpMApMtlnOt6AjeW8mamUCw';
    	$request = "https://maps.googleapis.com/maps/api/place/textsearch/json?";
    	$params  = array(
    		"query" => $get_method['keyword'],
    		"key"   => $API_KEY,
    	);
    	$request .= http_build_query($params);
        $jsonObj_all= array();  
    	$json = file_get_contents($request);
    	$data = json_decode($json, true);
    	$jsonObj_all = $data['results'];
    	$set['Results'] = $jsonObj_all;

    	header( 'Content-Type: application/json; charset=utf-8' );
    	echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
	}
	// Get Location end
	else
	{
		$get_method = checkSignSalt($_POST['data']);
	}

	?>