<?php 
  
  $page_title='Edit Slider';
  include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");

  if(isset($_GET['edit_id']))
  {
       
      $qry="SELECT * FROM tbl_slider WHERE id='".$_GET['edit_id']."'";
      $result=mysqli_query($mysqli,$qry);
      $row_data=mysqli_fetch_assoc($result);
  }

  if(isset($_POST['submit']) and isset($_POST['edit_id']))
  {
    
    $slider_type=trim($_POST['slider_type']);

    $slider_title=$slider_file=$external_url='';

    if($slider_type=='external'){

        if($_FILES['slider_file']['name']!="")
        {

          unlink('images/'.$row_data['external_image']);

          $ext = pathinfo($_FILES['slider_file']['name'], PATHINFO_EXTENSION);

          $slider_file=rand(0,99999)."_slider.".$ext;

          //Main Image
          $tpath1='images/'.$slider_file;   

          if($ext!='png')  {
            $pic1=compress_image($_FILES["slider_file"]["tmp_name"], $tpath1, 80);
          }
          else{
            $tmp = $_FILES['slider_file']['tmp_name'];
            move_uploaded_file($tmp, $tpath1);
          }
        }
        else
        {
          $slider_file=$row_data['external_image'];
        }

        $event_id=0;
        $slider_title=addslashes(trim($_POST['slider_title']));
        $external_url=addslashes(trim($_POST['external_url']));
    }
    else{

        switch ($slider_type) {
          case 'Event':
              $event_id=$_POST['event_id'];
            break;

         
          default:
            break;
        }

    }

    if($event_id!=0){
      $sql="SELECT * FROM tbl_slider WHERE `event_id`='$event_id' AND `slider_type`='$slider_type' AND `status`='1' AND `id` <> '".$_GET['edit_id']."'";
      $res=mysqli_query($mysqli, $sql);
      if($res->num_rows > 0){
        $_SESSION['msg']='This '.ucwords($slider_type)." is already exists !!";
        header( "Location:add_slider.php?add");
        exit;
      }
    }
    
    $data = array(
       'event_id' =>  $event_id,
       'slider_type' =>  $slider_type,
       'slider_title' =>  $slider_title,
       'external_url' =>  $external_url,
       'external_image' =>  $slider_file
    ); 

    $edit=Update('tbl_slider', $data, "WHERE id = '".$_POST['edit_id']."'");
    
 	$_SESSION['msg']="11";
     if(isset($_GET['redirect'])){
      header("Location:".$_GET['redirect']);
    }
    else{
	header( "Location:edit_slider.php?edit_id=".$_POST['edit_id']);
    }
    exit; 
  }

?>

<!-- For Font Family -->
<link rel="stylesheet" type="text/css" href="assets/css/quotes_fonts.css">
<!-- End -->

