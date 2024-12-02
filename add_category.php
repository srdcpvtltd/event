<?php if(isset($_GET['cat_id'])){ 
		$page_title= 'Edit Category';
	}
	else{ 
		$page_title='Add Category'; 
	}

include("includes/header.php");

require("includes/function.php");
require("language/language.php");

require_once("thumbnail_images.class.php");

  // Get add category
if(isset($_POST['submit']) and isset($_GET['add']))
  {

    $app_bg_color_rgba='#'.$_POST['bg_color_rgba'];
    
    $category_image=rand(0,99999)."_".$_FILES['category_image']['name'];
    $pic1=$_FILES['category_image']['tmp_name'];  

    $tpath1='images/'.$category_image; 
    copy($pic1,$tpath1);

    $category_icon=rand(0,99999)."_bg__".$_FILES['category_icon']['name'];
    $pic1=$_FILES['category_icon']['tmp_name'];  
    
    $tpath1='images/'.$category_icon; 
    copy($pic1,$tpath1);

    $data = array( 
        'category_name'  =>  $_POST['category_name'],
        'category_image'  =>  $category_image,
        'category_icon'  =>  $category_icon,
        'bg_color_rgba'  =>  $_POST['category_bg_color'],
        'app_bg_color_rgba'  =>  $app_bg_color_rgba
    );    

    $qry = Insert('tbl_category',$data);  

    $_SESSION['msg']="10";
    header( "Location:manage_category.php");
    exit; 

  }
  
  // Select category
  if(isset($_GET['cat_id']))
  {
       
      $qry="SELECT * FROM tbl_category WHERE `cid`='".$_GET['cat_id']."'";
      $result=mysqli_query($mysqli,$qry);
      $row=mysqli_fetch_assoc($result);

  }
  // Get update category
  if(isset($_POST['submit']) and isset($_POST['cat_id']))
  {

    $category_image=$category_icon='';

    if($_FILES['category_image']['name']!="")
    {
        if($row['category_image']!="")
        {
            unlink('images/thumbs/'.$row['category_image']);
            unlink('images/'.$row['category_image']);
        }

        $category_image=rand(0,99999)."_".$_FILES['category_image']['name'];

        //Main Image
        $category_image=rand(0,99999)."_".$_FILES['category_image']['name'];
        $pic1=$_FILES['category_image']['tmp_name'];  
        //Main Image         
        $tpath1='images/'.$category_image; 
        copy($pic1,$tpath1);
    }
    else{
         $category_image=$row['category_image']; 
    }

    if($_FILES['category_icon']['name']!="")
    {
        if($row['category_icon']!="")
        {
            unlink('images/'.$row['category_icon']);
        }

        $category_icon=rand(0,99999)."_".$_FILES['category_icon']['name'];

        //Main Image
        $category_icon=rand(0,99999)."_".$_FILES['category_icon']['name'];
        $pic1=$_FILES['category_icon']['tmp_name'];  
        //Main Image         
        $tpath1='images/'.$category_icon; 
        copy($pic1,$tpath1);
    }
    else{
         $category_icon=$row['category_icon']; 
    }

    $app_bg_color_rgba='#'.$_POST['bg_color_rgba'];

    $data = array( 
      'category_name'  =>  $_POST['category_name'],
      'category_image'  =>  $category_image,
      'category_icon'  =>  $category_icon,
      'bg_color_rgba'  =>  $_POST['category_bg_color'],
      'app_bg_color_rgba'  =>  $app_bg_color_rgba
    ); 

    $category_edit=Update('tbl_category', $data, "WHERE cid = '".$_POST['cat_id']."'");
    
    $_SESSION['msg']="11";
     if(isset($_GET['redirect'])){
      header("Location:".$_GET['redirect']);
    }
    else{
	header( "Location:add_category.php?cat_id=".$_POST['cat_id']);
    }
    exit; 
 
  }

?>
<style type="text/css">

  .minicolors-theme-default .minicolors-input {
      height: 48px !important;
      width: auto;
      display: inline-block;
      padding-left: 40px !important;
  }

  .minicolors-theme-default .minicolors-swatch {
      top: 9px !important;
      left: 5px !important;
      width: 30px !important;
      height: 30px !important;
  }
  .minicolors-theme-default.minicolors{
		width:100% !important;  
  }
</style>

