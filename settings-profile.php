<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(dirname(__FILE__)) . '/classes/profile.class.php');

$title = 'Settings';
$label = 'profile';
include_once('header.php');

if ($_SESSION['nware']['avatar']!='default.png') {
    $user_avatar = 'documents/avatar/'.$_SESSION['nware']['user_id'].'/'.$_SESSION['nware']['avatar'];
    $file_avatar = $_SESSION['nware']['avatar'];

} else {
	$user_avatar = 'documents/avatar/default.png';
    $file_avatar = 'default.png';
}

?>

	<script src="js/plugins/fileupload/bootstrap-fileupload.min.js"></script>
    <script src="js/ajaxupload.js"></script>
    <script src="js/settings-profile.js"></script>

<div class="container-fluid" id="content">

    <?php include_once('pages/settings-nav-left.php'); ?>

    <div id="main">
		<div class="container-fluid">

            <?php include_once('pages/settings-page-header.php'); ?>

			<div class="row-fluid">
				<div class="span12">
					<div class="box">
						<div class="box-title">
							<h3>
								<i class="icon-user"></i>
								Profile - Edit
							</h3>
						</div>
						<div class="box-content">
							    <div class="row-fluid">
								    <div style="width:220px; margin-bottom:30px; float:left;">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
										    <div class="fileupload-new thumbnail" style="width:200px; height:150px; max-width: 200px; max-height: 150px;"><img src="<?php echo $user_avatar; ?>" /></div>
											<div class="fileupload-preview fileupload-exists thumbnail" style="width:200px; height:150px; max-width: 200px; max-height: 150px; line-height: 20px;"></div>
											<div>
											    <span class="btn btn-file"><span class="fileupload-new">Select image</span>
                                                <span class="fileupload-exists" >Change</span><input type="file"  name="fileToUpload" id="fileToUpload" onchange="filechange()"/></span>
												<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
											</div>
										</div>
                                    </div>

									<div class="span7" style="float:left;">
                                        <form action="settings-profile.php" class="form-horizontal" method="post" id="isForm">
                                                <input type="hidden" name="avatar" id="avatar" value="<?php echo $file_avatar; ?>"/>
                                                <div class="control-group">
                        					        <label class="control-label" for="CurrentPass">Current password</label>
                        					        <div class="controls">
                        						        <input type="password" autocomplete="off" class="input-xlarge span9" id="CurrentPass" name="CurrentPass" placeholder="Required for Update">
                        					        </div>
                        				        </div>
                        				        <div class="control-group">
                        					        <label class="control-label" for="name">Name</label>
                        					        <div class="controls">
                        						        <input type="text" class="input-xlarge span9" id="name" name="name" value="<?php echo $profile->getField('name'); ?>">
                        					        </div>
                        				        </div>
                        				        <div class="control-group">
                        					        <label class="control-label" for="email">Email</label>
                        					        <div class="controls">
                        						        <input type="email" class="input-xlarge span9" id="email" name="email" value="<?php echo $profile->getField('email'); ?>">
                        					        </div>
                        				        </div>
                        				        <div class="control-group">
                        					        <label class="control-label" for="password">New password</label>
                        					        <div class="controls">
                        						        <input type="password" autocomplete="off" class="input-xlarge span9" id="password" name="password" placeholder="Leave blank for no change">
                        					        </div>
                        				        </div>
                        				        <div class="control-group">
                        					        <label class="control-label" for="confirm">New password again</label>
                                                    <div class="controls">
                        						        <input type="password" autocomplete="off" class="input-xlarge span9" id="confirm" name="confirm">
                        					        </div>
                                                </div>
                                                <div class="form-actions">
        										    <input type="button" class='btn btn-primary' value="Save" onclick="savepic()">
                                                    <input type="reset" class='btn' value="Cancel">
                                                    <div style="width:0px; overflow:hidden"><input type="submit" /></div>
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

<?php
include("footer.php");
?>