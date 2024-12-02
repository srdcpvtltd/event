<?php 

	include('includes/header.php'); 
	include('includes/function.php');
	include('language/language.php'); 

	$event_id=$_GET['event_id'];

	$sql="SELECT tbl_events.*,tbl_category.`category_name` FROM tbl_events
        LEFT JOIN tbl_category ON tbl_events.`cat_id`= tbl_category.`cid` 
        WHERE tbl_events.`id`='$event_id'
        ORDER BY tbl_events.`id`";

    $res=mysqli_query($mysqli,$sql);

    $row=mysqli_fetch_assoc($res);


?>

<style type="text/css">
	.rewards_point_page_title{
		background: #e8e8e8;
	    font-family: "Poppins", sans-serif;
	    font-size: 18px;
	    border: 1px solid rgba(0, 0, 0, 0.1);
	    font-weight: 600;
	    display: inline-block;
	    width: 100%;
	    color: #424242;
	    padding: 10px 0;
	    margin-bottom: 0px;
	    text-align: left;
	}
	.rewards_point_page_title .page_title{
		padding: 12px 0;
	}
	.rewards_point_page_title .page_title h3 {
	    padding: 0;
	    margin: 0;
	}
</style>

<div class="row">
    <div class="col-md-12">
    	<div class="card">
        	<div class="card-body pt_top">
      			<div class="rewards_point_page_title">
        			<div class="col-md-12 col-xs-12">
          				<img src="assets/images/event_img.jpg" alt="">							
          				<div class="page_item_contant">
            				<div class="row">
								<div class="col-md-4">
									<div class="page_item_event">
										<h3>When</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
										<h3>Where</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
									</div>
								</div>
								<div class="col-md-8">
									<div class="page_item_detail">
										<h1>When</h1>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>										
										<table class="table table-bordered">
											<thead>
											  <tr>
												<th>Firstname</th>
												<th>Lastname</th>
												<th>Email</th>
											  </tr>
											</thead>
											<tbody>
											  <tr>
												<td>John</td>
												<td>Doe</td>
												<td>john@example.com</td>
											  </tr>
											  <tr>
												<td>Mary</td>
												<td>Moe</td>
												<td>mary@example.com</td>
											  </tr>
											  <tr>
												<td>July</td>
												<td>Dooley</td>
												<td>july@example.com</td>
											  </tr>
											</tbody>
										  </table>
									</div>
								</div>
							</div>
          				</div>
        			</div>              
      			</div>   
      		</div>
      	</div>
    </div>
</div>


<?php include('includes/footer.php');?> 

