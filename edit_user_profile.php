<?php $page_title="Users Profile";

  	include('includes/header.php'); 
  	include('includes/function.php');
	include('language/language.php');  

	$user_id=strip_tags(addslashes(trim($_GET['user_id'])));

	if(!isset($_GET['user_id']) OR $user_id==''){
		header("Location: manage_users.php");
	}

    $user_qry="SELECT * FROM tbl_users WHERE id='$user_id'";
    $user_result=mysqli_query($mysqli,$user_qry);

    if(mysqli_num_rows($user_result)==0){
    	header("Location: manage_users.php");
    }

    $row=mysqli_fetch_assoc($user_result);

    $user_img='';

	if($row['user_image']!='' && file_exists('images/'.$row['user_image'])){
		$user_img='images/'.$row['user_image'];
	}
	else{
		$user_img='assets/images/user-icons.jpg';
	}

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


if(isset($_POST['btn_submit']) and isset($_POST['user_id']))
  { 
      
      $qry = "SELECT * FROM tbl_users WHERE id = '".$_POST['user_id']."'"; 
      $result = mysqli_query($mysqli,$qry);    
      $row = mysqli_fetch_assoc($result);

      if($_FILES['user_image']['name']!="")
      { 

      	if($row['user_image']!="")
	        {
	            unlink('images/'.$row['user_image']);
	        }
	        
      $file_name= str_replace(" ","-",$_FILES['user_image']['name']);
      $user_image=rand(0,99999)."_".$file_name;

      //Main Image
      $tpath1='images/'.$user_image;       
      $pic1=compress_image($_FILES["user_image"]["tmp_name"], $tpath1, 100);
      }   
      else
      {
      $user_image=$row['user_image'];
      }

      if($_POST['password']!="")
      {
      $data = array(
      'name'  =>  $_POST['name'],
        'email'  =>  $_POST['email'],
		'password'  =>  md5(trim($_POST['password'])),
        'phone'  =>  $_POST['phone'],
        'city'  =>  $_POST['city'],
        'address'  =>  $_POST['address'],
        'user_image' => $user_image,
      );
      }
      else
      {
      $data = array(
      'name'  =>  $_POST['name'],
        'email'  =>  $_POST['email'],
		'password'  =>  md5(trim($_POST['password'])),
        'phone'  =>  $_POST['phone'],
        'city'  =>  $_POST['city'],
        'address'  =>  $_POST['address'],
        'user_image' => $user_image,
      );
      }


      $user_edit=Update('tbl_users', $data, "WHERE id = '".$_POST['user_id']."'");
      
      $_SESSION['msg']="28";
      header("Location:edit_user_profile.php?user_id=".$_POST['user_id']);
}

?>
<link rel="stylesheet" type="text/css" href="assets/css/stylish-tooltip.css">
<style>
#applied_user .dataTables_wrapper .top{
	position: relative;
	width: 100%;
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
					<li role="created_events" class="active" style="width: auto">
					  <a href="edit_user_profile.php?user_id=<?=$user_id?>" aria-controls="created_events">User Profile</a>
					</li>
					<li role="created_events" style="width: auto">
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
				<div role="tabpanel" class="tab-pane active" id="edit_profile">
					<div class="row">
						<div class="col-md-12">
							<form action="" method="post" class="form form-horizontal" enctype="multipart/form-data">
								<input  type="hidden" name="user_id" value="<?php echo $_GET['user_id'];?>" />
					          <div class="section">
					            <div class="section-body">
					               <div class="form-group">
				                    <label class="col-md-3 control-label">Name :-</label>
				                    <div class="col-md-6">
				                      <input type="text" name="name" id="name" value="<?php if(isset($_GET['user_id'])){echo $row['name'];}?>" class="form-control" required>
				                    </div>
				                  </div>
				                 <?php if (!isset($_GET['user_id']) OR ($row['user_type']) == 'Normal') { ?>
				                  <div class="form-group"> 
				                    <label class="col-md-3 control-label">Email :-</label>
				                    <div class="col-md-6">
				                      <input type="email" name="email" id="email" value="<?php if(isset($_GET['user_id'])){echo $row['email'];}?>" class="form-control" required>
				                    </div>
				                  </div>
				                  <?php }else{?>
				                  	<div class="form-group">
				                    <label class="col-md-3 control-label">Email :-</label>
				                    <div class="col-md-6">
				                      <input type="email" name="email" id="email" readonly="" value="<?php if(isset($_GET['user_id'])){echo $row['email'];}?>" class="form-control" required>
				                    </div>
				                  </div>
				                  	<?php }?>
				                  <?php if (!isset($_GET['user_id']) OR ($row['user_type']) == 'Normal') { ?>
				                  <div class="form-group">
				                    <label class="col-md-3 control-label">Password :-</label>
				                    <div class="col-md-6">
				                      <input type="password" name="password" id="password" value="" class="form-control" <?php if(!isset($_GET['user_id'])){?>required<?php }?>>
				                    </div>
				                  </div>
				                 <?php }?>
				                  <div class="form-group">
				                    <label class="col-md-3 control-label">Phone :-</label>
				                    <div class="col-md-6">
				                      <input type="text" name="phone" id="phone" value="<?php if(isset($_GET['user_id'])){echo $row['phone'];}?>" class="form-control">
				                    </div>
				                  </div>
				                  <div class="form-group">
				                    <label class="col-md-3 control-label">City :-</label>
				                    <div class="col-md-6">
				                      <input type="text" name="city" id="city" value="<?php if(isset($_GET['user_id'])){echo $row['city'];}?>" class="form-control">
				                    </div>
				                  </div>
				                  <div class="form-group">
				                    <label class="col-md-3 control-label">Address :-</label>
				                    <div class="col-md-6">
				                      <input type="text" name="address" id="address" value="<?php if(isset($_GET['user_id'])){echo $row['address'];}?>" class="form-control">
				                    </div>
				                  </div>
				                  <div class="form-group">
				                    <label class="col-md-3 control-label">User Image :-</label>
				                    <div class="col-md-6">
				                      <div class="fileupload_block">
				                        <input type="file" name="user_image" value="" id="fileupload" onchange="readURL(this)">
				                            <?php if(isset($_GET['user_id']) and $row['user_image']!="") {?>
				                            <div class="fileupload_img"><img type="image" id="user_image" src="images/<?php echo $row['user_image'];?>" style="width: 90px;height: 90px" alt=" image" /></div>
				                          <?php } else {?>
				                            <div class="fileupload_img"><img id="user_image" type="image" src="assets/images/landscape.jpg" alt="category image" style="width: 90px;height: 90px"/></div>
				                          <?php }?>
				                      </div>
				                    </div>
				                  </div>
				                  
					     			<div class="form-group">
					                <div class="col-md-9 col-md-offset-3">
					                  <button type="submit" name="btn_submit" class="btn btn-primary">Save</button>
					                </div>
					              </div>
					            </div>
					          </div>
					        </form>
						</div>
					  </div>
					</div>
				    <div class="clearfix"></div>
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

      var _ids = $(this).data("id");

      if(_ids!='')
      {
        if(confirm("Are you sure to delete this event?")){

          $(".loader").show();
          $.ajax({
            type:'post',
            url:'processData.php',
            dataType:'json',
            data:{id:_ids,'action':'multi_delete','tbl_nm':'tbl_events'},
            success:function(res){
                console.log(res);
                if(res.status=='1'){
                  location.reload();
                }
                else if(res.status=='-2'){
                  alert(res.message);
                }
              }
          });
        }
      }
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#user_image').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
