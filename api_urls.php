<?php $page_title="Api Urls";
    include("includes/header.php");
    include("includes/function.php");

    $file_path = getBaseUrl().'api.php';

?>
<div class="row">
    <div class="col-sm-12 col-xs-12">
      	<?php
      	if(isset($_SERVER['HTTP_REFERER']))
      	{
      		echo '<a href="'.$_SERVER['HTTP_REFERER'].'"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
      	}
      	?>
        <div class="card">
            <div class="card-header">
              Example API urls
            </div>
                <div class="card-body no-padding">
               <pre>
                <code class="html">
                    <br><b>API URL</b>&nbsp; <?php echo $file_path;?>
               		
                    <br><b>Home</b>(Method: get_home) (Parameters: user_id,user_lat,user_long)
                    <br><b>Recent View</b>(Method: recent_views_all) (Parameters: user_id,page)
                    <br><b>Near By List</b>(Method: get_nearby) (Parameters: user_lat, user_long,user_id,page)
                    <br><b>Category List</b>(Method: get_category) (Parameters: page)
                    <br><b>Category upload</b>(Method: get_category_upload)
                    <br><b>Card Images List</b>(Method: get_card_images) (Parameters: page)
                    <br><b>Edit Event Details</b>(Method: get_edit_event) (Parameters: event_id)
                    <br><b>Category Wise Events</b>(Method: events_by_cat) (Parameters: user_id,cat_id, page)
                    <br><b>Single Event</b>(Method: single_event) (Parameters: event_id,user_id)
                    <br><b>Search Event</b>(Method: search_event) (Parameters: event_search, user_id,page)
                    <br><b>User Event List</b>(Method: get_user_events) (Parameters: user_id, page)
                    <br><b>User Add Event</b>(Method: add_event) (Parameters: user_id, cat_id, event_title, event_description, event_email, event_phone, event_website, event_address, event_map_latitude, event_map_longitude, event_start_date, event_start_time, event_end_date, event_end_time, registration_start_date, registration_start_time, registration_end_date, registration_end_time, event_ticket, person_wise_ticket, ticket_price,website) (Files: event_logo, event_banner, event_cover[])
                    <br><b>User Edit Event</b>(Method: edit_event) (Parameters: event_id, user_id, cat_id, event_title, event_description, event_email, event_phone, event_website, event_address, event_map_latitude, is_event,event_map_longitude, event_start_date, event_start_time, event_end_date, event_end_time, registration_start_date, registration_start_time, registration_end_date, registration_end_time, event_ticket, person_wise_ticket, ticket_price,website) (Files: event_logo, event_banner, event_cover[])
                    <br><b>Delete Event</b>(Method: delete_event)(Parameter: event_id)
                    <br><b>User Event Booking</b>(Method: event_booking) (Paramater: event_id, user_id)
                    <br><b>Add Event Image</b>(Method: add_event_image) (Parameters: user_id, event_id) (Files: event_image)
                    <br><b>Add Event Feed</b>(Method: add_event_feed) (Parameters: user_id, event_id,event_feed,date)                    
                    <br><b>Get Event Feed List</b>(Method: get_event_feed) (Parameters: event_id,page)
                    <br><b>Get Event Media List</b>(Method: get_event_media) (Parameters: event_id,page)
                    <br><b>Delete Event Media</b>(Method: delete_event_media)(Parameter: event_media_id)
                    <br><b>Add Event Invitation</b>(Method: add_event_invitation) (Parameters: event_id) (File: image)
                    <br><b>Get Event Invitation List</b>(Method: get_event_invitation) (Parameters: event_id,page)
                    <br><b>Get All Event Media List</b>(Method: get_all_event_media) (Parameters: page)
                    <br><b>Event Media Favourite / UnFavourite</b>(Method: add_event_media_favourite) (Parameters: event_media_id, user_id)</span>
                    <br><b>Add Event Media Comment</b>(Method: add_event_media_comment) (Parameters: user_id, event_id,event_media_id,comment)
                    <br><b>Add Event Media Comment Reply</b>(Method: add_event_media_comment_reply) (Parameters: user_id, reply,comment_id)
                    <br><b>Get Event Comments</b>(Method: get_event_media_comment) (Parameters: event_media_id,page)
                    <br><b>Get Event Comment Reply</b>(Method: add_media_comment_reply) (Parameters: comment_id,page)
                    <br><b>Delete Event Comment</b>(Method: delete_event_media_comment) (Parameters: comment_id,user_id)
                    <br><b>Delete Event Comment Reply</b>(Method: delete_event_media_comment_reply) (Parameters: comment_reply_id,user_id)
                    <br><b>Like Comment</b>(Method: add_event_media_comment_likes) (Parameters: comment_id, user_id)</span>
                    <br><b>DisLike Comment</b>(Method: add_event_media_comment_dislikes) (Parameters: comment_id, user_id)</span>
                    <br><b>Like Comment Reply</b>(Method: add_event_media_comment_reply_likes) (Parameters: comment_reply_id, user_id)</span>
                    <br><b>DisLike Comment Reply</b>(Method: add_event_media_comment_reply_dislikes) (Parameters: comment_reply_id, user_id)</span>
                    <br><b>User Register</b>(Method: user_register)(Parameter: type [google,normal,facebook] name,email,password,phone,auth_id,device_id)
                    <br><b>User Login</b>(Method: user_login)(Parameter: email, passwor)
                    <br><b>User Profile</b>(Method: user_profile)(Parameter: id)
                    <br><b>User Profile Update</b>(Method: user_profile_update)(Parameter:user_id, name, password, phone, city, address, is_remove[true, false]) (File: user_image)
                    <br><b>Forgot Password</b>(Method: user_forgot_pass)(Parameter: email)
                    <br><b>Check User Status</b>(Method: user_status) (Parameter: user_id)
                    <br><b>Favourite/Unfavourite</b>(Method: add_favourite) (Parameters: event_id, user_id)</span>
              		<br><b>Get Favorite List</b>(Method: get_favourite_list) (Parameters: user_id,page)
                    <br><b>Get Tickets</b>(Method: get_tickets)(Parameter: event_id,user_id)
                    <br><b>Booked Events</b>(Method: booked_events)(Parameter: user_id,page)
                    <br><b>Remove Cover Image</b>(Method: remove_cover)(Parameter: image_id)
                    <br><b>Contact Subjects</b>(Method: get_contact) (Parameter: user_id)
                    <br><b>User Contact Us</b>(Method: user_contact_us)(Parameter: contact_email,contact_name,contact_phone,contact_msg,contact_subject)
                    <br><b>Report Event</b> (Method: event_report)(Parameter: report_user_id,report_event_id,report_type,report_text)
                    <br><b>Download Ticket</b>(Method: download_ticket)(Parameter: booking_id)
                    <br><b>View Ticket</b>(Method: view_ticket)(Parameter: booking_id,is_dark[true,false])
                    <br><b>Download Users Excel Sheet</b>(Method: event_user_list)(Parameter: event_id)
                    <br><b>Change Password</b>(Method: change_password) (Parameters: user_id, old_password, new_password)
                    <br><b>Get Locations</b>(Method: get_locations) (Parameters: keyword)
                    <br><b>App Privacy Policy</b>(Method: app_privacy_policy)
                    <br><b>App Terms & Conditions</b>(Method: app_terms_conditions)
                    <br><b>App Faq</b>(Method: app_faq)
			  		<br><b>App About Details</b>(Method: app_about)
                    <br><b>App Details</b>(Method: get_app_details)
                </code> 
             </pre>
              </div>
            </div>
        </div>
</div>
<br/>
<div class="clearfix"></div>
        
<?php include("includes/footer.php");?>       
