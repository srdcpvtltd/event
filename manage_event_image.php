<?php $page_title="Manage Event Images";

  include("includes/header.php");
	require("includes/function.php");
	require("language/language.php");
	
	//Get all Category 
    $tableName="event_image";   
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
    $sql_query="SELECT * FROM event_image ORDER BY event_image.`id` DESC LIMIT $start, $limit"; 
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
              <!-- <div class="search_list">
                <div class="add_btn_primary"> <a href="add_card_image.php?add=yes">Add Card Image</a> </div>
              </div> -->
            </div>
            
          </div>
          <div class="clearfix"></div>
          <div class="col-md-12 mrg-top">
            <div class="row">
              <?php 
              $i=0;
              while($row=mysqli_fetch_array($result))
              {         
            ?>
              <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="block_wallpaper add_wall_category">  
                         
                  <div class="wall_image_title">
                    <h2><a href="javascript:void(0)"><?php echo get_user_name($row['user_id']);?> (<?php echo get_event_name($row['event_id']);?>) </a></h2>
                    <ul>                   
                      <li>
                        <a href="" class="btn_delete_a" data-id="<?php echo $row['id'];?>"  data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                      </li>


                    </ul>
                  </div>
                  <span><img src="images/<?php echo $row['event_image'];?>" /></span>
                </div>
              </div>
          <?php $i++; } ?>     
      	  </div>
          </div>
          <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>
                <?php if(!isset($_POST["data_search"])){ include("pagination.php");}?>
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?> 

<script type="text/javascript">

//for category delete 
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
              data:{id:_ids,'action':'multi_delete','tbl_nm':'event_image'},
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

<script>
	//for checkall selected
  $("#checkall").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });
</script>      
     
