<?php $page_title="Dashboard";


include("includes/header.php");

// Count of category
$qry_cat="SELECT COUNT(*) as num FROM tbl_category";
$total_category= mysqli_fetch_array(mysqli_query($mysqli,$qry_cat));
$total_category = $total_category['num'];

// Count of events
$qry_event="SELECT COUNT(*) as num FROM tbl_events WHERE `user_id` = 0";
$total_event = mysqli_fetch_array(mysqli_query($mysqli,$qry_event));
$total_event = $total_event['num'];

// Get counts of user events
$qry_event="SELECT COUNT(*) as num FROM tbl_events WHERE `user_id` <> 0";
$total_user_event = mysqli_fetch_array(mysqli_query($mysqli,$qry_event));
$total_user_event = $total_user_event['num'];

// Count of users
$sql="SELECT COUNT(*) as num FROM tbl_users WHERE id <> 0";
$total_users = mysqli_fetch_array(mysqli_query($mysqli,$sql));
$total_users = $total_users['num'];

// Get count of event booking
$sql="SELECT COUNT(*) as num FROM tbl_event_booking GROUP BY `event_id`";
$total_booking = mysqli_fetch_array(mysqli_query($mysqli,$sql));
$total_booking = $total_booking['num'];

 // Get counts of contact list
$sql="SELECT COUNT(*) as num FROM tbl_contact_list";
$total_contact = mysqli_fetch_array(mysqli_query($mysqli,$sql));
$total_contact = $total_contact['num'];

// Counts of reports
$sql="SELECT COUNT(*) as num FROM tbl_reports";
$total_report = mysqli_fetch_array(mysqli_query($mysqli,$sql));
$total_report = $total_report['num'];
 
// Get users graph start

$countStr='';

$no_data_status=false;
$count=$monthCount=0;

for ($mon=1; $mon<=12; $mon++) {

  $monthCount++;

  if(isset($_GET['filterByYear'])){
    $year=$_GET['filterByYear'];
  }
  else{
    $year=date('Y');
  }

  $month = date('M', mktime(0,0,0,$mon, 1, $year));

  $sql_user="SELECT `id` FROM tbl_users WHERE `created_at` <> 0 AND DATE_FORMAT(FROM_UNIXTIME(`created_at`), '%c') = '$mon' AND DATE_FORMAT(FROM_UNIXTIME(`created_at`), '%Y') = '$year'";

  $totalcount=mysqli_num_rows(mysqli_query($mysqli, $sql_user));

  $countStr.="['".$month."', ".$totalcount."], ";

  if($totalcount==0){
    $count++;
  }

}

if($monthCount > $count){
  $no_data_status=false;
}
else{
  $no_data_status=true;
}

$countStr=rtrim($countStr, ", ");

?>       


