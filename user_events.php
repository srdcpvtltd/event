<?php $page_title="Manage User Event";

    include('includes/header.php'); 
    include('includes/function.php');
    include('language/language.php');  


$tableName="tbl_events";   
$limit = 12; 
    
	//filter
	if(isset($_GET['filter'])){
			if($_GET['filter']=='enable'){
			  $status="tbl_events.`status`='1'";
			}else if($_GET['filter']=='disable'){
			  $status="tbl_events.`status`='0'";
			}
			else if($_GET['filter']=='closed'){
	        $status="tbl_events.`registration_closed`='true'";
		    }
		    else if($_GET['filter']=='open'){
		    $status="tbl_events.`registration_closed`='false'";
		    }
      } 


  if(isset($_GET['cat_id'])){
  
      $cat_id = filter_var($_GET['cat_id'], FILTER_SANITIZE_STRING);

  	 if(isset($_GET['filter'])){
      
        $query ="SELECT COUNT(*) as num FROM tbl_events 
					LEFT JOIN tbl_category ON tbl_events.`cat_id`=tbl_category.`cid`
		        	WHERE $status AND ".$_GET['filter']." AND tbl_events.`user_id` <> 0";

        $targetpage = "manage_events.php?cat_id=$cat_id&filter=".$_GET['filter'];
      }
      else{
       $query = "SELECT COUNT(*) as num FROM $tableName WHERE `cat_id`='$cat_id' AND tbl_events.`user_id` <> 0";

	   $targetpage = "manage_events.php?cat_id=".$cat_id; 
      }
      
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

     $sql="SELECT tbl_category.`category_name`,tbl_events.* FROM tbl_events
	            LEFT JOIN tbl_category ON tbl_events.`cat_id`= tbl_category.`cid` 
	            WHERE tbl_events.`cat_id`='$cat_id' AND tbl_events.`user_id` <> 0
	            ORDER BY tbl_events.`id` DESC LIMIT $start, $limit";

	 $events_result=mysqli_query($mysqli,$sql);

      if(isset($_GET['filter'])){
  
        	$status='';

			if(isset($_GET['filter'])){
			if($_GET['filter']=='enable'){
			  $status="tbl_events.`status`='1'";
			}else if($_GET['filter']=='disable'){
			  $status="tbl_events.`status`='0'";
			}
			else if($_GET['filter']=='closed'){
	        $status="tbl_events.`registration_closed`='true'";
		    }
		    else if($_GET['filter']=='open'){
		    $status="tbl_events.`registration_closed`='false'";
		    }
      } 

        $sql="SELECT tbl_category.`category_name`,tbl_events.* FROM tbl_events
				LEFT JOIN tbl_category ON tbl_events.`cat_id`=tbl_category.`cid`
				WHERE $status AND tbl_events.`cat_id`='$cat_id' AND tbl_events.`user_id` <> 0
				ORDER BY tbl_events.`id` DESC LIMIT $start, $limit";

        $events_result=mysqli_query($mysqli,$sql);
      }

  }
  else if(isset($_GET['filter'])){

		
			$targetpage = "manage_events.php?filter=".$_GET['filter'];
			$status='';

			if(isset($_GET['filter'])){
			if($_GET['filter']=='enable'){
			  $status="tbl_events.`status`='1'";
			}else if($_GET['filter']=='disable'){
			  $status="tbl_events.`status`='0'";
			}
			else if($_GET['filter']=='closed'){
	        $status="tbl_events.`registration_closed`='true'";
		    }
		    else if($_GET['filter']=='open'){
		    $status="tbl_events.`registration_closed`='false'";
		    }
      	} 
		    
			$query ="SELECT COUNT(*) as num FROM tbl_events 
					LEFT JOIN tbl_category ON tbl_events.`cat_id`=tbl_category.`cid`
		        	WHERE $status AND tbl_events.`user_id` <> 0";
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


			$sql="SELECT tbl_category.`category_name`,tbl_events.* FROM tbl_events
				LEFT JOIN tbl_category ON tbl_events.`cat_id`=tbl_category.`cid`
				WHERE $status AND tbl_events.`user_id` <> 0
				ORDER BY tbl_events.`id` DESC LIMIT $start, $limit";
			 
	 		$events_result=mysqli_query($mysqli,$sql);
	 }
  else if(isset($_POST['event_search']))
	 {
		
		 $keyword=addslashes(trim($_POST['search_value'])); 
		 
		 $sql="SELECT tbl_events.*,tbl_category.`category_name` FROM tbl_events
              LEFT JOIN tbl_category ON tbl_events.`cat_id`= tbl_category.`cid` 
              WHERE tbl_events.`event_title` LIKE '%$keyword%' AND tbl_events.`user_id` <> 0 ORDER BY tbl_events.`event_title`";  

         $events_result=mysqli_query($mysqli,$sql);

	 }else{
			     
		      $targetpage = "manage_events.php";
		      $query = "SELECT COUNT(*) as num FROM $tableName";
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
              WHERE tbl_events.`user_id` <> 0
              ORDER BY tbl_events.`id` DESC LIMIT $start, $limit";
		 
		     $events_result=mysqli_query($mysqli,$sql);
		} 

    function get_userinfo($user_id)
    { 
        global $mysqli; 

        $user_qry="SELECT * FROM tbl_users where id='".$user_id."'";
        $user_result=mysqli_query($mysqli,$user_qry);
        $user_row=mysqli_fetch_assoc($user_result);

        return $user_row['name'];
    }

    function get_total_booking($event_id)
    { 
        global $mysqli;   

        $qry_songs="SELECT COUNT(*) as num FROM tbl_event_booking WHERE event_id='".$event_id."'";

        $total_item = mysqli_fetch_array(mysqli_query($mysqli,$qry_songs));
        $total_item = $total_item['num'];

        return $total_item;

    }
  