<div class="row">
      <div class="col-md-12">
      	<?php
		      if(isset($_GET['redirect'])){
		            echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
		          }
		          else{
		            echo '<a href="manage_slider.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
		          }?>
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="card-body mrg_bottom"> 
            <form action="" name="addeditlanguage" method="post" class="form form-horizontal" enctype="multipart/form-data">
              <input type="hidden" name="edit_id" value="<?php echo $_GET['edit_id'];?>" />
              <input type="hidden" class="is_image" value="<?php if($row_data['slider_type']=='external' AND file_exists('images/'.$row_data['external_image'])){ echo 'true'; }else{ echo 'false'; } ?>" />
              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">Type :-</label>
                    <div class="col-md-6">
                      <select class="select2" required="" name="slider_type">
                        <option value="Event" <?=($row_data['slider_type']=='Event') ? 'selected' : ''?>>Events</option>
                        <option value="external" <?=($row_data['slider_type']=='external') ? 'selected' : ''?>>External Banner</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group video_status">
                    <label class="col-md-3 control-label" for="event_id">Events :-</label>
                    <div class="col-md-6">
                      <select name="event_id" id="event_id" class="select2" required="">
                        <option value="">--Select Events--</option>
                        <?php
                          $sql="SELECT * FROM tbl_events WHERE tbl_events.`status`='1' ORDER BY tbl_events.`id` DESC";
                          $res=mysqli_query($mysqli, $sql);
                          while($row=mysqli_fetch_assoc($res))
                          {
                           
                        ?>
                           <option data-url="images/<?php echo $row['event_banner'];?>" value="<?php echo $row['id'];?>" <?=($row_data['event_id']==$row['id']) ? 'selected' : ''?>><?php echo $row['event_title'];?></option>                          
                        <?php
                          }
                          mysqli_free_result($res);
                        ?>
                      </select>
                      <div class="row">
						<div class="col-md-8">
							<img class="preview" src="" width="100%" height="auto" style="width: 250px;height: 150px;box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);border-radius: 6px;object-fit: cover;display: none;margin-bottom: 20px" />
						</div>
					  </div>
                    </div>
                  </div>
                  <div class="external_banner" style="display: none;">
                    <div class="form-group">
                      <label class="col-md-3 control-label">Title :-</label>
                      <div class="col-md-6">
                        <input type="text" name="slider_title" placeholder="Enter title" id="slider_title" value="<?php echo $row_data['slider_title'];?>" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="external_url">External URL :-</label>
                      <div class="col-md-6">
                        <input type="text" name="external_url" placeholder="Enter external url" id="external_url" value="<?php echo $row_data['external_url'];?>" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label">Select Image :-
                        <p class="control-label-help">(Recommended resolution: Landscape: 500x280</p>
                      </label>
                      <div class="col-md-6">
                        <div class="fileupload_block">
                          <input type="file" name="slider_file" value="fileupload" id="fileupload" accept=".png, .jpg, .jpeg">
                          <?php if(isset($_GET['edit_id']) and $row_data['external_image']!="") {?>
                           <div class="fileupload_img" id="uploadPreview"><img type="image" src="images/<?php echo $row_data['external_image']?>" style="width: 200px;height: 100px;"/></div>
                          <?php }else{?>
                          	 <div id="uploadPreview" class="fileupload_img"><img type="image" src="assets/images/landscape.jpg" style="width: 200px;height: 100px;" alt="image alt"/></div>
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
 var type=$("select[name='slider_type']").val();

  $(".video_status").find("select").attr("required",false);
  $(".image_status").find("select").attr("required",false);
  $(".gif_status").find("select").attr("required",false);
  $(".quote_status").find("select").attr("required",false);
  $(".external_banner").find("input").attr("required",false);

  switch (type) {
    case 'Book':
      {
        $(".video_status").show();
        $(".video_status").find("select").attr("required",true);
        $(".image_status").hide();
        $(".gif_status").hide();
        $(".quote_status").hide();
        $(".external_banner").hide();
      }
      break;

    case 'image':
      {

        $(".image_status").show();
        $(".image_status").find("select").attr("required",true);
        $(".video_status").hide();
        $(".gif_status").hide();
        $(".quote_status").hide();
        $(".external_banner").hide();

      }
      break;

    case 'gif':
      {
        $(".gif_status").show();
        $(".gif_status").find("select").attr("required",true);
        $(".video_status").hide();
        $(".image_status").hide();
        $(".quote_status").hide();
        $(".external_banner").hide();
      }
      break;

    case 'quote':
      {
        $(".quote_status").show();
        $(".quote_status").find("select").attr("required",true);
        $(".video_status").hide();
        $(".image_status").hide();
        $(".gif_status").hide();
        $(".external_banner").hide();
      }
      break;

    case 'external':
      {
        $(".external_banner").show();
        if($(".is_image").val()=='false')
          $(".external_banner").find("input").attr("required",true);
        $(".video_status").hide();
        $(".image_status").hide();
        $(".gif_status").hide();
        $(".quote_status").hide();

      }
      break;
  }

  $("select[name='slider_type']").on("change",function(e){
    var type=$(this).val();

    $(".video_status").find("select").attr("required",false);
    $(".image_status").find("select").attr("required",false);
    $(".gif_status").find("select").attr("required",false);
    $(".quote_status").find("select").attr("required",false);
    $(".external_banner").find("input").attr("required",false);

    $(".preview").hide();

    switch (type) {
      case 'Events':
        {
          $(".video_status").show();
          $(".video_status").find("select").attr("required",true);
          $(".image_status").hide();
          $(".gif_status").hide();
          $(".quote_status").hide();
          $(".external_banner").hide();
        }
        break;

      case 'image':
        {

          $(".image_status").show();
          $(".image_status").find("select").attr("required",true);
          $(".video_status").hide();
          $(".gif_status").hide();
          $(".quote_status").hide();
          $(".external_banner").hide();

        }
        break;

      case 'gif':
        {
          $(".gif_status").show();
          $(".gif_status").find("select").attr("required",true);
          $(".video_status").hide();
          $(".image_status").hide();
          $(".quote_status").hide();
          $(".external_banner").hide();
        }
        break;

      case 'quote':
        {
          $(".quote_status").show();
          $(".quote_status").find("select").attr("required",true);
          $(".video_status").hide();
          $(".image_status").hide();
          $(".gif_status").hide();
          $(".external_banner").hide();
        }
        break;

      case 'external':
        {
          $(".external_banner").show();
          if($(".is_image").val()=='false')
            $(".external_banner").find("input").attr("required",true);
          $(".video_status").hide();
          $(".image_status").hide();
          $(".gif_status").hide();
          $(".quote_status").hide();

        }
        break;
    }


  });

  var url=$("select[name='event_id']").children("option:selected").data("url");
  $("select[name='event_id']").parent("div").find(".preview").attr('src',url);
  $("select[name='event_id']").parent("div").find(".preview").show();

  $("select[name='event_id']").on("change",function(e){
    var url=$(this).children("option:selected").data("url");
    $(this).parent("div").find(".preview").attr('src',url);
    $(this).parent("div").find(".preview").show();
  });


  var url=$("select[name='image_id']").children("option:selected").data("url");
  $("select[name='image_id']").parent("div").find(".preview").attr('src',url);
  $("select[name='image_id']").parent("div").find(".preview").show();

  $("select[name='image_id']").on("change",function(e){
    var url=$(this).children("option:selected").data("url");
    $(this).parent("div").find(".preview").attr('src',url);
    $(this).parent("div").find(".preview").show();
  });

  var url=$("select[name='gif_id']").children("option:selected").data("url");
  $("select[name='gif_id']").parent("div").find(".preview").attr('src',url);
  $("select[name='gif_id']").parent("div").find(".preview").show();

  $("select[name='gif_id']").on("change",function(e){
    var url=$(this).children("option:selected").data("url");
    $(this).parent("div").find(".preview").attr('src',url);
    $(this).parent("div").find(".preview").show();
  });

  // for quotes

  var quote=$("select[name='quote_id']").children("option:selected").text();
  var bg=$("select[name='quote_id']").children("option:selected").data("bg");
  var font=$("select[name='quote_id']").children("option:selected").data("font");

  $("select[name='quote_id']").parent("div").find(".preview").css({"color":"#FFF","font-family":font,"background-color":bg});
  $("select[name='quote_id']").parent("div").find(".preview span").text(quote);
  $("select[name='quote_id']").parent("div").find(".preview").show();


  $("select[name='quote_id']").on("change",function(e){
    var quote=$(this).children("option:selected").text();
    var bg=$(this).children("option:selected").data("bg");
    var font=$(this).children("option:selected").data("font");

    $(this).parent("div").find(".preview").css({"color":"#FFF","font-family":font,"background-color":bg});
    $(this).parent("div").find(".preview span").text(quote);
    $(this).parent("div").find(".preview").show();
  });




  var _URL = window.URL || window.webkitURL;

  $("#fileupload").change(function(e) {
      var file, img;
      var thisFile=$(this);

      var countCheck=0;
      
      if ((file = this.files[0])) {
          img = new Image();
          img.onload = function() {
              if(this.width < this.height){
                alert("Image width must be greater than image height !");
                thisFile.val('');
                $('#uploadPreview').html('');
                return false;
              }
              else if(this.width == this.height){
                alert("Image width must not equal to image height !");
                thisFile.val('');
                $('#uploadPreview').html('');
                return false;
              }
              
          };
          img.onerror = function() {
              alert( "not a valid file: " + file.type);
          };

          img.src = _URL.createObjectURL(file);
          
          $('#uploadPreview').html('<img src="'+img.src+'" style="width:180px;height:90px;"/>');

      }

  });

</script>