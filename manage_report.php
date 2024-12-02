<?php $page_title="Manage Reports";

include("includes/header.php");
require("includes/function.php");
require("language/language.php");
  
  function get_user_info($user_id)
   {

    global $mysqli;

    $user_qry="SELECT * FROM tbl_users WHERE `id`='".$user_id."'";
    $user_result=mysqli_query($mysqli,$user_qry);
    $user_row=mysqli_fetch_assoc($user_result);

    return $user_row;
   }
    
   if(isset($_GET['event_id'])){

      $event_id=trim($_GET['event_id']);

      $tableName="tbl_reports";    
      $targetpage = "manage_reports.php?event_id=".$event_id;  
      $limit = 15; 
      
      $query = "SELECT COUNT(*) as num FROM $tableName WHERE event_id='$event_id'";
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


      $sql="SELECT tbl_reports.*, tbl_events.`event_title` FROM tbl_reports
            LEFT JOIN tbl_events ON tbl_reports.`event_id`=tbl_events.`id`
            WHERE tbl_reports.`event_id`='$event_id'
            ORDER BY tbl_reports.`id` DESC LIMIT $start, $limit";
   }
   else{
      $tableName="tbl_reports";    
      $targetpage = "manage_reports.php";  
      $limit = 15; 
      
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


      $sql="SELECT tbl_reports.*, tbl_events.`event_title` FROM tbl_reports
            LEFT JOIN tbl_events ON tbl_reports.`event_id`=tbl_events.`id`
            ORDER BY tbl_reports.`id` DESC LIMIT $start, $limit";

      
   }
    
   $result=mysqli_query($mysqli,$sql);

?>

<style type="text/css">
  .select2{
    width: 100% !important;
  }
  .select2 .select2-selection--single .select2-selection__rendered{
    padding: 8px 10px;
  }
</style>

    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-7 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
            <div class="col-md-6">
                <select name="event_id" class="form-control event_id select2" style="padding: 5px 10px;height: 40px;">
                  <option value="">All Events</option>
                  <?php
                    $sql="SELECT * FROM tbl_events WHERE status='1' ORDER BY event_title";
                    $res=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
                    while($data=mysqli_fetch_array($res))
                    {
                  ?>                       
                  <option value="<?php echo $data['id'];?>" <?php if(isset($_GET['event_id']) && $_GET['event_id']==$data['id']){echo 'selected';} ?>><?php echo $data['event_title'];?></option>                           
                  <?php
                    }
                  ?>
                </select>
                </div>
		          <div class="clearfix"></div>
		          <div class="col-md-12 mrg-top">
		           <button class="btn btn-danger btn_cust btn_delete_all" style="margin-bottom:20px;"><i class="fa fa-trash"></i> Delete All</button>
		            <table class="table table-striped table-bordered table-hover">
		              <thead>
		                <tr>
		                  <th style="width:40px">
		                    <div class="checkbox" style="margin: 0px">
		                      <input type="checkbox" name="checkall" id="checkall" value="">
		                      <label for="checkall"></label>
		                    </div>
		                  </th>
		                  <th>Name</th>
		                  <th>Email</th>
		                  <th>Event</th>
		                  <th>Type</th>
		                  <th style="width: 200px;">Report</th> 
		                  <th style="width: 100px;">Action</th>
		                </tr>
		              </thead>
		              <tbody>
		                <?php
		                  $i=0;
						if(mysqli_num_rows($result) > 0){

		                  while($row=mysqli_fetch_array($result)){ ?>

		                 <tr>
		                  <td>  
		                    <div>
		                        <div class="checkbox" id="checkbox_contact">
		                          <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $row['event_id']; ?>" class="post_ids">
		                            <label for="checkbox<?php echo $i;?>">
		                          </label>
		                        </div>
		                    </div>
		                  </td>
		                  <td><?php echo get_user_info($row['user_id'])['name'];?></td>
		                  <td><?php echo get_user_info($row['user_id'])['email'] ;?></td>
		                  <td><?php echo $row['event_title'];?></td>
		                  <td><?php echo $row['type'];?></td>
		                  <td style="width: 200px;"><p><?php echo $row['report'];?></p></td>
		                  <td>
							<a href="" data-toggle="tooltip" data-tooltip="Delete" class="btn btn-danger btn_delete" data-id="<?=$row['event_id']?>"><i class="fa fa-trash"></i>
							</a>
						</td>
		                </tr>
		               <?php $i++; } } // end of if
  						else{ ?>
		                  <tr>
		                    <td colspan="7" class="text-center">
		                      <p style="font-size: 18px" class="text-muted"><strong>Sorry!</strong> no data found.</p>
		                    </td>
		                  </tr>
		                  <?php } ?>
		              </tbody>
		            </table>
		          </div>
		          <div class="col-md-12 col-xs-12">
		            <div class="pagination_item_block">
		              <nav>
		                <?php if(!isset($_POST["search"])){ include("pagination.php");}?>
		              </nav>
		            </div>
		          </div>
		          <div class="clearfix"></div>
		        </div>
		      </div>
		    </div>            
        