?>

 <div class="row">
      <div class="col-xs-12">
      <?php
      	if(isset($_SERVER['HTTP_REFERER']))
      	{
      		echo '<a href="'.$_SERVER['HTTP_REFERER'].'"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
      	}
      	?>
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
            <div class="col-md-7 col-xs-12">              
              <div class="search_list">
                <div class="search_block">
                  <form  method="post" action="">
                    <input class="form-control input-sm" placeholder="Search..." aria-controls="DataTables_Table_0" type="search" name="search_value" value="<?php if(isset($_POST['search_value'])){ echo $_POST['search_value']; } ?>" required>
                    <button type="submit" name="event_search" class="btn-search"><i class="fa fa-search"></i></button>
                  </form>  
                </div>
              </div>
            </div>
			<div class="clearfix"></div>
            <form id="filterForm" accept="" method="GET">
                <div class="col-md-3"> 
                    <select name="filter" class="form-control select2 filter" style="padding: 5px 10px;height: 40px;">
                      <option value="">All</option>
                      <option value="enable" <?php if(isset($_GET['filter']) && $_GET['filter']=='enable'){ echo 'selected';} ?>>Enable</option>
                      <option value="disable" <?php if(isset($_GET['filter']) && $_GET['filter']=='disable'){ echo 'selected'; } ?>>Disable</option>
                      <option value="open" <?php if(isset($_GET['filter']) && $_GET['filter']=='open'){ echo 'selected'; } ?>>Open</option>
                      <option value="closed" <?php if(isset($_GET['filter']) && $_GET['filter']=='closed'){ echo 'selected'; } ?>>Closed</option>
                    </select>
                </div>
               	<div class="col-md-3"> 
                    <select name="cat_id" class="form-control select2 filter" style="padding: 5px 10px;height: 40px;">
                      <option value="">All Category</option>
                      <?php
                        $sql_category="SELECT * FROM tbl_category ORDER BY category_name";
                        $res=mysqli_query($mysqli,$sql_category) or die(mysqli_error($mysqli));
                        while($data=mysqli_fetch_array($res))
                        {
                      ?>                       
                      <option value="<?php echo $data['cid'];?>" <?php if(isset($_GET['cat_id']) && $_GET['cat_id']==$data['cid']){echo 'selected';} ?>><?php echo $data['category_name'];?></option>                           
                      <?php
                        }
                      ?>
                    </select>
            	</div>
        	</form>
            <div class="col-md-3 col-xs-12" style="float: right;width: 18%">
              <div class="checkbox" style="width: 100px;margin-top: 8px;margin-left: 10px;float: left;right: 90px;position: absolute;">
                  <input type="checkbox" id="checkall_input">
                  <label for="checkall_input">
                      Select All
                  </label>
                </div>
                <div class="dropdown" style="float:right">
                  <button class="btn btn-primary dropdown-toggle btn_delete" type="button" data-toggle="dropdown">Action
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu" style="right:0;left:auto;">
                    <li><a href="" class="actions" data-action="enable">Enable</a></li>
                    <li><a href="" class="actions" data-action="disable">Disable</a></li>
                    <li><a href="" class="actions" data-action="delete">Delete !</a></li>
                  </ul>
                </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div role="tabpanel" class="card-body mrg_bottom" style="padding: 0px">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"><a href="manage_events.php" aria-controls="home" aria-expanded="true">Admin Events</a></li>
                <li role="presentation" class="active"><a href="user_events.php" aria-controls="profile" aria-expanded="false">Users Events</a></li>
            </ul>
          </div>
          <div class="col-md-12 mrg-top">
            <div class="row">
              <?php 
                $i=0;
                while($event_row=mysqli_fetch_array($events_result))
                	  {?>
              <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="block_wallpaper">
                  <div class="wall_category_block">
                    <h2><?php echo $event_row['category_name'];?></h2>  

                    <?php if($event_row['is_slider']!="0"){?>
                       <a href="javascript:void(0)" class="toggle_btn_a" data-id="<?php echo $event_row['id'];?>" data-action="deactive" data-column="is_slider" data-toggle="tooltip" data-tooltip="Slider"><div style="color:green;"><i class="fa fa-sliders"></i></div></a> 
                    <?php }else{?>
                       <a href="javascript:void(0)" class="toggle_btn_a" data-id="<?php echo $event_row['id'];?>" data-action="active" data-column="is_slider" data-tooltip="Add to Slider"><i class="fa fa-sliders"></i></a> 
                    <?php }?>

                    <div class="checkbox" style="float: right;">
                      <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $event_row['id']; ?>" class="post_ids">
                      <label for="checkbox<?php echo $i;?>">
                      </label>
                    </div>

                  </div>
                  <div class="wall_image_title">
                      <p style="font-size: 16px;">
                        <?php 
                            if(strlen($event_row['event_title']) > 25){
                              echo substr(stripslashes($event_row['event_title']), 0, 25).'...';  
                            }else{
                              echo $event_row['event_title'];
                            } ?>
                      </p>
                      <span>
                        <strong style="font-weight: 500;">Created By:</strong><a href="edit_user_profile.php?user_id=<?= $event_row['user_id'] ?>" style="color:#fff;font-weight: 500;">
                        <?php 
                            if(strlen(get_userinfo($event_row['user_id'])) > 15){
                              echo substr(stripslashes(get_userinfo($event_row['user_id'])), 0, 15).'...';  
                            }else{
                              echo get_userinfo($event_row['user_id']);
                            }
                        ?></a>
                      </span>
                     <?php
                        $status=''; 
                        if($event_row['registration_closed']=='true'){
                          $status='<span style="color:red;"><strong style="font-weight: 500">Registration Status:</strong> [Closed]</span>';
                        }
                        else{
                          $status='<span style=""><strong style="font-weight: 500">Registration Status:</strong> [Open]</span>';
                        }?>

                     <p><?=$status?></p>
                      <ul>
                      <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $event_row['total_views'];?> Views"><i class="fa fa-eye"></i></a></li>
                      <li><a href="edit_event.php?event_id=<?php echo $event_row['id'];?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>
                      <li><a href="" class="btn_delete_a" data-id="<?php echo $event_row['id'];?>"  data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
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
          <?php $i++; } ?>     
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

