<?php $page_title=(isset($_GET['user_id'])) ? 'Edit User' : 'Add User'; 

include('includes/header.php');

include('includes/function.php');
include('language/language.php'); 

require_once("thumbnail_images.class.php");

if(isset($_POST['submit']) and isset($_GET['add']))
{		

	if($_FILES['user_image']['name']!="")
	{
		$user_image=rand(0,99999)."_".$_FILES['user_image']['name'];

        //Main Image
		$tpath1='images/'.$user_image;        
		$pic1=compress_image($_FILES["user_image"]["tmp_name"], $tpath1, 80);

		$data = array(
			'user_type'=>'Normal',	
			'name'  =>  cleanInput($_POST['name']),
			'email'  =>  cleanInput($_POST['email']),
			'password'  =>  md5(trim($_POST['password'])),
			'phone'  =>  $_POST['phone'],
			'city'  =>  cleanInput($_POST['city']),
			'address'  =>  addslashes($_POST['address']),
			'user_image' => $user_image,
			'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
		);

	}
	else
	{
		$data = array(
			'user_type'=>'Normal',	
			'name'  =>  cleanInput($_POST['name']),
			'email'  =>  cleanInput($_POST['email']),
			'password'  =>  md5(trim($_POST['password'])),
			'phone'  =>  $_POST['phone'],
			'city'  =>  cleanInput($_POST['city']),
			'address'  =>  addslashes($_POST['address']),
			'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
		);
	} 

	$qry = Insert('tbl_users',$data);

	$_SESSION['msg']="10";
	header("location:manage_users.php");	 
	exit;

}

if(isset($_GET['user_id']))
{

	$user_qry="SELECT * FROM tbl_users WHERE `id`='".$_GET['user_id']."'";
	$user_result=mysqli_query($mysqli,$user_qry);
	$user_row=mysqli_fetch_assoc($user_result);

}

if(isset($_POST['submit']) and isset($_POST['user_id']))
{ 

	if($_FILES['user_image']['name']!="")
	{	
		if($user_row['user_image']!="")
		{
			unlink('images/'.$user_row['user_image']);
		}

		$user_image=rand(0,99999)."_".$_FILES['user_image']['name'];

          //Main Image
		$tpath1='images/'.$user_image;        
		$pic1=compress_image($_FILES["user_image"]["tmp_name"], $tpath1, 80);

	}
	else
	{
		$user_image=$_POST['old_user_image'];
	}  


	if($_POST['password']!="")
	{
		$data = array(
			'name'  =>  cleanInput($_POST['name']),
			'email'  =>  cleanInput($_POST['email']),
			'password'  =>  md5(trim($_POST['password'])),
			'phone'  =>  $_POST['phone'],
			'city'  =>  cleanInput($_POST['city']),
			'address'  =>  addslashes($_POST['address']),
			'user_image' => $user_image
		);
	}
	else
	{
		$data = array(
			'name'  =>  cleanInput($_POST['name']),
			'email'  =>  cleanInput($_POST['email']),			 
			'phone'  =>  $_POST['phone'],
			'city'  =>  cleanInput($_POST['city']),
			'address'  =>  addslashes($_POST['address']),
			'user_image' => $user_image 
		);
	}


	$user_edit=Update('tbl_users', $data, "WHERE id = '".$_POST['user_id']."'");

	$_SESSION['msg']="11";
	if(isset($_GET['page']))
		header( "Location:manage_users.php?page=".$_GET['page']);
	else
		header( "Location:manage_users.php");
	exit;

}

?>


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
            <form action="" name="addedituser" method="post" class="form form-horizontal" enctype="multipart/form-data" >
            	<input  type="hidden" name="user_id" value="<?php echo $_GET['user_id'];?>" />

              <div class="section">
                <div class="section-body">                   
                  <div class="form-group">
                    <label class="col-md-3 control-label">Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="name" id="name" value="<?php if(isset($_GET['user_id'])){echo $user_row['name'];}?>" class="form-control" required>
                    </div>
                  </div>
                 <?php if (!isset($_GET['user_id']) OR ($user_row['user_type']) == 'Normal') { ?>
                  <div class="form-group"> 
                    <label class="col-md-3 control-label">Email :-</label>
                    <div class="col-md-6">
                      <input type="email" name="email" id="email" value="<?php if(isset($_GET['user_id'])){echo $user_row['email'];}?>" class="form-control" required>
                    </div>
                  </div>
                  <?php }else{?>
                  	<div class="form-group">
                    <label class="col-md-3 control-label">Email :-</label>
                    <div class="col-md-6">
                      <input type="email" name="email" id="email" readonly="" value="<?php if(isset($_GET['user_id'])){echo $user_row['email'];}?>" class="form-control" required>
                    </div>
                  </div>
                  	<?php }?>
                  <?php if (!isset($_GET['user_id']) OR ($user_row['user_type']) == 'Normal') { ?>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Password :-</label>
                    <div class="col-md-6">
                      <input type="password" name="password" id="password" value="" class="form-control" <?php if(!isset($_GET['user_id'])){?>required<?php }?>>
                    </div>
                  </div>
                 <?php }?>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Phone :-</label>
                    <div class="col-md-6">
                      <input type="text" name="phone" id="phone" value="<?php if(isset($_GET['user_id'])){echo $user_row['phone'];}?>" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">City :-</label>
                    <div class="col-md-6">
                      <input type="text" name="city" id="city" value="<?php if(isset($_GET['user_id'])){echo $user_row['city'];}?>" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Address :-</label>
                    <div class="col-md-6">
                      <input type="text" name="address" id="address" value="<?php if(isset($_GET['user_id'])){echo $user_row['address'];}?>" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">User Image :-</label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="user_image" value="" id="fileupload" onchange="readURL(this)">
                            <?php if(isset($_GET['user_id']) and $user_row['user_image']!="") {?>
                            <input type="hidden" name="old_user_image" value="<?php echo $user_row['user_image'];?>" id="fileupload">
                            <div class="fileupload_img"><img type="image" id="user_image" src="images/<?php echo $user_row['user_image'];?>" style="width: 90px;height: 90px" alt=" image" /></div>
                          <?php } else {?>
                            <div class="fileupload_img"><img type="image" id="user_image" src="assets/images/landscape.jpg" style="width: 90px;height: 90px" alt="category image" /></div>
                          <?php }?>
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
   

<?php include('includes/footer.php');?>                  

<script type="text/javascript">

function readURL(input) {
if (input.files && input.files[0]) {
  var reader = new FileReader();
  
  reader.onload = function(e) {
    $("input[name='user_image']").next(".fileupload_img").find("img").attr('src', e.target.result);
  }
  reader.readAsDataURL(input.files[0]);
}
}
$("input[name='user_image']").change(function() { 
readURL(this);
});

</script>  