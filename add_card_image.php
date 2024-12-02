<?php if(isset($_GET['card_image_id'])){ 
		$page_title= 'Edit Card Image';
	}
	else{ 
		$page_title='Add Card Image'; 
	}

include("includes/header.php");

require("includes/function.php");
require("language/language.php");

require_once("thumbnail_images.class.php");

//All Category
$cat_qry="SELECT * FROM tbl_category ORDER BY `category_name`";
$cat_result=mysqli_query($mysqli,$cat_qry);  
  // Get add category
if(isset($_POST['submit']) and isset($_GET['add']))
  {    
    $card_image=rand(0,99999)."_".$_FILES['card_image']['name'];
    $pic1=$_FILES['card_image']['tmp_name'];  

    $tpath1='images/'.$card_image; 
    copy($pic1,$tpath1);
    $data = array( 
        'category_id'  =>  $_POST['category_id'],
        'card_image'  =>  $card_image,
    );    
    $qry = Insert('invitation_card_image',$data);  

    $_SESSION['msg']="10";
    header( "Location:manage_card_image.php");
    exit; 

  }
  
  // Select category
  if(isset($_GET['card_image_id']))
  {
       
      $qry="SELECT * FROM invitation_card_image WHERE `id`='".$_GET['card_image_id']."'";
      $result=mysqli_query($mysqli,$qry);
      $row=mysqli_fetch_assoc($result);

  }
  // Get update category
  if(isset($_POST['submit']) and isset($_POST['card_image_id']))
  {

    $card_image='';

    if($_FILES['card_image']['name']!="")
    {
        if($row['card_image']!="")
        {
            unlink('images/thumbs/'.$row['card_image']);
            unlink('images/'.$row['card_image']);
        }

        $card_image=rand(0,99999)."_".$_FILES['card_image']['name'];

        //Main Image
        $card_image=rand(0,99999)."_".$_FILES['card_image']['name'];
        $pic1=$_FILES['card_image']['tmp_name'];  
        //Main Image         
        $tpath1='images/'.$card_image; 
        copy($pic1,$tpath1);
    }
    else{
         $card_image=$row['card_image']; 
    }

    $data = array( 
      'category_id'  =>  $_POST['category_id'],
      'card_image'  =>  $card_image,
    ); 

    $category_edit=Update('invitation_card_image', $data, "WHERE id = '".$_POST['card_image_id']."'");
    
    $_SESSION['msg']="11";
     if(isset($_GET['redirect'])){
      header("Location:".$_GET['redirect']);
    }
    else{
	header( "Location:add_card_image.php?card_image_id=".$_POST['card_image_id']);
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
            <form action="" name="addeditcardImage" method="post" class="form form-horizontal" enctype="multipart/form-data">

              <div class="section">
                <div class="section-body">
                   <div class="form-group">
                    <label class="col-md-3 control-label">Category :-</label>
                    <div class="col-md-6">
                      <select name="category_id" id="cat_id" class="select2" required>
                        <option value="">--Select Category--</option>
                        <?php while($cat_row=mysqli_fetch_array($cat_result)){?>                       
                        <option value="<?php echo $cat_row['cid'];?>"<?php if($cat_row['cid']==$row['category_id']){?>selected<?php }?>><?php echo $cat_row['category_name'];?></option>                           
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Select Card Image :-
                      <p class="control-label-help" style="color: red">(Recommended resolution: 64x64 And Image must having transparent background)</p>
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="card_image" value="fileupload" id="fileupload" onchange="readURLIcone(this);">
                            <?php if(isset($_GET['card_image_id']) and $row['card_image']!="") {?>
                              <div class="fileupload_img"><img type="image" id="category_icone" src="images/<?php echo $row['card_image'];?>" style="height: 60px;width: 60px" alt="card image" /></div>

                            <?php }else{
                              ?>
                              <div class="fileupload_img"><img type="image" id="category_icone" src="assets/images/landscape.jpg" alt="card image" style="height: 60px;width: 60px" /></div>
                              <?php
                            } ?>
                      </div>
                      
                    </div>
                  </div>
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


// Preview category image
function readURL(input) {
if (input.files && input.files[0]) {
  var reader = new FileReader();
  
  reader.onload = function(e) {
    $("input[name='card_image']").next(".fileupload_img").find("img").attr('src', e.target.result);
  }
  reader.readAsDataURL(input.files[0]);
}
}
$("input[name='card_image']").change(function() { 
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