<?php include('includes/footer.php');?> 

<script type="text/javascript">

  $.urlParam = function(name){
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      if (results==null) {
      return '';
      }
      return decodeURI(results[1]) || 0;
  }

  //for user event enable and disable
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

  //for user event delete
 $(".btn_delete_a").click(function(e){
      e.preventDefault();
      
      var _ids=$(this).data("id");
      
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
              data:{id:_ids,'action':'multi_delete','tbl_nm':'tbl_events'},
              success:function(res){
                location.reload();
              }
            });

          } 
        }
      });
      confirmDlg.show();
    });

// for multiple actions on user event
$(".actions").click(function(e){
    e.preventDefault();

    var _ids = $.map($('.post_ids:checked'), function(c){return c.value; });
    var _action=$(this).data("action");

    if(_ids!='')
    {
      confirmDlg = duDialog('Action: '+$(this).text(), 'Do you really want to perform?', {
        init: true,
        dark: false, 
        buttons: duDialog.OK_CANCEL,
        okText: 'Proceed',
        callbacks: {
          okClick: function(e) {
            $(".dlg-actions").find("button").attr("disabled",true);
            $(".ok-action").html('<i class="fa fa-spinner fa-pulse"></i> Please wait..');
            var _table='tbl_video';

            $.ajax({
              type:'post',
              url:'processData.php',
              dataType:'json',
              data:{id:_ids,for_action:_action,table:_table,'action':'multi_action'},
              success:function(res){
                $('.notifyjs-corner').empty();
                if(res.status=='1'){
                  location.reload();
                }
              }
            });

          } 
        }
      });
      confirmDlg.show();
    }
    else{
      infoDlg = duDialog('Opps!', 'No data selected', { init: true });
      infoDlg.show();
    }
});


 var totalItems=0;

  $("#checkall_input").click(function () {

    totalItems=0;

    $('input:checkbox').not(this).prop('checked', this.checked);
    $.each($("input[name='post_ids[]']:checked"), function(){
      totalItems=totalItems+1;
    });

    if($('input:checkbox').prop("checked") == true){
      $('.notifyjs-corner').empty();
      $.notify(
        'Total '+totalItems+' item checked',
        { position:"top center",className: 'success'}
      );
    }
    else if($('input:checkbox'). prop("checked") == false){
      totalItems=0;
      $('.notifyjs-corner').empty();
    }
  });

  var noteOption = {
      clickToHide : false,
      autoHide : false,
  }

  $.notify.defaults(noteOption);

  $(".post_ids").click(function(e){

      if($(this).prop("checked") == true){
        totalItems=totalItems+1;
      }
      else if($(this). prop("checked") == false){
        totalItems = totalItems-1;
      }

      if(totalItems==0){
        $('.notifyjs-corner').empty();
        exit();
      }

      $('.notifyjs-corner').empty();

      $.notify(
        'Total '+totalItems+' item checked',
        { position:"top center",className: 'success'}
      );
  });

 $(".filter").on("change",function(e){
    $("#filterForm *").filter(":input").each(function(){
      if ($(this).val() == '')
        $(this).prop("disabled", true);
    });
    $("#filterForm").submit();
  });

</script> 

