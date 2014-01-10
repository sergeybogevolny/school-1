<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/agency_messages.class.php');

$title = 'messages';
$label = 'messages';
include('header.php');
//print_r($_SESSION['nware']);
include_once('classes/listbox.class.php');
$userEmail = $listbox->getUserEmail();


$messages = new Agency_messages();

?>
<style>
.inbox .inbox-header {
	overflow: hidden;
}
.inbox-view-header {
	margin-bottom: 20px;
}
.inbox-view-info {
	border-bottom: 1px solid #EEEEEE;
	border-top: 1px solid #EEEEEE;
	color: #666666;
	margin-bottom: 10px;
	padding: 5px 0;
}
.bold {
	font-weight: 600 !important;
}
.inbox-view-info .inbox-info-btn {
	text-align: right;
}
.inbox-view-info {
	color: #666666;
}
.inbox-view {
	color: #666666;
	padding: 15px 0 0;
}
.dropdown-menu li > a {
	clear: both;
	color: #333333;
	display: block;
	font-weight: normal;
	line-height: 18px;
	padding: 6px 0 6px 13px;
	text-decoration: none;
	white-space: nowrap;
}
.unread{
	font-weight: 600 !important;
	}
.toolpad{
	margin-top:0px !important;
	}
</style>
<script src="js/agency-messages.js"></script>

<div class="container-fluid" id="content">
  <?php include_once('pages/messages-nav-left.php'); ?>
  <div id="main">
    <div class="container-fluid">
      <?php include_once('pages/messages-page-header.php'); ?>
      <div class="box">
       
         
            <div class="box-title">
                <!-- id for list-label, remove nested -->
                <h3 id="message-label"></h3>
                <!-- id for list-actions -->
                <div id="list-actions" class="actions">
                    <a href="javascript:LoadMessageForm();" id="bonds-add" class="btn btn-mini">
                        <i class="icon-plus"></i>
                    </a>
                </div>
            </div>        
       
        
        
        
        <div class="box-content">
          <div class="row-fluid">
            <div class="span12">
              <div class="inbox-loading" style="display: none;">Loading...</div>
              <div class="inbox-content">
                <?php //$messages->getMessageList(); ?>
              </div>
              <div id='new-message-box' style="display:none">
                <div class="row-fluid">
                  <div class="span6">
                    <div class="box">
                      <div class="box-content nopadding">
                        <form method="POST" class='form-horizontal form-bordered' id='message-form'>
                          <div class="control-group">
                            <label for="textfield" class="control-label">To</label>
                            <div class="controls">
                              <input type="text" name="message-to" id="message-to" class="input-block-level">
                            </div>
                          </div>
                          <div class="control-group">
                            <label for="textfield" class="control-label">Subject</label>
                            <div class="controls">
                              <input type="text" name="message-subject" id="message-subject" class="input-block-level">
                            </div>
                          </div>
                          <div class="control-group">
                            <label for="textfield" class="control-label">Body</label>
                            <div class="controls">
                              <textarea name="message-body" id="message-body" class="input-block-level"></textarea>
                            </div>
                          </div>
                          <div class="form-actions">
                            <button type="submit" class="btn btn-primary" name="note-save" id="message-send">Send</button>
                            <button type="button" class="btn" name="message-cancel" id="message-cancel">Cancel</button>
                          </div>
                        </form>
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
  </div>
  
  <!-- id for *-box, insert window body, change class horizontal --> 
  
</div>
<div id='jqxWindow-status' style="display:none">
<div></div>
<div></div>
</div>

<div id='jqxWindow-confirm' style="display:none">
<div></div>
<div>
    <span>Confirm</span>
    <button type="button" class="btn" id="confirm-no">No</button>
	<button type="button" class="btn" id="confirm-yes">Yes</button>
</div>
</div>
<?php
include("footer.php");
?>
