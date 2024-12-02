<?php  $page_title="Registered Events";

  	include('includes/header.php'); 
  	include('includes/function.php');
	include('language/language.php');  

	$user_id=trim($_GET['user_id']);

	$sql="SELECT * FROM tbl_users WHERE `id`='$user_id'";
	$res=mysqli_query($mysqli, $sql);
	$row=mysqli_fetch_assoc($res);

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

	 $sql="SELECT tbl_event_booking.*, tbl_events.`event_title` FROM tbl_event_booking
	    LEFT JOIN tbl_events ON tbl_event_booking.`event_id`=tbl_events.`id`
	    WHERE tbl_event_booking.`user_id`='$user_id'
	    ORDER BY tbl_event_booking.`id` DESC";  

	$result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));

function getLastActiveLog($user_id){
    	global $mysqli;

    	$sql="SELECT * FROM tbl_active_log WHERE `user_id`='$user_id'";
        $res=mysqli_query($mysqli, $sql);

        if(mysqli_num_rows($res) == 0){
        	echo 'no available';
        }
        else{

        	$row=mysqli_fetch_assoc($res);
			return calculate_time_span($row['date_time'],true);	
        }
    }
    
    $user_img='';

	if($row['user_image']!='' && file_exists('images/'.$row['user_image'])){
		$user_img='images/'.$row['user_image'];
	}
	else{
		$user_img='assets/images/user-icons.jpg';
	}
?>

<style type="text/css">
	.dataTables_wrapper .top{
		padding-top: 0px;	
	}
	.dataTables_wrapper{
		overflow: auto;
	}
</style>

