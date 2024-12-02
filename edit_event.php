<?php $page_title="Edit Event";

include("includes/header.php");
require("includes/function.php");
require("language/language.php");

	require_once("thumbnail_images.class.php");

  //All Category
  $cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
  $cat_result=mysqli_query($mysqli,$cat_qry);  


  if(isset($_GET['event_id']))
  {
       
      $qry="SELECT * FROM tbl_events WHERE id='".$_GET['event_id']."'";
      $result=mysqli_query($mysqli,$qry);
      $row=mysqli_fetch_assoc($result);


      $registration_str=explode('/', $row['registration_start']);

      $registration_date=$registration_str[0];
      $registration_time=$registration_str[1];

      $registration_end_str=explode('/', $row['registration_end']);

      $registration_end_date=$registration_end_str[0];
      $registration_end_time=$registration_end_str[1];

 
  }
	
	if(isset($_POST['submit']))
	{
    

      if($_FILES['event_logo']['name']!="")
      {
        if($row['event_logo']!="")
        {
          unlink('images/'.$row['event_logo']);
          unlink('images/thumbs/'.$row['event_logo']);
        }

        $event_logo=rand(0,99999)."_".$_FILES['event_logo']['name'];       
        //Main Image
        $tpath1='images/'.$event_logo;        
        $pic1=compress_image($_FILES["event_logo"]["tmp_name"], $tpath1, 80);   
        //Thumb Image 
        $thumbpath='images/thumbs/'.$event_logo;   
        $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');  
 
      }
      else
      {
        $event_logo=$_POST['event_logo_old'];
      }

      if($_FILES['event_banner']['name']!="")
      {
        if($row['event_banner']!="")
        {
          unlink('images/'.$row['event_banner']);
          unlink('images/thumbs/'.$row['event_banner']);
        }
        
        $event_banner=rand(0,99999)."_".$_FILES['event_banner']['name'];       
        //Main Image
        $tpath1='images/'.$event_banner;        
        $pic1=compress_image($_FILES["event_banner"]["tmp_name"], $tpath1, 80);   
        //Thumb Image 
        $thumbpath='images/thumbs/'.$event_banner;   
        $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'450','250');
      }
      else
      {
        $event_banner=$_POST['event_banner_old'];
      }

      $event_start_time=strtotime(str_replace(' ','',$_POST['event_start_time']));
      $event_end_time=strtotime(str_replace(' ','',$_POST['event_end_time'])); 
      if($_POST['website'] == "public")
      {
        // for registration start data and time
        $registration_date=strtotime($_POST['registration_start_date']);
        $registration_time=strtotime(str_replace(' ','',$_POST['registration_start_time']));   

        $actual_reg_from=strtotime($_POST['registration_start_date'].' '.str_replace(' ','',$_POST['registration_start_time']));   
      
        $registration_from=$registration_date.'/'.$registration_time.'/'.$actual_reg_from;

        // for registration end data and time
        $registration_date1=strtotime($_POST['registration_end_date']);
        $registration_time1=strtotime(str_replace(' ','',$_POST['registration_end_time']));     

        $actual_reg_end=strtotime($_POST['registration_end_date'].' '.str_replace(' ','',$_POST['registration_end_time'])); 
      
        $registration_end=$registration_date1.'/'.$registration_time1.'/'.$actual_reg_end;
        $event_ticket = trim($_POST['event_ticket']);
        $person_wise_ticket = trim($_POST['person_wise_ticket']);
        $ticket_price = trim($_POST['ticket_price']);
      }else{
        $registration_from = null; 
        $registration_end = null; 
        $event_ticket = 0;
        $person_wise_ticket = 0;
        $ticket_price = 0;
      }
      
      $data = array( 
         'cat_id'  =>  $_POST['cat_id'],
         'event_title'  =>  addslashes($_POST['event_title']),
         'event_description'  =>  addslashes($_POST['event_description']),
         'event_email'  =>  $_POST['event_email'],
         'event_phone'  =>  $_POST['event_phone'],
         'event_website'  =>  $_POST['event_website'],
         'website'  =>  $_POST['website'],
         'event_address'  =>  addslashes($_POST['event_address']),
         'event_map_latitude'  =>  $_POST['event_map_latitude'],
         'event_map_longitude'  =>  $_POST['event_map_longitude'], 
         'event_start_date'  =>  strtotime($_POST['event_start_date']),
         'event_start_time'  =>  $event_start_time,
         'event_end_date'  =>  strtotime($_POST['event_end_date']), 
         'event_end_time'  =>  $event_end_time,
         'registration_start'  =>  $registration_from,
         'registration_end'  =>  $registration_end,
         'event_ticket'  =>  $event_ticket,
         'person_wise_ticket'  =>  $person_wise_ticket,
         'ticket_price'  =>  $ticket_price,
         'event_logo'  =>  $event_logo,
         'event_banner'  =>  $event_banner,
         'registration_closed'  =>  $_POST['register_closed'],
         'close_open_date'  =>  strtotime(date('d-m-Y h:i:s A')), 
         'status'  =>  1         
    );

 
    $event_edit=Update('tbl_events', $data, "WHERE id = '".$_POST['event_id']."'"); 

    $last_id=$_POST['event_id'];

    $size_sum = array_sum($_FILES['event_cover']['size']);
       
    if($size_sum > 0)
    {  
      for ($i = 0; $i < count($_FILES['event_cover']['name']); $i++) 
      {

          $ext = pathinfo($_FILES['event_cover']['name'][$i], PATHINFO_EXTENSION);

          $path = "images/"; //set your folder path
          $image_file=date('dmYhis').'_'.rand(0,99999).'_'.$i.".".$ext;
           
          $tpath1=$path.$image_file;    
          if($ext!='png'){
            $pic1=compress_image($_FILES["event_cover"]["tmp_name"][$i], $tpath1, 80);
          }else{
            move_uploaded_file($_FILES['event_cover']['tmp_name'][$i], $tpath1);
          }

          $thumbpath='images/thumbs/'.$image_file;

          $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'450','250');

          $data1 = array(
              'event_id'=>$last_id,
              'image_file'  => $image_file                         
          );      

          $qry1 = Insert('tbl_event_cover',$data1); 
      }
    }

	 $_SESSION['msg']="11";
	     if(isset($_GET['redirect'])){
          header("Location:".$_GET['redirect']);
        }
        else{
		header( "Location:edit_event.php?event_id=".$_POST['event_id']);
        }
        exit; 

		
	}

  
  $ck_file_path = getBaseUrl();
	 

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<div class="row">
      <div class="col-md-12">
      	<?php if($row['user_id']!='0'){?>
      	<?php
	      if(isset($_GET['redirect'])){
	            echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
	          }
	          else{
	            echo '<a href="user_events.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
	          }
		    ?>
		<?php }else{?>
			<?php
	      if(isset($_GET['redirect'])){
	            echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
	          }
	          else{
	            echo '<a href="manage_events.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
	          }
		    ?>
		<?php  }?>
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="card-body mrg_bottom"> 
            <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
              <input  type="hidden" name="event_id" value="<?php echo $_GET['event_id'];?>" />
              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">Registration Closed :-</label>
                    <div class="col-md-6">
                      <select name="register_closed" id="register_closed" class="select2" required>
                        <option value="false" <?php if($row['registration_closed']=='false'){ echo 'selected';}?>>No</option>
                        <option value="true"<?php if($row['registration_closed']=='true'){ echo 'selected';}?>>Yes</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label">Event Title :-</label>
                    <div class="col-md-6">
                      <input type="text" name="event_title" id="event_title" value="<?php echo $row['event_title'];?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Category :-</label>
                    <div class="col-md-6">
                      <select name="cat_id" id="cat_id" class="select2" required>
                        <option value="">--Select Category--</option>
                        <?php while($cat_row=mysqli_fetch_array($cat_result)){ ?>                       
                        <option value="<?php echo $cat_row['cid'];?>" <?php if($cat_row['cid']==$row['cat_id']){?>selected<?php }?>><?php echo $cat_row['category_name'];?></option>                           
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Description :-</label>
                    <div class="col-md-6">
                      <textarea name="event_description" id="event_description" class="form-control"><?php echo $row['event_description'];?></textarea>
                     <script>
                    CKEDITOR.replace( 'event_description' ,{
                      filebrowserBrowseUrl : 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=&akey=viaviweb',
                      filebrowserUploadUrl : 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=&akey=viaviweb',
                      filebrowserImageBrowseUrl : 'filemanager/dialog.php?type=1&editor=ckeditor&fldr=&akey=viaviweb'
                    });
                  </script>
                    </div>
                  </div>
                  <div class="form-group">&nbsp;</div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Email :-</label>
                    <div class="col-md-6">
                      <input type="text" name="event_email" id="event_email" value="<?php echo $row['event_email'];?>" class="form-control" required>
                    </div>
                  </div>                 
                  <div class="form-group">
                    <label class="col-md-3 control-label">Phone :-</label>
                    <div class="col-md-6">
                      <input type="text" name="event_phone" id="event_phone" value="<?php echo $row['event_phone'];?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Website :-</label>
                    <div class="col-md-6">
                      <input type="text" name="event_website" id="event_website" value="<?php echo $row['event_website'];?>" class="form-control">
                    </div>
                  </div>                  
                  <br>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Address :-</label>
                    <div class="col-md-6">
                      <input type="text" name="event_address" id="p-address" value="<?php echo $row['event_address'];?>" class="form-control">
                    </div>
                  </div>
                  <div class="form-group" style="margin-bottom: 10px">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-6">
                      <a href="https://www.latlong.net/" target="_blank">
                        Find your latitude & longitude
                      </a>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Latitude/Longitude :-</label>
                    <div class="col-md-3">
                      <input type="text" name="event_map_latitude" id="p-lat" placeholder="Latitude" value="<?php echo $row['event_map_latitude'];?>" class="form-control">
                    </div>
					<div class="col-md-3">
                      <input type="text" name="event_map_longitude" id="p-long" placeholder="Longitude" value="<?php echo $row['event_map_longitude'];?>" class="form-control">
                    </div>
                  </div> 
                  <hr>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Event Start Date & Time :-</label>
                    <div class="col-md-3">
                      <input type="text" name="event_start_date" id="start_date" value="<?php echo date('m/d/Y',$row['event_start_date']);?>" class="form-control datepicker" autocomplete="off" readonly>
                    </div>
                    <div class="col-md-3">
                      <input type="time" class="form-control event-time-item" name="event_start_time" value="<?php echo date('H:i',$row['event_start_time']);?>">
                    </div>

                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Event End Date & Time :-</label>
                    <div class="col-md-3">
                      <input type="text" name="event_end_date" id="end_date" value="<?php echo date('m/d/Y',$row['event_end_date']);?>" class="form-control" autocomplete="off" readonly>
                    </div>
                    <div class="col-md-3">
                      <input type="time" class="form-control event-time-item" name="event_end_time" value="<?php echo date('H:i',$row['event_end_time']);?>">
                    </div>
                  </div>
                    
                  <div class="form-group">
                    <label class="col-md-3 control-label">Event Type :-</label>
                    <div class="col-md-6">
                      <select name="website" id="website" class="select2" required>
                        <option value="">--Select Type--</option>
                        <option <?php if($row['website']=='public'){?>selected<?php }?> value="public">Public</option>
                        <option <?php if($row['website']=='private'){?>selected<?php }?> value="private">Private</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group private_fields" <?php if($row['website']=='private'){?>hidden<?php }?>>
                    <label class="col-md-3 control-label">Event Max. Tickets :-
                      <p class="control-label-help">(Total no. of tickets)</p>
                    </label>
                    <div class="col-md-6">
                      <input type="text" name="event_ticket" id="event_ticket" value="<?php echo $row['event_ticket'];?>" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                  </div>
                  <div class="form-group private_fields" <?php if($row['website']=='private'){?>hidden<?php }?>>
                    <label class="col-md-3 control-label">Person Wise Tickets :-
                      <p class="control-label-help">(Total no. of tickets person can buy at a time)</p>
                    </label>
                    <div class="col-md-6">
                      <input type="text" name="person_wise_ticket" id="person_wise_ticket" value="<?php echo $row['person_wise_ticket'];?>" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                  </div>
                  <div class="form-group private_fields" <?php if($row['website']=='private'){?>hidden<?php }?>>
                    <label class="col-md-3 control-label">Ticket Price (Rs.) :-</label>
                    <div class="col-md-6">
                      <input type="text" name="ticket_price" id="ticket_price" value="<?php echo $row['ticket_price'];?>" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                  </div>

                  <div class="form-group private_fields" <?php if($row['website']=='private'){?>hidden<?php }?>>
                    <label class="col-md-3 control-label">Registration Start Date & Time :-</label>
                    <div class="col-md-3">
                      <input type="text" name="registration_start_date" id="registration_start_date" value="<?php echo date('m/d/Y',$registration_date);?>" class="form-control" autocomplete="off" readonly>
                    </div>
                    <div class="col-md-3">
                      <input type="time" class="form-control event-time-item" name="registration_start_time" value="<?php echo date('H:i',$registration_time);?>">
                    </div>
                  </div>
                  <div class="form-group private_fields" <?php if($row['website']=='private'){?>hidden<?php }?>>
                    <label class="col-md-3 control-label">Registration End Date & Time :-</label>
                    <div class="col-md-3">
                      <input type="text" name="registration_end_date" id="registration_end_date" value="<?php echo date('m/d/Y',$registration_end_date);?>" class="form-control" autocomplete="off" readonly>
                    </div>
                    <div class="col-md-3">
                      <input type="time" class="form-control event-time-item" name="registration_end_time" value="<?php echo date('H:i',$registration_end_time);?>">
                    </div>
                  </div>
                  
                  <hr>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Event Logo :-
                      <p class="control-label-help">(Recommended resolution: 300x300)</p>
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="event_logo" value="" id="fileupload" onchange="readURLLogo(this)">
                          <?php if(isset($_GET['event_id']) and $row['event_logo']!="") {?>
                            <input type="hidden" name="event_logo_old" value="<?php echo $row['event_logo'];?>">
                            <div class="fileupload_img"><img type="image" id="event_logo" src="images/<?php echo $row['event_logo'];?>" alt="Logo image" style="width: 90px;height: 90px"/></div>
                          <?php }else{
                            ?>
                            <div class="fileupload_img"><img id="event_logo" type="image" src="assets/images/landscape.jpg" alt="Logo image" /></div>
                          <?php } ?>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Event Banner :-
                      <p class="control-label-help">(Recommended resolution: 1200x450)</p>
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="event_banner" value="" id="fileupload"  onchange="readURLBaner(this)">
                          <?php if(isset($_GET['event_id']) and $row['event_banner']!="") {?>
                            <input type="hidden" name="event_banner_old" value="<?php echo $row['event_banner'];?>">
                            <div class="fileupload_img"><img id="event_banner" type="image" src="images/<?php echo $row['event_banner'];?>" alt="Banner image"  style="width: 180px;height: 90px"/></div>
                          <?php }else{
                            ?>
                            <div class="fileupload_img"><img id="event_banner" type="image" src="assets/images/landscape.jpg" alt="Banner image" /></div>
                            <?php } ?>
                      </div>
                    </div>
                  </div> 
                  <hr>
            
                   <div class="form-group" id="image_news">
                    <label class="col-md-3 control-label">Gallery Image :-<p class="control-label-help">(Recommended resolution: 600x400 OR width greater than height)</p></label>
                    <div class="col-md-6">
                      <div class="fileupload_block fileupload_gallery">
                        <div class="col-md-12" style="padding-left: 0px;display:inline-block;margin-bottom:15px;">
                          <input type="file" name="event_cover[]" value="" accept=".png, .jpg, .jpeg, .svg, .gif" id="fileupload" multiple>
                        </div>
						<div class="row">
						  <?php 
							$sql_img="SELECT * FROM tbl_event_cover WHERE event_id='".$_GET['event_id']."'";
							$result1=mysqli_query($mysqli, $sql_img);
							while ($row_img=mysqli_fetch_array($result1)) {?>
							  <div class="col-4 col-lg-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
								<img src="images/<?php echo $row_img['image_file'];?>" class="img-responsive">
								<a href="javascript:void(0)" class="remove_img" data-id="<?php echo $row_img['id'];?>" data-img="<?php echo $row_img['image_file'];?>"><i class="fa fa-close"></i></a>
							  </div>
							<?php }?>
						</div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

        
<?php include("includes/footer.php");?>  

<script type="text/javascript">
  $("#start_date, #end_date, #registration_start_date, #registration_end_date").datepicker({minDate: 0});

  function readURLLogo(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#event_logo').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

    function readURLBaner(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#event_banner').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

   $(".remove_img").click(function(e){
      e.preventDefault();

      var _id=$(this).data("id");
      var _img=$(this).data("img");

      var element=$(this).parent("div");

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
              data:{'id':_id,'img':_img,'action':'remove_gallery_img'},
              success:function(res){
                swal.close();
                element.remove();
                $('.notifyjs-corner').empty();
                $.notify(
                res.msg,
                { position:"top center",className: 'success'}
                );
              }
            });
          }
          else{
            swal.close();
          }
      });
    });
    
  $("select[name='website']").on("change",function(e){
    var type=$(this).val();
    switch (type) {
      case 'private':
        {
          $(".private_fields").hide();
          $(".private_fields").find("input").attr("required",false);
        }
        break;

     

      case 'public':
        {
          $(".private_fields").show();
          $(".private_fields").find("input").attr("required",true);
        }
        break;
    }


  });
</script>
