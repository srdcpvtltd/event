<?php 
	
	include("includes/connection.php");
 	include("includes/function.php");

 	$_id=$_GET['id'];

 	$sql="SELECT tbl_event_booking.*, tbl_events.`event_title`, tbl_events.`event_address`, tbl_events.`event_phone`, tbl_events.`event_email`, tbl_events.`event_website`, tbl_events.`event_start_date`, tbl_events.`event_end_date`, tbl_events.`event_start_time`, tbl_events.`event_end_time`, tbl_events.`event_ticket`, tbl_events.`ticket_price` FROM tbl_event_booking
 			LEFT JOIN tbl_events ON tbl_event_booking.`event_id`=tbl_events.`id`
 			LEFT JOIN tbl_users ON tbl_event_booking.`user_id`=tbl_users.`id`
 			WHERE tbl_event_booking.`id`='$_id'";

 	$res=mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
 	$row=mysqli_fetch_assoc($res);

 	// print_r($row);

 	function get_user_info($user_id,$field_name) 
	{
		global $mysqli;

		$qry_user="SELECT * FROM tbl_users WHERE id='".$user_id."'";
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
	body{
		background:#14171a
	}
	body, table, thead, tbody, tr, td, img {
		padding: 0;
		margin: 0;
		border: none;
		line-height:26px;
		border-spacing: 0px;
		border-collapse: collapse;
		vertical-align: top;
		user-select: none; /* supported by Chrome and Opera */
	   -webkit-user-select: none; /* Safari */
	   -khtml-user-select: none; /* Konqueror HTML */
	   -moz-user-select: none; /* Firefox */
	   -ms-user-select: none; /* Internet Explorer/Edge */
	   color:#eee !important;
	}

	.wrapper {
		padding-left: 10px;
		padding-right: 10px;
	}
	strong{
		font-weight:600;
		color:#ffff;
	}
	h1{
		margin: 0;
		padding: 0;
		font-size:22px;
		padding-bottom: 25px;
		line-height: 1.4;
		font-weight:600;
		font-family: "Poppins", "Arial", sans-serif;
	}
	h2 {
		margin: 0;
		padding: 0;
		font-size:18px;
		padding-bottom: 0px;
		line-height: 1.2;
		font-weight:600;
		font-family: "Poppins", "Arial", sans-serif;
	}
	h3 {
		margin: 0;
		padding: 0;
		font-size:16px;
		padding-bottom: 0px;
		line-height: 1.2;
		font-weight:500;
		font-family: "Poppins", "Arial", sans-serif;
	}
	p {
		font-size:15px;
		color:#424242;
		font-family: "Poppins", "Arial", sans-serif;
	}
	a {
		font-size:15px;
		color:#fff;
		text-decoration:none;
		font-family: "Poppins", "Arial", sans-serif;
	}
	p, li {
		font-family: "Poppins", "Arial", sans-serif;
	}
	img.social_icon{
		width:60px;
		height:60px;
		margin:0 auto 10px auto;
		text-align:center
	}
	img {
		width: 100%;
		display: block;
	}
	 @media only screen and (max-width: 620px) {
		.wrapper .section {
			width: 100%;
		}
		.wrapper .column {
			width: 100%;
			display: block;
		}
		table.section{
			width:94%;
		}
		.section td.column h3{
			padding-left:5px;
		}
		.section td.column{
			width:100%;
			display: block;
		}
	}
</style>
</head>
    <body>
    <table width="100%">
      <tbody>
        <tr>
          <td class="wrapper" id="capture" width="600" align="center">            
            <table class="section header" cellpadding="0" cellspacing="0" width="600" style="margin-bottom:20px;margin-top:20px">
              <tr>
				<td class="column" width="220" valign="top">
				  <table>
                    <tbody>
                      <tr>
                        <td><img src="images/<?=APP_LOGO?>" alt="" style="width: 150px;height: 150px;margin-top: 30px;"/></td>
                      </tr>
                    </tbody>
                  </table>
				</td>
                <td class="column" width="20" valign="top">
				  <table>
                    <tbody>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
				</td>
                <td class="column" width="360" valign="top">
				  <table>
                    <tbody>
                      <tr>
                        <td><p style="text-align:left;line-height: 30px;">
							<strong>Name:</strong> <span style="color:#dddddd;"><?=$row['user_name']?><br></span>
							<strong>Mobile:</strong> <span style="color:#dddddd;"><?=$row['user_phone']?></span><span style="color:#ffff;"><br>
							<strong>Email:</strong><span style="color:#dddddd;"> <?=$row['user_email']?></span><br>
							<strong>Booked By:</strong> <?=get_user_info($row['user_id'],'name')?><br>
							<strong>User Email:</strong><span style="color:#dddddd;"> <?=get_user_info($row['user_id'],'email')?></span><br>
							<strong>Booking Date:</strong> <span style="color:#dddddd;"><?=date('d M, Y', $row['created_at'])?></span></p>
						</td>
                      </tr>
                    </tbody>
                  </table>
				</td>                
              </tr>
            </table>
            <table class="section header" cellpadding="0" cellspacing="0" width="600">
              <tr>
				<td class="column">
				  <table>
                    <tbody>
                      <tr>
                        <h1><?=$row['event_title']?></h1>                        
                      </tr>
                    </tbody>
                  </table>
				</td>
              </tr>
            </table>            
            <table class="section" cellpadding="0" cellspacing="0">
              <tr>
              	<table class="section header" cellpadding="0" cellspacing="0" width="600">
				  <tr>
					<td class="column">
					  <table>
						<tbody>
						  <tr>
							<h2>Location</h2>
							<td><p style="text-align:left;"><span style="color:#dddddd;"><?=$row['event_address']?></span></p></td>
						  </tr>
						</tbody>
					  </table>
					</td>
				  </tr>
				</table>

				<table class="section header" cellpadding="0" cellspacing="0" width="600">
				  <tr>
					<td class="column">
					  <table>
						<tbody>
						  <tr>
							<h2>Date</h2>
							<td><p style="text-align:left;"><span style="color:#dddddd;">
								<?=date('d M, Y',$row['event_start_date']).' , '.date('h:i a',$row['event_start_time'])?><br>
								<?=date('d M, Y',$row['event_end_date']).' , '.date('h:i a',$row['event_end_time'])?></span></p>
							</td>
						  </tr>
						</tbody>
					  </table>
					</td>
				  </tr>
				</table>
              </tr>
            </table>
			<table class="section" cellpadding="0" cellspacing="0" width="600" style="margin:0px auto 20px auto;background:#242a2f;border-radius:10px">
              <tr>
				<td class="column" width="150" valign="top">
				  <table style="text-align:center;width:100%">
                    <tbody>
                      <tr>
                        <td>
							<p style="text-align:center;">
								<strong>Ticket No.</strong><span style="color:#dddddd;"><br>
								<?=$row['ticket_no']?></span>
							</p>
						</td>
                      </tr>
                    </tbody>
                  </table>
				</td>
				<td class="column" width="150" valign="top">
				  <table style="text-align:center;width:100%">
                    <tbody>
                      <tr>
                        <td>
							<p style="text-align:center;">
								<strong>Nos. Tickets</strong><span style="color:#dddddd;"><br>
								<?=$row['total_ticket']?></span>
							</p>
						</td>
                      </tr>
                    </tbody>
                  </table>
				</td>
                <td class="column" width="150" valign="top">
				  <table style="text-align:center;width:100%">
                    <tbody>
                      <tr>
                        <td>
							<p style="text-align:center;">
								<strong>Ticket Price</strong><span style="color:#dddddd;"><br>
								<?=$row['ticket_price']?></span>
							</p>
						</td>
                      </tr>
                    </tbody>
                  </table>
				</td>
                <td class="column" width="150" valign="top">
				  <table style="text-align:center;width:100%">
                    <tbody>
                      <tr>
                        <td>
							<p style="text-align:center;">
								<strong>Total Price</strong><br><span style="color:#dddddd;">
								<?php echo $row['total_ticket']*$row['ticket_price']?>	</span>						
							</p>
						</td>
                      </tr>
                    </tbody>
                  </table>
				</td>                
              </tr>
            </table>
			<table class="section" cellpadding="0" cellspacing="0" width="600" style="margin:10px auto 0 auto;background:linear-gradient(90deg, rgba(169,121,59,1) 0%, rgba(179,110,22,1) 100%);border-radius:10px">
              <tr>
				<td class="column" width="200" valign="top">
				  <table style="text-align:center;width:100%">
                    <tbody>
                      <tr>
                        <td>
							<p style="text-align:center;">
								<img class="social_icon" src="images/contact.png" alt="" />
								<a href="javascript:void(0)"><?=$row['event_phone']?></a>
							</p>
						</td>
                      </tr>
                    </tbody>
                  </table>
				</td>
                <td class="column" width="200" valign="top">
				  <table style="text-align:center;width:100%">
                    <tbody>
                      <tr>
                        <td>
							<p style="text-align:center;">
								<img class="social_icon" src="images/email.png" alt="" />
								<a href="javascript:void(0)"><?=$row['event_email']?></a>
							</p>
						</td>
                      </tr>
                    </tbody>
                  </table>
				</td>
                <td class="column" width="200" valign="top">
				  <table style="text-align:center;width:100%">
                    <tbody>
                      <tr>
                        <td>
							<p style="text-align:center;">
								<img class="social_icon" src="images/web.png" alt="" />
								<a href="javascript:void(0)"><?=$row['event_website']?></a>
							</p>
						</td>
                      </tr>
                    </tbody>
                  </table>
				</td>                
              </tr>
            </table>			
			<table class="section" cellpadding="0" cellspacing="0" width="600" style="margin:20px auto">
              <tr>
				<td class="column">
				  <table>
                    <tbody>
                      <tr>
                        <h3>Thanks! - <?=APP_NAME?></h3>                        
                      </tr>
                    </tbody>
                  </table>
				</td>
              </tr>
            </table> 	
		  </td>		  
        </tr>
      </tbody>
    </table>
</body>
</html>