<?php 
  $sql_smtp="SELECT * FROM tbl_smtp_settings WHERE id='1'";
  $res_smtp=mysqli_query($mysqli,$sql_smtp);
  $row_smtp=mysqli_fetch_assoc($res_smtp);

  $smtp_warning=true;

  if(!empty($row_smtp))
  {

    if($row_smtp['smtp_type']=='server'){
      if($row_smtp['smtp_host']!='' AND $row_smtp['smtp_email']!=''){
        $smtp_warning=false;
      }
      else{
        $smtp_warning=true;
      }  
    }
    else if($row_smtp['smtp_type']=='gmail'){
      if($row_smtp['smtp_ghost']!='' AND $row_smtp['smtp_gemail']!=''){
        $smtp_warning=false;
      }
      else{
        $smtp_warning=true;
      }  
    }
  }

  if($smtp_warning)
  {
?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="alert alert-danger alert-dismissible fade in" role="alert">
	<h4 id="oh-snap!-you-got-an-error!"><i class="fa fa-exclamation-triangle"></i> SMTP Setting is not config<a class="anchorjs-link" href="#oh-snap!-you-got-an-error!"><span class="anchorjs-icon"></span></a></h4>
		<p style="margin-bottom: 10px">Config the smtp setting otherwise <strong>forgot password</strong> OR <strong>email</strong> feature will not be work.</p> 
	</div>
  </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
		<a href="manage_category.php" class="card card-banner card-green-light">
			<div class="card-body"> <i class="icon fa fa-sitemap fa-4x"></i>
			  <div class="content">
				<div class="title">Event Categories</div>
				<div class="value"><span class="sign"></span><?php echo $total_category;?></div>
			  </div>
			</div>
		</a> 
	</div>
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
		<a href="manage_events.php" class="card card-banner card-yellow-light">
			<div class="card-body"> <i class="icon fa fa-calendar fa-4x"></i>
			  <div class="content">
				<div class="title">Admin Events</div>
				<div class="value"><span class="sign"></span><?php echo $total_event;?></div>
			  </div>
			</div>
		</a> 
	</div>
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
		<a href="user_events.php" class="card card-banner card-aliceblue-light">
			<div class="card-body"> <i class="icon fa fa-calendar fa-4x"></i>
			  <div class="content">
				<div class="title">Users Events</div>
				<div class="value"><span class="sign"></span><?php echo $total_user_event;?></div>
			  </div>
			</div>
		</a> 
	</div>	
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
		<a href="manage_users.php" class="card card-banner card-pink-light">
			<div class="card-body"> <i class="icon fa fa-users fa-4x"></i>
			  <div class="content">
				<div class="title">Users</div>
				<div class="value"><span class="sign"></span><?php echo $total_users;?></div>
			  </div>
			</div>
		</a> 
	</div>
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
		<a href="event_booking.php" class="card card-banner card-blue-light">
			<div class="card-body"> <i class="icon fa fa-book fa-4x"></i>
			  <div class="content">
				<div class="title">Event Booking</div>
				<div class="value"><span class="sign"></span><?php echo ($total_booking!='') ? $total_booking : '0';?></div>
			  </div>
			</div>
		</a> 
	</div>
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
	  <a href="manage_contact_list.php" class="card card-banner card-orange-light">
		<div class="card-body"> <i class="icon fa fa-envelope fa-4x"></i>
		  <div class="content">
			<div class="title">Contact List</div>
			<div class="value"><span class="sign"></span><?php echo $total_contact;?></div>
		  </div>
		</div>
	  </a> 
	</div>
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mr_bot60"> 
	  <a href="manage_report.php" class="card card-banner card-alicerose-light">
		<div class="card-body"> <i class="icon fa fa-bug fa-4x"></i>
		  <div class="content">
			<div class="title">Reports</div>
			<div class="value"><span class="sign"></span><?php echo $total_report;?></div>
		  </div>
		</div>
		</a> 
	</div>   
</div>	
<div class="clearfix"></div>
<div class="row">
	<div class="col-lg-12">
    <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 2px;">
      <div class="col-lg-10">
        <h3>Users Analysis</h3>
      </div>
      <div class="col-lg-2" style="padding-top: 20px">
        <form method="get" id="graphFilter">
          <select class="form-control" name="filterByYear" style="box-shadow: none;height: auto;border-radius: 0px;font-size: 16px;">
            <?php 
              $currentYear=date('Y');
              $minYear=2018;

              for ($i=$currentYear; $i >= $minYear ; $i--) { 
                ?>
                <option value="<?=$i?>" <?=(isset($_GET['filterByYear']) && $_GET['filterByYear']==$i) ? 'selected' : ''?>><?=$i?></option>
                <?php
              }
            ?>
          </select>
        </form>
      </div>
      <div class="col-lg-12">
        <?php 
          if($no_data_status){
            ?>
            <h3 class="text-muted text-center" style="padding-bottom: 2em">No data found !</h3>
            <?php
          }
          else{
            ?>
         <div id="registerChart">
              <p style="text-align: center;"><i class="fa fa-spinner fa-spin" style="font-size:3em;color:#aaa;margin-bottom:50px" aria-hidden="true"></i></p>
            </div>
            <?php    
          }
        ?>
      </div>
    </div>
  </div>
</div>  
<br>

<br>
<?php include("includes/footer.php");?>       

<?php 
if(!$no_data_status){
  ?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Month');
      data.addColumn('number', 'Total Users');

      data.addRows([<?=$countStr?>]);

      var options = {
        curveType: 'function',
        fontSize: 15,
        hAxis: {
          title: "Months of <?=(isset($_GET['filterByYear'])) ? $_GET['filterByYear'] : date('Y')?>",
          titleTextStyle: {
            color: '#000',
            bold:'true',
            italic: false
          },
        },
        vAxis: {
          title: "Nos. of Users",
          titleTextStyle: {
            color: '#000',
            bold:'true',
            italic: false,
          },
          gridlines: { count: -1},
          format: '#',
          viewWindowMode: "explicit", viewWindow: {min: 0, max: 'auto'},
        },
        height: 400,
        chartArea:{
          left:50,top:20,width:'100%',height:'auto'
        },
        legend: {
          position: 'bottom'
        },
        colors: ['#3366CC', 'green','red'],
        lineWidth:4,
        animation: {
          startup: true,
          duration: 1200,
          easing: 'out',
        },
        pointSize: 5,
        pointShape: "circle",

      };
      var chart = new google.visualization.LineChart(document.getElementById('registerChart'));

      chart.draw(data, options);
    }

    $(document).ready(function () {
      $(window).resize(function(){
        drawChart();
      });
    });
  </script>
  <?php
}
?>
<script type="text/javascript">

// filter of graph
$("select[name='filterByYear']").on("change",function(e){
  $("#graphFilter").submit();
});

</script>        
