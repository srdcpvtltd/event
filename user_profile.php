<?php $page_title="Created Events";

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
					<li role="created_events" class="active" style="width: auto">
					  <a href="user_profile.php?user_id=<?=$user_id?>" aria-controls="created_events">Created Events</a>
					</li>
					<li role="registered_events" style="width: auto">
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
				<div role="tabpanel" class="tab-pane active" id="created_events">
					<div class="row">
	      				<div class="col-md-12">
	            			<div class="row">
	            				<?php 

	            					$tableName="tbl_events";    
							        $targetpage = "user_profile.php?user_id=".$user_id;  
							        $limit = 9; 

							        $query ="SELECT COUNT(*) as num FROM tbl_events WHERE `user_id` = $user_id";

							        $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
							        $total_pages = $total_pages['num'];


							        $stages = 3;
							        $page=0;
							        if(isset($_GET['page'])){
							            $page = mysqli_real_escape_string($mysqli,$_GET['page']);
							        }
							        if($page){
							            $start = ($page - 1) * $limit; 
							        }else{
							            $start = 0; 
							        } 


							        $sql="SELECT tbl_events.*,tbl_category.`category_name` FROM tbl_events
							              LEFT JOIN tbl_category ON tbl_events.`cat_id`= tbl_category.`cid` 
							              WHERE tbl_events.`user_id` = $user_id
							              ORDER BY tbl_events.`id` DESC LIMIT $start, $limit";

							        $result=mysqli_query($mysqli,$sql);

							        if(mysqli_num_rows($result))
							        {
						                $i=0;
						                while($event_row=mysqli_fetch_array($result))
						                {    
					              ?>
					              <div class="col-lg-4 col-sm-6 col-xs-12">
					                <div class="block_wallpaper">
					                  <div class="wall_category_block">
					                    <h2><?php echo $event_row['category_name'];?></h2>  

					                    <?php if($event_row['is_slider']!="0"){?>
					                       <a href="javascript:void(0)" class="toggle_btn_a" data-id="<?php echo $event_row['id'];?>" data-action="deactive" data-column="is_slider" data-toggle="tooltip" data-tooltip="Slider"><div style="color:green;"><i class="fa fa-sliders"></i></div></a> 
					                    <?php }else{?>
					                       <a href="javascript:void(0)" class="toggle_btn_a" data-id="<?php echo $event_row['id'];?>" data-action="active" data-column="is_slider" data-tooltip="Add to Slider"><i class="fa fa-sliders"></i></a> 
					                    <?php }?>


					                  </div>
					                  <div class="wall_image_title">


					                      <p style="font-size: 16px;">
					                        <?php 
					                            if(strlen($event_row['event_title']) > 25){
					                              echo substr(stripslashes($event_row['event_title']), 0, 25).'...';  
					                            }else{
					                              echo $event_row['event_title'];
					                            }
					                        ?>
					                      </p>

					                     <?php
					                        $status=''; 
					                        if($event_row['registration_closed']=='true'){
					                          $status='<span style="color:red;"><strong style="font-weight: 500">Registration Status:</strong> [Closed]</span>';
					                        }
					                        else{
					                          $status='<span style=""><strong style="font-weight: 500">Registration Status:</strong> [Open]</span>';
					                        }
					                        
					                     ?>

					                     <p><?=$status?></p>
					                    <ul>

					                      <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $event_row['total_views'];?> Views"><i class="fa fa-eye"></i></a></li>
					                      
					                      <?php 
					                        if(isset($_GET['page'])){
					                          ?>
					                          <li><a href="edit_event.php?event_id=<?php echo $event_row['id'];?>&page=<?=$_GET['page']?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>
					                          <?php    
					                        }
					                        else{
					                          ?>
					                          <li><a href="edit_event.php?event_id=<?php echo $event_row['id'];?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>
					                          <?php 
					                        }
					                      ?>

					                      <li>
					                        <a href="" class="btn_delete_a" data-id="<?php echo $event_row['id'];?>"  data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
					                      </li>

					                      <?php if($event_row['status']!="0"){?>
					                        <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $event_row['id'];?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="" /></a></div></li>

					                      <?php }else{?>
					                        
					                        <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $event_row['id'];?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="" /></a></div></li>
					                      <?php }?>

					                    </ul>
					                  </div>
					                  <span><img src="images/<?php echo $event_row['event_banner'];?>" /></span>
					                </div>
					              </div>
					          	<?php } }else{ ?>
					          		<div class="col-md-12 text-center">
					          			<h3 class="text-muted">Sorry! no data found.</h3>
					          		</div>
					          	<?php } ?>
	            			</div>
            			</div>

            			<div class="col-md-12 col-xs-12">
				            <div class="pagination_item_block">
				              <nav>
				                <?php if(!isset($_POST["event_search"])){ include("pagination.php");}?>                 
				              </nav>
				            </div>
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

$(".toggle_btn a, .toggle_btn_a").on("click",function(e){
    e.preventDefault();
    $(".loader").show();
    
    var _for=$(this).data("action");
    var _id=$(this).data("id");
    var _column=$(this).data("column");
    var _table='tbl_events';

    $.ajax({
      type:'post',
      url:'processData.php',
      dataType:'json',
      data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','tbl_id':'id'},
      success:function(res){
          console.log(res);
          if(res.status=='1'){
            location.reload();
          }
        }
    });

  });
$(".btn_delete_a").click(function(e){
      e.preventDefault();

      var _ids=$(this).data("id");

      swal({
          title: "Are you sure?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger btn_edit",
          cancelButtonClass: "btn-warning btn_edit",
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: false,
          closeOnCancel: false,
          showLoaderOnConfirm: true
        },
        function(isConfirm) {
          if (isConfirm) {

            $.ajax({
              type:'post',
              url:'processData.php',
              dataType:'json',
              data:{id:_ids,'action':'multi_delete','tbl_nm':'tbl_events'},
              success:function(res){
                  if(res.status=='1'){
                    swal({
                        title: "Successfully", 
                        text: "Event is deleted...", 
                        type: "success"
                    },function() {
                        location.reload();
                    });
                  }
                }
            });
          }
          else{
            swal.close();
          }
      });
  });

</script>
