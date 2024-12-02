<?php  	$page_title="Contact List";

  include("includes/header.php");
  include("includes/connection.php");
  require("includes/function.php");
  require("language/language.php");
   
  $tableName="tbl_contact_list";    
  $targetpage = "manage_contact_list.php";  
  $limit = 15; 

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
          <div class="card-body mrg_bottom" style="padding:0px 0px 30px 0px"> 

            <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px">
                <li role="presentation" class="active"><a href="#subject_list" aria-controls="comments" role="tab" data-toggle="tab"><i class="fa fa-comments"></i> Subjects List</a></li>
                <li role="presentation"><a href="#contact_list" aria-controls="contact_list" role="tab" data-toggle="tab"><i class="fa fa-envelope"></i> Contact Forms</a></li>
            </ul>

            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="subject_list">

                <div class="container-fluid">
                  <div class="rows">
                    <div class="col-md-12 mrg-top">
                      <div class="add_btn_primary"> <a href="contact_subject.php?add" class="btn_cust">Add Subject</a></div>
                      <div class="clearfix"></div>
                      <br/>
                      <table class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                            <th width="100">Sr No.</th>
                            <th>Subject Title</th>
                            <th class="cat_action_list" style="width:60px">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                          $sql="SELECT * FROM tbl_contact_sub ORDER BY id DESC";
                          $res=mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

                          if(mysqli_num_rows($res) > 0)
                          {
                          $no=1;
                          while ($row=mysqli_fetch_assoc($res)) {
                          ?>
                          <tr>
                            <td><?=$no++?></td>
                            <td><?=$row['title']?></td>
                            <td nowrap="">
                              <a href="contact_subject.php?edit_id=<?php echo $row['id'];?>" class="btn btn-primary btn_edit" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a>
                              <a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" data-table="tbl_contact_sub" class="btn btn-danger btn_delete" data-toggle="tooltip" data-tooltip="Delete !"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                          <?php
                              }
                            } // end of if
                            else{
                              ?>
                              <tr>
                                <td colspan="3" class="text-center">
                                  <p style="font-size: 18px" class="text-muted"><strong>Sorry!</strong> no data found.</p>
                                </td>
                              </tr>
                              <?php
                            }
                          ?>
                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>

              <!-- for contact list tab -->
              <div role="tabpanel" class="tab-pane" id="contact_list">
                <div class="container-fluid">
                  <div class="rows">
                    <div class="col-md-12 mrg-top manage_comment_btn">
                      <form method="post" action="">

                        <button type="submit" class="btn btn-danger btn_edit" style="margin-bottom:20px;" name="delete_rec" value="delete_post"><i class="fa fa-trash"></i> Delete All</button>  
                        <table class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th style="width:40px">
                                <div class="checkbox" style="margin: 0px">
                                  <input type="checkbox" name="checkall" id="checkall" value="">
                                  <label for="checkall"></label>
                                </div>
                              </th> 
                              <th>Name</th>
                              <th>Email</th>    
                              <th>Subject</th>    
                              <th>Message</th>
                              <th>Date</th>
                              <th class="cat_action_list" style="width:60px">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $users_qry="SELECT tbl_contact_list.*, sub.`title` FROM tbl_contact_list, tbl_contact_sub sub WHERE tbl_contact_list.`contact_subject`=sub.`id` ORDER BY tbl_contact_list.`id` DESC LIMIT $start, $limit";  
                   
                            $users_result=mysqli_query($mysqli,$users_qry);
                            $i=0;

                            if(mysqli_num_rows($users_result) > 0)
                            {
                            while($users_row=mysqli_fetch_array($users_result))
                            {
                         
                            ?>
                            <tr>
                               <td>  
                            <div>
                                <div class="checkbox" id="checkbox_contact">
                                  <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $users_row['id']; ?>" class="post_ids">
                                    <label for="checkbox<?php echo $i;?>">
                                  </label>
                                </div>
                            </div>
                            </td> 
                              <td><?php echo $users_row['contact_name'];?></td>
                              <td><?php echo $users_row['contact_email'];?></td>
                              <td><?php echo $users_row['title'];?></td>
                              <td><?php echo wordwrap($users_row['contact_msg'],40,"<br>\n",TRUE);?></td>
                              <td nowrap=""><?php echo date('d-m-Y',$users_row['created_at']);?></td>
                              <td>
                                <a href="javascript:void(0)" data-id="<?php echo $users_row['id'];?>" data-table="tbl_contact_list" class="btn btn-danger btn_delete" data-toggle="tooltip" data-tooltip="Delete !"><i class="fa fa-trash"></i></a>
                              </td>
                            </tr>
                           <?php
                              $i++;
                              }
                            } // end of if
                            else{
                              ?>
                              <tr>
                                <td colspan="7" class="text-center">
                                  <p style="font-size: 18px" class="text-muted"><strong>Sorry!</strong> no data found.</p>
                                </td>
                              </tr>
                              <?php
                            }
                          ?>
                          </tbody>
                        </table>
                      </form> 
                    </div>
                    <div class="col-md-12 col-xs-12">
                      <div class="pagination_item_block">
                        <nav>
                          <?php include("pagination.php");?>                 
                        </nav>
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


<?php include("includes/footer.php");?>       

<script type="text/javascript">
	
  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
    document.title = $(this).text()+" | <?=APP_NAME?>";
  });

  var activeTab = localStorage.getItem('activeTab');
  if(activeTab){
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
  }

 //for contact list delete
  $(".btn_delete").click(function(e){
      e.preventDefault();

       var _id=$(this).data("id");
       var _table=$(this).data("table");

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
              data:{'id':_id,'tbl_nm':_table,'tbl_id':'id','action':'removeData'},
              success:function(res){
                location.reload();
              }
            });
          } 
        }
      });
      confirmDlg.show();
 });


 
// for multiple actions on contact
$("button[name='delete_rec']").click(function(e){
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
					var _table='tbl_comments';

					$.ajax({
						type:'post',
						url:'processData.php',
						dataType:'json',
						data:{id:_ids,'action':'multi_delete','tbl_nm':'tbl_contact_list'},
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
 