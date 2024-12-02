<?php $page_title="Booking List";

  include('includes/header.php'); 
  include('includes/function.php');
  include('language/language.php'); 

  $event_id=$_GET['event_id'];
  
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

  function get_total_booking($event_id)
  { 
    global $mysqli;   

    $sql="SELECT SUM(`total_ticket`) as num FROM tbl_event_booking WHERE event_id='".$event_id."'";
     
    $total_item = mysqli_fetch_array(mysqli_query($mysqli,$sql));
    $total_item = $total_item['num'];
     
    return $total_item;

  }


  if(isset($_POST['event_search']))
  {

      $search=addslashes(trim($_POST['search_value']));

      $sql="SELECT tbl_event_booking.*, tbl_events.`event_title` FROM tbl_event_booking
            LEFT JOIN tbl_events ON tbl_event_booking.`event_id`=tbl_events.`id`
            WHERE (tbl_event_booking.`ticket_no` LIKE '%$search%' OR tbl_event_booking.`user_name` LIKE '%$search%' OR tbl_event_booking.`user_email` LIKE '%$search%' OR tbl_event_booking.`user_phone` LIKE '%$search%') AND tbl_event_booking.`id`='$event_id'
            ORDER BY tbl_event_booking.`id` DESC"; 
             
      $result=mysqli_query($mysqli,$sql);


  }
  else{

      $tableName="tbl_event_booking";   
      $targetpage = "event_booking.php";  
      $limit = 15; 

      $query = "SELECT COUNT(*) as num FROM $tableName WHERE tbl_event_booking.`event_id`='$event_id'";
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

      $sql="SELECT tbl_event_booking.*, tbl_events.`event_title` FROM tbl_event_booking
            LEFT JOIN tbl_events ON tbl_event_booking.`event_id`=tbl_events.`id`
            WHERE tbl_event_booking.`event_id`='$event_id'
            ORDER BY tbl_event_booking.`id` DESC LIMIT $start, $limit";  

      $result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
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
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=get_event_info($_GET['event_id'],'event_title')?></div>
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
            <div class="col-md-8">
              <p style="font-weight: 500;font-size: 16px">Total Tickets: <span style="font-weight: 600"><?=get_event_info($_GET['event_id'],'event_ticket')?></span> &nbsp; | &nbsp; Booked Tickets: <span style="font-weight: 600"><?=get_total_booking($_GET['event_id']);?></span> &nbsp; | &nbsp; Remain Tickets: <span style="font-weight: 600"><?=get_event_info($_GET['event_id'],'event_ticket')-get_total_booking($_GET['event_id']);?></span></p>
            </div>

          </div>
          <div class="clearfix"></div>
          <div class="col-md-12 mrg-top">
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr> 
                  <th>Ticket No.</th>   
                  <th>Name</th>		
                  <th>Email</th>
                  <th>Phone</th>    
                  <th>Tickets</th>    
                  <th>Booked By</th>    
                  <th>Date</th>	 
                  <th class="cat_action_list">Action</th>
                </tr>
              </thead>
              <tbody>
              	<?php
      				while($row=mysqli_fetch_array($result)){?>
                <tr> 
		           <td><?php echo $row['ticket_no'];?></td>
                  <td><?php echo $row['user_name'];?></td>   
                  <td><?php echo $row['user_email'];?></td>   
                  <td><?php echo $row['user_phone'];?></td>   
                  <td><?php echo $row['total_ticket'];?></td>   
		              <td><?php echo get_user_info($row['user_id'],'name');?></td>
                  <td nowrap=""><?php echo date('d-m-Y',$row['created_at']);?></td>
                  <td>
                    <a href="ticket.php?id=<?php echo $row['id'];?>" target="_blank" class="btn btn-success btn_edit btn_ticket" data-toggle="tooltip" data-tooltip="Ticket"><i class="fa fa-ticket"></i></a>

                    <a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn_delete btn_delete_a" data-toggle="tooltip" data-tooltip="Delete !"><i class=" fa fa-trash"></i></a>
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


<?php include('includes/footer.php');?>

<script type="text/javascript">

  $(".btn_delete").click(function(e){
      e.preventDefault();

      var _id=$(this).data("id");
      var _table='tbl_event_booking';


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
              data:{'id':_id,'tbl_nm':_table,'tbl_id':'id','action':'removeData'},
              success:function(res){
                  if(res.status=='1'){
                    swal({
                        title: "Successfully", 
                        text: "Ticket is deleted...", 
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