<div class="row">
	<div class="col-lg-12">
		<?php
			if(isset($_GET['redirect'])){
	          echo '<a href="'.$_GET['redirect'].'"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
	        }
	        else{
	         	echo '<a href="manage_users.php"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
	        }
		?>
		<div class="page_title_block user_dashboard_item" style="background-color: #333;border-radius:6px;0 1px 4px 0 rgba(0, 0, 0, 0.14);border-bottom:0">
			<div class="user_dashboard_item">
			  <div class="col-md-12 col-xs-12"> <br>
				<span class="badge badge-success badge-icon">
				  <div class="user_profile_img">
				  	<?php 
		                if($row['user_type']=='Google'){
		                  echo '<img src="assets/images/google-logo.png" style="width: 16px;height: 16px;position: absolute;top: 24px;z-index: 1;left: 62px;">';
		                }
		                else if($row['user_type']=='Facebook'){
		                  echo '<img src="assets/images/facebook-icon.png" style="width: 16px;height: 16px;position: absolute;top: 24px;z-index: 1;left: 62px;">';
		                }
		              ?>
					<img type="image" src="<?php echo $user_img;?>" alt="image" style=""/>
				  </div>
				  <span style="font-size: 14px;"><?php echo $row['name'];?>				
				  </span>
				</span>  
				<span class="badge badge-success badge-icon">
					<i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
					<span style="font-size: 14px;text-transform: lowercase;"><?php echo $row['email'];?></span>
				</span> 
				<span class="badge badge-success badge-icon">
				  <strong style="font-size: 14px;">Registered At:</strong>
				  <span style="font-size: 14px;"><?php echo (date('d-m-Y',$row['created_at']));?></span>
				</span>
				<span class="badge badge-success badge-icon">
					  <strong style="font-size: 14px;">Last Activity On:</strong>
					  <span style="font-size: 14px;text-transform: lowercase;"><?php echo getLastActiveLog($user_id)?></span>
					</span>
				<br><br/>
			  </div>
			</div>
		</div>
		<div class="card card-tab">
			<div class="card-header" style="overflow: hidden;">
				<ul class="nav nav-tabs">
					<li role="created_events" style="width: auto">
					  <a href="edit_user_profile.php?user_id=<?=$user_id?>" aria-controls="created_events">User Profile</a>
					</li>
					<li role="created_events" style="width: auto">
					  <a href="user_profile.php?user_id=<?=$user_id?>" aria-controls="created_events">Created Events</a>
					</li>
					<li role="registered_events" class="active" style="width: auto">
					  <a href="registered_events.php?user_id=<?=$user_id?>" aria-controls="registered_events">Registered Events</a>
					</li>
					<li role="favourite_event" style="width: auto">
					  <a href="favourite_event.php?user_id=<?=$user_id?>" aria-controls="favourite_event">Favourite Events</a>
					</li>
					<li role="recent_event" style="width: auto">
					  <a href="recent_event.php?user_id=<?=$user_id?>" aria-controls="recent_event">Recent Events</a>
					</li>
					
				</ul>
			</div>
			<div class="card-body no-padding tab-content">
	      		<div role="tabpanel" class="tab-pane active" id="registered_events">
	      			<div class="row">
	      				<div class="col-md-12">
		      				<table class="table table-striped table-bordered table-hover datatable" style="margin-top: 50px !important;overflow-y: auto;">
				              <thead>
				                <tr> 
				                  <th>Ticket No.</th>
				                  <th>Event</th>
				                  <th>Name</th>		
				                  <th>Email</th>
				                  <th>Phone</th>    
				                  <th>Tickets</th>  
				                  <th>Date</th>	 
				                  <th class="cat_action_list">Action</th>
				                </tr>
				              </thead>
				              <tbody>
				              	<?php
									while ($row=mysqli_fetch_assoc($result)) {
				              	?>
				              	<tr> 
									<td><?php echo $row['ticket_no'];?></td>
									<td nowrap="" title="<?=get_event_info($row['event_id'],'event_title')?>">
										<?php 
				                            if(strlen(get_event_info($row['event_id'],'event_title')) > 20){
				                              echo substr(stripslashes(get_event_info($row['event_id'],'event_title')), 0, 20).'...';  
				                            }else{
				                              echo get_event_info($row['event_id'],'event_title');
				                            }
				                        ?>
				                   	</td>
									<td><?php echo $row['user_name'];?></td>   
									<td style="word-break: inherit;"><?php echo $row['user_email'];?></td>   
									<td><?php echo $row['user_phone'];?></td>   
									<td><?php echo $row['total_ticket'];?></td>   
									<td nowrap=""><?php echo date('d-m-Y',$row['created_at']);?></td>
									<td nowrap="">
									<a href="ticket.php?id=<?php echo $row['id'];?>" target="_blank" class="btn btn-success btn_edit btn_ticket" data-toggle="tooltip" data-tooltip="Ticket"><i class="fa fa-ticket"></i></a>

									<a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn_delete" data-toggle="tooltip" data-tooltip="Delete !"><i class=" fa fa-trash"></i></a>
									</td>
								</tr>
				              	<?php } ?>
				              </tbody>
				            </table>
		      			</div>
				        <div class="clearfix"></div>
	      			</div>
	      		</div>
	      	</div>
		</div>
	</div>

<?php include("includes/footer.php");?>

<script type="text/javascript">

  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
    document.title = $(this).text()+" | <?=APP_NAME?>";
  });

  var activeTab = localStorage.getItem('activeTab');
  if(activeTab){
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
  }

// For delete register events
$(".btn_delete").click(function(e){
	e.preventDefault();

	 var _id = $(this).data("id");
    var _table='tbl_event_booking';

	confirmDlg = duDialog('Are you sure?', 'All data will be removed which belong to this!', {
		init: true,
		dark: false, 
		buttons: duDialog.OK_CANCEL,
		okText: 'Proceed',
		callbacks: {
			okClick: function(e) {
				$(".dlg-actions").find("button").attr("disabled",true);
				$(".ok-action").html('<i class="fa fa-spinner fa-pulse"></i> Please wait..');
				$.ajax({
					type:'post',
					url:'processData.php',
					dataType:'json',
					data:{'id':_id,'tbl_nm':_table,'tbl_id':'id','action':'removeData'},
					success:function(res){
						location.reload();
					}
				});
			} 
		}
	});
	confirmDlg.show();
});

</script>