<?php include("includes/footer.php");?>  

<script type="text/javascript">

  $("select[name='event_id']").on("change",function(e){

    var params = new window.URLSearchParams(window.location.search);
    if(params.get('page')!=null){

      if($(this).val()!='')
      {
        window.location.href="manage_report.php?event_id="+$(this).val()+'&page='+params.get('page');
      }else{
        window.location.href="manage_report.php?page="+params.get('page');
      }        
    }
    else{
      if($(this).val()!='')
      {
        window.location.href="manage_report.php?event_id="+$(this).val();
      }else{
        window.location.href="manage_report.php";
      }
    }

  });

// for event delete
 $(".btn_delete").click(function(e){
      e.preventDefault();
      
     var _id=$(this).data("id");
      
        confirmDlg = duDialog('Are you sure?', 'All data will be removed which belong to this!', {
        init: true,
        dark: false, 
        buttons: duDialog.OK_CANCEL,
        okText: 'Proceed',
        callbacks: {
          okClick: function(e) {
            $(".dlg-actions").find("button").attr("disabled",true);
            $(".ok-action").html('<i class="fa fa-spinner fa-pulse"></i> Please wait..');
            var _tbl_nm='tbl_reports';
            $.ajax({
              type:'post',
              url:'processData.php',
              dataType:'json',
              data:{event_id:_id,'action':'removeReport'},
              success:function(res){
                location.reload();
              }
            });

          } 
        }
      });
      confirmDlg.show();
    });

// for multiple actions on report
$(".btn_delete_all").click(function(e){
	e.preventDefault();

	 var _ids = $.map($('.post_ids:checked'), function(c) {
      return c.value;
    });

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
					var _table='tbl_reports';

					$.ajax({
						type:'post',
						url:'processData.php',
						dataType:'json',
						data:{ids:_ids,'action':'removeAllRepoert'},
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

// Checkall input
var totalItems=0;

{$("#checkall_input").click(function () {
	
	totalItems=0;
	
	$("input[name='post_ids[]']").prop('checked', this.checked);
	
	$.each($("input[name='post_ids[]']:checked"), function(){
		totalItems=totalItems+1;
	});
	
	
	if($("input[name='post_ids[]']").prop("checked") == true){
		$('.notifyjs-corner').empty();
		$.notify(
			'Total '+totalItems+' item checked',
			{ position:"top center",className: 'success'}
			);
	}
	else if($("input[name='post_ids[]']").prop("checked") == false){
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
		exit;
	}
	
	$('.notifyjs-corner').empty();
	
	$.notify(
		'Total '+totalItems+' item checked',
		{ position:"top center",className: 'success'}
		);
});
}
 
</script>