<div class="row">
      <div class="col-md-12">
      	<?php
      	if(isset($_SERVER['HTTP_REFERER']))
      	{
      		echo '<a href="'.$_SERVER['HTTP_REFERER'].'"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
      	}
      	?>
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="card-body mrg_bottom"> 
            <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
              <input  type="hidden" name="cat_id" value="<?php echo $_GET['cat_id'];?>" />

              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">Category Name :-
                    </label>
                    <div class="col-md-6">
                      <input type="text" name="category_name" id="category_name" value="<?php if(isset($_GET['cat_id'])){echo $row['category_name'];}?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Select Icon Image :-
                      <p class="control-label-help" style="color: red">(Recommended resolution: 64x64 And Image must having transparent background)</p>
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="category_icon" value="fileupload" id="fileupload" onchange="readURLIcone(this);">
                            <?php if(isset($_GET['cat_id']) and $row['category_icon']!="") {?>
                              <div class="fileupload_img"><img type="image" id="category_icone" src="images/<?php echo $row['category_icon'];?>" style="height: 60px;width: 60px" alt="story image" /></div>

                            <?php }else{
                              ?>
                              <div class="fileupload_img"><img type="image" id="category_icone" src="assets/images/landscape.jpg" alt="category image" style="height: 60px;width: 60px" /></div>
                              <?php
                            } ?>
                      </div>
                      
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Select Background Image :-
                      <p class="control-label-help" style="color: red">(Recommended resolution: 200x200)</p>
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="category_image" accept=".png" value="fileupload" id="fileupload" onchange="readURL(this);">
                            <?php if(isset($_GET['cat_id']) and $row['category_image']!="") {?>
                              <div class="fileupload_img"><img type="image" src="images/<?php echo $row['category_image'];?>" style="height: 90px;width: 90px" alt="story image" /></div>

                            <?php }else{
                              ?>
                              <div class="fileupload_img"><img type="image" src="assets/images/landscape.jpg" style="height: 90px;width: 90px" alt="category image" /></div>
                              <?php
                            } ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Select Background Color :-
                    
                    </label>
                    <div class="col-md-6">
                      <input type="text" name="category_bg_color" id="category_bg_color" value="<?php if(isset($_GET['cat_id'])){echo $row['bg_color_rgba'];}?>" class="form-control" required style="width:100% !important">

                    </div>
                  </div>
                  <input type="hidden" name="bg_color_rgba" id="bg_color_rgba" value="">
                  <br/>
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

<!-- MiniColors -->
<script src="assets/colorpicker/jquery.minicolors.js"></script>
<link rel="stylesheet" href="assets/colorpicker/jquery.minicolors.css">

<script type="text/javascript">

  function rgba2hex(orig) {
    var a, isPercent,
      rgb = orig.replace(/\s/g, '').match(/^rgba?\((\d+),(\d+),(\d+),?([^,\s)]+)?/i),
      alpha = (rgb && rgb[4] || "").trim(),
      hex = rgb ?
      (rgb[1] | 1 << 8).toString(16).slice(1) +
      (rgb[2] | 1 << 8).toString(16).slice(1) +
      (rgb[3] | 1 << 8).toString(16).slice(1) : orig;

    if (alpha !== "") {
      a = alpha;
    } else {
      a = 01;
    }
    // multiply before convert to HEX
    a = ((a * 255) | 1 << 8).toString(16).slice(1)
    hex = a + hex;

    return hex;
  }

  function test(colorcode) {
    return rgba2hex(colorcode);
  }

  $("#bg_color_rgba").val(test($("#category_bg_color").val()));

  $("#category_bg_color").minicolors({
    opacity:true,
    format: 'rgb' || 'hex',
    theme: 'default',
    change: function(value, opacity) {
      $("#bg_color_rgba").val(test(value));
    }
  });

// Preview category image
function readURL(input) {
if (input.files && input.files[0]) {
  var reader = new FileReader();
  
  reader.onload = function(e) {
    $("input[name='category_image']").next(".fileupload_img").find("img").attr('src', e.target.result);
  }
  reader.readAsDataURL(input.files[0]);
}
}
$("input[name='category_image']").change(function() { 
readURL(this);
});

// Preview category icone
function readURLIcone(input) {
if (input.files && input.files[0]) {
  var reader = new FileReader();

  reader.onload = function(e) {
    $('#category_icone').attr('src', e.target.result);
  }

  reader.readAsDataURL(input.files[0]);
}
}

</script>