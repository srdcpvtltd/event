<?php $page_title="Manage Events Booking";

  include('includes/header.php'); 
  include('includes/function.php');
  include('language/language.php');  

  if(isset($_POST['event_search']))
  {

      $search=addslashes(trim($_POST['search_value']));

      $sql="SELECT tbl_event_booking.*, tbl_events.`event_title` FROM tbl_event_booking
            LEFT JOIN tbl_events ON tbl_event_booking.`event_id`=tbl_events.`id`
            WHERE tbl_events.`event_title` LIKE '%$search%'
            GROUP BY tbl_event_booking.`event_id`
            ORDER BY tbl_event_booking.`id` DESC"; 
             
      $result=mysqli_query($mysqli,$sql);


  }
  else if(isset($_GET['event_id'])){

    $event_id=trim($_GET['event_id']);

    $tableName="tbl_event_booking";   
    $targetpage = "event_booking.php?event_id=".$event_id;  
    $limit = 15; 

    $query = "SELECT * FROM $tableName WHERE `event_id`='$event_id' GROUP BY `event_id`";
    $res = mysqli_query($mysqli,$query);
    $total_pages = mysqli_num_rows($res);

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
          GROUP BY tbl_event_booking.`event_id`
          ORDER BY tbl_event_booking.`id` DESC LIMIT $start, $limit";  

    $result=mysqli_query($mysqli,$sql);

  }
  else{

      $tableName="tbl_event_booking";   
      $targetpage = "event_booking.php";  
      $limit = 15; 

      $query = "SELECT * FROM $tableName GROUP BY `event_id`";
      $res = mysqli_query($mysqli,$query);
      $total_pages = mysqli_num_rows($res);

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
            GROUP BY tbl_event_booking.`event_id`
            ORDER BY tbl_event_booking.`id` DESC LIMIT $start, $limit";  

      $result=mysqli_query($mysqli,$sql);

  }

  function get_total_booking($event_id)
  { 
    global $mysqli;   

    $sql="SELECT SUM(`total_ticket`) as num FROM tbl_event_booking WHERE event_id='".$event_id."'";
     
    $total_item = mysqli_fetch_array(mysqli_query($mysqli,$sql));
    $total_item = $total_item['num'];
     
    return $total_item;

  }

  function get_last_update($event_id) 
  {
    global $mysqli; 

    $sql="SELECT created_at FROM tbl_event_booking WHERE event_id='".$event_id."' ORDER BY id DESC";
     
    $row = mysqli_fetch_array(mysqli_query($mysqli,$sql));
    return date('d-m-Y',$row['created_at']);
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
            <div class="col-md-4">
                <select name="event_id" class="form-control event_id select2" style="padding: 5px 10px;height: 40px;">
                  <option value="">All Events</option>
                  <?php
                    $sql="SELECT * FROM tbl_events WHERE `status`='1' ORDER BY `event_title`";
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
                  <th>Event</th>		
                  <th>Nos. booking</th>    
                  <th>Last Update</th>	 
                  <th class="cat_action_list">Action</th>
                </tr>
              </thead>
              <tbody>
              	<?php
                  if(mysqli_num_rows($result) > 0)
                  {
  						$i=1;
  						while($row=mysqli_fetch_array($result))
  						{	 
      		     ?>
                <tr> 
                  <td>  
                    <div>
                        <div class="checkbox" id="checkbox_contact">
                          <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $row['id']; ?>" class="post_ids">
                            <label for="checkbox<?php echo $i;?>">
                          </label>
                        </div>
                    </div>
                  </td>
		              <td><?php echo $row['event_title'];?></td>   
		              <td><?php echo get_total_booking($row['event_id']);?></td>
                  <td><?php echo get_last_update($row['event_id']);?></td>
                  <td>
                    <a href="booking_list.php?event_id=<?=$row['event_id']?>" data-id="<?php echo $users_row['id'];?>" class="btn btn-success btn_edit" data-toggle="tooltip" data-tooltip="View"><i class=" fa fa-eye"></i></a>
                    <a href="download_register.php?event_id=<?=$row['event_id']?>" class="btn btn-primary btn_cust" data-toggle="tooltip" data-tooltip="Excelsheet">
                      <i class="fa fa-file-excel-o"></i>
                    </a>
                    <a href="javascript:void(0)" data-id="<?php echo $row['event_id'];?>" class="btn btn-danger btn_delete" data-toggle="tooltip" data-tooltip="Delete !"><i class=" fa fa-trash"></i></a>
                  </td>
                </tr>
               <?php $i++;
                  }
        		} // end of if
                else{
                  ?>
                  <tr>
                    <td colspan="5" class="text-center">
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

<?php include('includes/footer.php');?>                  

<script type="text/javascript">
 
  $("select[name='event_id']").on("change",function(e){

    var params = new window.URLSearchParams(window.location.search);
    if(params.get('page')!=null){

      if($(this).val()!='')
      {
        window.location.href="event_booking.php?event_id="+$(this).val()+'&page='+params.get('page');
      }else{
        window.location.href="event_booking.php?page="+params.get('page');
      }        
    }
    else{
      if($(this).val()!='')
      {
        window.location.href="event_booking.php?event_id="+$(this).val();
      }else{
        window.location.href="event_booking.php";
      }
    }

  });

//for event booking delete
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
          data:{'id':_id,'tbl_nm':_table,'tbl_id':'event_id','action':'removeData'},
          success:function(res){
            location.reload();
          }
        });
          } 
        }
      });
      confirmDlg.show();
    });

//for multiple event booking delete
$(".btn_delete_all").click(function(e){
	e.preventDefault();

	var _ids = $.map($('.post_ids:checked'), function(c){return c.value; });
	
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
			
			$.ajax({
				type:'post',
				url:'processData.php',
				dataType:'json',
				data:{id:_ids,'action':'multi_delete','tbl_nm':'tbl_event_booking'},
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


</script>

