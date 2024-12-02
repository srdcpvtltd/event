<?php $page_title="Manage Event Feeds";

  include("includes/header.php");
	require("includes/function.php");
	require("language/language.php");
	
	//Get all Category 
    $tableName="event_feed";   
    $targetpage = "manage_color.php"; 
    $limit = 12; 
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
    $sql_query="SELECT * FROM event_feed ORDER BY event_feed.`id` DESC LIMIT $start, $limit"; 
    $result=mysqli_query($mysqli,$sql_query) or die(mysqli_error($mysqli));
    function get_user_name($user_id)
    { 
      global $mysqli;   
      $query="SELECT * FROM tbl_users WHERE tbl_users.`id`='".$user_id."'";        
      $user = mysqli_fetch_array(mysqli_query($mysqli,$query));
      $user_name = $user['name'];
      return $user_name;
  
    }    
    function get_event_name($event_id)
    { 
      global $mysqli;   
      $query="SELECT * FROM tbl_events WHERE tbl_events.`id`='".$event_id."'";        
      $event = mysqli_fetch_array(mysqli_query($mysqli,$query));
      $event_name = $event['event_title'];
      return $event_name;
  
    }
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
		          <div class="clearfix"></div>
		          <div class="col-md-12 mrg-top">
		            <table class="table table-striped table-bordered table-hover">
		              <thead>
		                <tr>
		                  <th>User Name</th>
		                  <th>Event Title</th>
		                  <th>Event Feed</th>
		                  <th style="width: 100px;">Action</th>
		                </tr>
		              </thead>
		              <tbody>
		                <?php
		                  $i=0;
						if(mysqli_num_rows($result) > 0){

		                  while($row=mysqli_fetch_array($result)){ ?>

		                 <tr>
		                  <td><?php echo get_user_name($row['user_id']);?></td>
		                  <td><?php echo get_event_name($row['event_id']) ;?></td>
		                  <td><?php echo $row['event_feed'];?></td>
		                  <td>
							<a href="" data-toggle="tooltip" data-tooltip="Delete" class="btn btn-danger btn_delete" data-id="<?=$row['id']?>"><i class="fa fa-trash"></i>
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
            var _tbl_nm='event_feed';
            $.ajax({
              type:'post',
              url:'processData.php',
              dataType:'json',
              data:{id:_id,'action':'multi_delete','tbl_nm':'event_feed'},
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
